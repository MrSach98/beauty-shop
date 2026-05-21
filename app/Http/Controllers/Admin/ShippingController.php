<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Models\ShippingSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingController extends Controller
{
    // ── Zones List ───────────────────────────────────────
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ShippingZone::latest())
                ->addIndexColumn()
                ->addColumn('states_col', function ($row) {
                    $states = $row->states ?? [];
                    if (empty($states)) {
                        return '<span class="badge bg-secondary">All States</span>';
                    }
                    $show = array_slice($states, 0, 3);
                    $html = implode(', ', $show);
                    if (count($states) > 3) {
                        $html .= ' <span class="badge bg-info">+'.
                                 (count($states)-3).' more</span>';
                    }
                    return '<small>'.$html.'</small>';
                })
                ->addColumn('charges_col', function ($row) {
                    $html = '<div class="small">';
                    $html .= 'Base: <strong>₹'.number_format($row->base_charge, 2).'</strong><br>';
                    if ($row->free_above) {
                        $html .= 'Free above: <strong class="text-success">₹'.
                                 number_format($row->free_above, 2).'</strong><br>';
                    }
                    if ($row->cod_available) {
                        $html .= 'COD: <strong>₹'.number_format($row->cod_charge, 2).'</strong>';
                    } else {
                        $html .= '<span class="text-danger">COD: Not Available</span>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('status_col', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input zone-status-toggle"
                               type="checkbox" data-id="'.$row->id.'" '.$checked.'>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning edit-zone-btn me-1"
                            data-id="'.$row->id.'"
                            data-name="'.$row->name.'"
                            data-states="'.htmlspecialchars(json_encode($row->states ?? [])).'"
                            data-base_charge="'.$row->base_charge.'"
                            data-free_above="'.$row->free_above.'"
                            data-cod_available="'.($row->cod_available ? 1 : 0).'"
                            data-cod_charge="'.$row->cod_charge.'"
                            data-status="'.($row->status ? 1 : 0).'">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-zone-btn"
                            data-id="'.$row->id.'"
                            data-name="'.$row->name.'">
                            <i class="bi bi-trash"></i>
                        </button>';
                })
                ->rawColumns(['states_col','charges_col','status_col','action'])
                ->make(true);
        }

        $states   = ShippingZone::indianStates();
        $settings = [
            'global_shipping_enabled' => ShippingSetting::get('global_shipping_enabled', '1'),
            'global_cod_enabled'      => ShippingSetting::get('global_cod_enabled', '1'),
            'global_free_shipping_above' => ShippingSetting::get('global_free_shipping_above', ''),
            'default_shipping_charge' => ShippingSetting::get('default_shipping_charge', '50'),
            'cod_charge'              => ShippingSetting::get('cod_charge', '0'),
            'delivery_partner'        => ShippingSetting::get('delivery_partner', ''),
            'tracking_url'            => ShippingSetting::get('tracking_url', ''),
        ];

        return view('admin.shipping.index', compact('states', 'settings'));
    }

    // ── Store Zone ───────────────────────────────────────
    public function storeZone(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'base_charge'  => 'required|numeric|min:0',
            'free_above'   => 'nullable|numeric|min:0',
            'cod_charge'   => 'nullable|numeric|min:0',
        ]);

        ShippingZone::create([
            'name'          => $request->name,
            'states'        => $request->states ?? [],
            'base_charge'   => $request->base_charge,
            'free_above'    => $request->free_above,
            'cod_available' => $request->boolean('cod_available'),
            'cod_charge'    => $request->cod_charge ?? 0,
            'status'        => $request->boolean('status'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shipping zone created successfully!'
        ]);
    }

    // ── Update Zone ──────────────────────────────────────
    public function updateZone(Request $request, $id)
    {
        $zone = ShippingZone::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'base_charge' => 'required|numeric|min:0',
            'free_above'  => 'nullable|numeric|min:0',
            'cod_charge'  => 'nullable|numeric|min:0',
        ]);

        $zone->update([
            'name'          => $request->name,
            'states'        => $request->states ?? [],
            'base_charge'   => $request->base_charge,
            'free_above'    => $request->free_above,
            'cod_available' => $request->boolean('cod_available'),
            'cod_charge'    => $request->cod_charge ?? 0,
            'status'        => $request->boolean('status'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shipping zone updated successfully!'
        ]);
    }

    // ── Delete Zone ──────────────────────────────────────
    public function destroyZone($id)
    {
        ShippingZone::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Shipping zone deleted successfully!'
        ]);
    }

    // ── Toggle Zone Status ───────────────────────────────
    public function toggleZone(Request $request)
    {
        $zone = ShippingZone::findOrFail($request->id);
        $zone->status = !$zone->status;
        $zone->save();
        return response()->json(['success' => true, 'status' => $zone->status]);
    }

    // ── Save Global Settings ─────────────────────────────
    public function saveSettings(Request $request)
    {
        $request->validate([
            'default_shipping_charge'    => 'required|numeric|min:0',
            'cod_charge'                 => 'required|numeric|min:0',
            'global_free_shipping_above' => 'nullable|numeric|min:0',
        ]);

        ShippingSetting::set('global_shipping_enabled',    $request->boolean('global_shipping_enabled') ? '1' : '0');
        ShippingSetting::set('global_cod_enabled',         $request->boolean('global_cod_enabled') ? '1' : '0');
        ShippingSetting::set('global_free_shipping_above', $request->global_free_shipping_above ?? '');
        ShippingSetting::set('default_shipping_charge',    $request->default_shipping_charge);
        ShippingSetting::set('cod_charge',                 $request->cod_charge);
        ShippingSetting::set('delivery_partner',           $request->delivery_partner ?? '');
        ShippingSetting::set('tracking_url',               $request->tracking_url ?? '');

        return redirect()->route('admin.shipping.index')
                         ->with('success', 'Shipping settings saved successfully!');
    }
}