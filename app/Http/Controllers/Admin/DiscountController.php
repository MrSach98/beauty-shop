<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DiscountCode::query();

            if ($request->status !== null && $request->status !== '') {
                $query->where('status', $request->status);
            }
            if ($request->type) {
                $query->where('type', $request->type);
            }

            return DataTables::of($query->latest())
                ->addIndexColumn()
                ->addColumn('type_col', function ($row) {
                    return $row->type === 'percentage'
                        ? '<span class="badge bg-primary">% Percentage</span>'
                        : '<span class="badge bg-success">₹ Fixed Amount</span>';
                })
                ->addColumn('value_col', function ($row) {
                    return $row->type === 'percentage'
                        ? '<strong>'.$row->value.'%</strong>'
                        : '<strong>₹'.number_format($row->value, 2).'</strong>';
                })
                ->addColumn('usage_col', function ($row) {
                    $limit = $row->usage_limit ?? '∞';
                    $color = $row->isUsageLimitReached() ? 'danger' : 'info';
                    return '<span class="badge bg-'.$color.'">'.
                           $row->used_count.' / '.$limit.'</span>';
                })
                ->addColumn('validity_col', function ($row) {
                    $html = '';
                    if ($row->start_date) {
                        $html .= '<small class="text-muted d-block">From: '.
                                 $row->start_date->format('d M Y').'</small>';
                    }
                    if ($row->end_date) {
                        $cls   = $row->isExpired() ? 'text-danger fw-bold' : 'text-success';
                        $html .= '<small class="'.$cls.' d-block">To: '.
                                 $row->end_date->format('d M Y').'</small>';
                        if ($row->isExpired()) {
                            $html .= '<span class="badge bg-danger">Expired</span>';
                        }
                    }
                    if (!$row->start_date && !$row->end_date) {
                        $html = '<span class="text-muted small">No Limit</span>';
                    }
                    return $html;
                })
                ->addColumn('status_col', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input discount-status-toggle"
                               type="checkbox" data-id="'.$row->id.'" '.$checked.'>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('admin.discounts.edit', $row->id).'"
                           class="btn btn-sm btn-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger delete-discount-btn"
                            data-id="'.$row->id.'"
                            data-code="'.$row->code.'">
                            <i class="bi bi-trash"></i>
                        </button>';
                })
                ->rawColumns(['type_col','value_col','usage_col','validity_col','status_col','action'])
                ->make(true);
        }

        return view('admin.discounts.index');
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        $products   = Product::where('is_active', true)->get(['id','name']);
        return view('admin.discounts.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|string|max:50|unique:discount_codes,code',
            'type'            => 'required|in:percentage,fixed',
            'value'           => 'required|numeric|min:0.01',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount'    => 'nullable|numeric|min:0',
            'usage_limit'     => 'nullable|integer|min:1',
            'usage_per_user'  => 'nullable|integer|min:1',
            'applicable_on'   => 'required|in:all,category,product',
            'user_restriction'=> 'required|in:all,new_users',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
        ]);

        DiscountCode::create([
            'code'             => strtoupper($request->code),
            'type'             => $request->type,
            'value'            => $request->value,
            'min_order_value'  => $request->min_order_value  ?? 0,
            'max_discount'     => $request->max_discount,
            'usage_limit'      => $request->usage_limit,
            'usage_per_user'   => $request->usage_per_user   ?? 1,
            'applicable_on'    => $request->applicable_on,
            'applicable_ids'   => $request->applicable_ids   ?? null,
            'user_restriction' => $request->user_restriction,
            'start_date'       => $request->start_date ?: null,
            'end_date'         => $request->end_date   ?: null,
            'status'           => $request->has('status') ? true : false,
        ]);

        return redirect()->route('admin.discounts.index')
                         ->with('success', 'Coupon code created successfully!');
    }

    public function edit($id)
    {
        $discount   = DiscountCode::findOrFail($id);
        $categories = Category::where('status', true)->get();
        $products   = Product::where('is_active', true)->get(['id','name']);
        return view('admin.discounts.edit', compact('discount', 'categories', 'products'));
    }

    public function update(Request $request, $id)
    {
        $discount = DiscountCode::findOrFail($id);

        $request->validate([
            'code'            => 'required|string|max:50|unique:discount_codes,code,'.$id,
            'type'            => 'required|in:percentage,fixed',
            'value'           => 'required|numeric|min:0.01',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount'    => 'nullable|numeric|min:0',
            'usage_limit'     => 'nullable|integer|min:1',
            'usage_per_user'  => 'nullable|integer|min:1',
            'applicable_on'   => 'required|in:all,category,product',
            'user_restriction'=> 'required|in:all,new_users',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
        ]);

        $discount->update([
            'code'             => strtoupper($request->code),
            'type'             => $request->type,
            'value'            => $request->value,
            'min_order_value'  => $request->min_order_value  ?? 0,
            'max_discount'     => $request->max_discount,
            'usage_limit'      => $request->usage_limit,
            'usage_per_user'   => $request->usage_per_user   ?? 1,
            'applicable_on'    => $request->applicable_on,
            'applicable_ids'   => $request->applicable_ids   ?? null,
            'user_restriction' => $request->user_restriction,
            'start_date'       => $request->start_date ?: null,
            'end_date'         => $request->end_date   ?: null,
            'status'           => $request->has('status') ? true : false,
        ]);

        return redirect()->route('admin.discounts.index')
                         ->with('success', 'Coupon code updated successfully!');
    }

    public function destroy($id)
    {
        DiscountCode::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Coupon code deleted successfully!'
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $discount = DiscountCode::findOrFail($request->id);
        $discount->status = !$discount->status;
        $discount->save();
        return response()->json([
            'success' => true,
            'status'  => $discount->status
        ]);
    }

    public function generateCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (DiscountCode::where('code', $code)->exists());

        return response()->json(['code' => $code]);
    }
}