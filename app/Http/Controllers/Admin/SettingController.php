<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $general = Setting::getGroup('general');
        $payment = Setting::getGroup('payment');
        $social  = Setting::getGroup('social');
        $seo     = Setting::getGroup('seo');
        $email   = Setting::getGroup('email');

        return view('admin.settings.index',
            compact('general', 'payment', 'social', 'seo', 'email'));
    }

    public function update(Request $request)
    {
        $group = $request->group ?? 'general';

        $rules = [];

        if ($group === 'general') {
            $rules = [
                'site_name'  => 'required|string|max:100',
                'site_email' => 'nullable|email',
                'site_phone' => 'nullable|string|max:20',
                'site_logo'  => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'site_favicon' => 'nullable|image|mimes:png,ico|max:512',
            ];
        }
        if ($group === 'payment') {
            $rules = [
                'razorpay_key_id'    => 'nullable|string',
                'razorpay_key_secret'=> 'nullable|string',
            ];
        }
        if ($group === 'email') {
            $rules = [
                'smtp_host'       => 'nullable|string',
                'smtp_port'       => 'nullable|integer',
                'smtp_username'   => 'nullable|string',
                'mail_from_email' => 'nullable|email',
            ];
        }

        if (!empty($rules)) {
            $request->validate($rules);
        }

        // Handle logo upload
        if ($group === 'general') {
            if ($request->hasFile('site_logo')) {
                $old = Setting::get('site_logo');
                if ($old) $this->deleteFile('settings', $old);
                $logo = $this->uploadImage($request->file('site_logo'), 'settings');
                Setting::set('site_logo', $logo, 'general');
            }
            if ($request->hasFile('site_favicon')) {
                $old = Setting::get('site_favicon');
                if ($old) $this->deleteFile('settings', $old);
                $fav = $this->uploadImage($request->file('site_favicon'), 'settings');
                Setting::set('site_favicon', $fav, 'general');
            }
        }

        // Save all other settings
        $skip = ['_token', '_method', 'group', 'site_logo', 'site_favicon'];
        foreach ($request->except($skip) as $key => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            Setting::set($key, $value ?? '', $group);
        }

        // Boolean fields (checkboxes)
        $booleans = [
            'general' => ['maintenance_mode'],
            'payment' => ['razorpay_enabled', 'cod_enabled', 'wallet_enabled'],
        ];
        foreach ($booleans[$group] ?? [] as $bool) {
            Setting::set($bool, $request->has($bool) ? '1' : '0', $group);
        }

        // Clear all settings cache
        Cache::flush();

        return redirect()->route('admin.settings.index')
                         ->with('success', ucfirst($group).' settings saved successfully!');
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            \Mail::raw('This is a test email from '.Setting::get('site_name'), function($msg) use ($request) {
                $msg->to($request->test_email)
                    ->subject('Test Email - '.Setting::get('site_name'));
            });
            return response()->json([
                'success' => true,
                'message' => 'Test email sent to '.$request->test_email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: '.$e->getMessage()
            ], 500);
        }
    }

    private function uploadImage($file, $folder)
    {
        $dir = public_path('uploads/'.$folder);
        if (!File::exists($dir)) File::makeDirectory($dir, 0755, true);
        $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($dir, $name);
        return $name;
    }

    private function deleteFile($folder, $file)
    {
        if ($file) {
            $path = public_path('uploads/'.$folder.'/'.$file);
            if (File::exists($path)) File::delete($path);
        }
    }
}