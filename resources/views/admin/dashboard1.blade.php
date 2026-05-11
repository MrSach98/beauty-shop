@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Cards Row 1 (YOUR EXISTING CODE - kept as is) -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#FCE4EC;">
                    <i class="bi bi-cart3 fs-4" style="color:#E91E8C;"></i>
                </div>
                <div>
                    <div class="text-muted small">Today's Orders</div>
                    <div class="fw-bold fs-4">24</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#E8F5E9;">
                    <i class="bi bi-currency-rupee fs-4 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Today's Revenue</div>
                    <div class="fw-bold fs-4">₹46,280</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#E3F2FD;">
                    <i class="bi bi-people fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">New Users (Today)</div>
                    <div class="fw-bold fs-4">18</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#FFF8E1;">
                    <i class="bi bi-clock-history fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Pending Orders</div>
                    <div class="fw-bold fs-4">12</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards Row 2 (New) -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#f3e8ff;">
                    <i class="bi bi-grid fs-4" style="color:#8b5cf6;"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Products</div>
                    <div class="fw-bold fs-4">287</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#ffebee;">
                    <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Out-of-Stock</div>
                    <div class="fw-bold fs-4 text-danger">8</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#fff3e0;">
                    <i class="bi bi-chat-text fs-4" style="color:#fd7e14;"></i>
                </div>
                <div>
                    <div class="text-muted small">Reviews Pending</div>
                    <div class="fw-bold fs-4">27</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:52px;height:52px;background:#e8f5e9;">
                    <i class="bi bi-ticket-perforated fs-4 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Active Coupons</div>
                    <div class="fw-bold fs-4">9</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart + Top Selling Products -->
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i> Last 30 Days Revenue</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="200" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="mb-0"><i class="bi bi-trophy me-2"></i> Top Selling Products</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless mb-0">
                        <thead class="table-light">
                            <tr><th>Product</th><th>Qty</th><th>Revenue</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Hyaluronic Serum</td><td>342</td><td>₹1,26,540</td></tr>
                            <tr><td>Matte Lipstick - Red Velvet</td><td>287</td><td>₹85,172</td></tr>
                            <tr><td>Vitamin C Face Wash</td><td>223</td><td>₹56,870</td></tr>
                            <tr><td>Kohl Ultimate Kajal</td><td>198</td><td>₹39,204</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="mb-0"><i class="bi bi-receipt me-2"></i> Recent Orders (Last 10)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Payment</th></tr>
                </thead>
                <tbody>
                    <tr><td>#GC-1001</td><td>Riya Sharma</td><td>₹2,450</td><td><span class="badge bg-warning text-dark">Pending</span></td><td>COD</td></tr>
                    <tr><td>#GC-1002</td><td>Meera Kapoor</td><td>₹5,299</td><td><span class="badge bg-primary">Confirmed</span></td><td>Razorpay</td></tr>
                    <tr><td>#GC-1003</td><td>Anjali Nair</td><td>₹1,890</td><td><span class="badge bg-info">Processing</span></td><td>Wallet</td></tr>
                    <tr><td>#GC-1004</td><td>Kavya Singh</td><td>₹4,230</td><td><span class="badge bg-success">Shipped</span></td><td>COD</td></tr>
                    <tr><td>#GC-1005</td><td>Pooja Verma</td><td>₹7,500</td><td><span class="badge bg-secondary">Delivered</span></td><td>Razorpay</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Two Column: Low Stock Alert + Recent Reviews -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="mb-0"><i class="bi bi-exclamation-diamond text-danger me-2"></i> Low Stock Alert (Stock < 5)</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light"><tr><th>Product</th><th>Stock</th><th>Shade/Size</th></tr></thead>
                        <tbody>
                            <tr style="background:#fff0f0;"><td>Liquid Matte Lipstick</td><td class="text-danger fw-bold">2</td><td>Ruby Woo</td></tr>
                            <tr style="background:#fff0f0;"><td>Hyaluronic Acid Serum</td><td class="text-danger fw-bold">3</td><td>30ml</td></tr>
                            <tr style="background:#fff0f0;"><td>Foundation Stick</td><td class="text-danger fw-bold">0</td><td>Warm Beige</td></tr>
                            <tr style="background:#fff0f0;"><td>Mascara Waterproof</td><td class="text-danger fw-bold">4</td><td>Black</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="mb-0"><i class="bi bi-chat-square-quote me-2"></i> Recent Reviews Awaiting Approval</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 py-2">
                        <div class="d-flex justify-content-between"><strong>Riya M.</strong> <span class="text-warning">★★★★☆</span></div>
                        <small>"Amazing pigment but slight drying."</small>
                        <div class="mt-1"><button class="btn btn-sm btn-success rounded-pill me-1">Approve</button><button class="btn btn-sm btn-outline-secondary rounded-pill">Reject</button></div>
                    </div>
                    <div class="list-group-item border-0 py-2">
                        <div class="d-flex justify-content-between"><strong>Priyanka S.</strong> <span class="text-warning">★★★★★</span></div>
                        <small>"Glow is real! Reduced dark spots."</small>
                        <div><button class="btn btn-sm btn-success rounded-pill me-1">Approve</button><button class="btn btn-sm btn-outline-secondary rounded-pill">Reject</button></div>
                    </div>
                    <div class="list-group-item border-0 py-2">
                        <div class="d-flex justify-content-between"><strong>Kavya N.</strong> <span class="text-warning">★★★☆☆</span></div>
                        <small>"Smudges after 5 hours, but smooth."</small>
                        <div><button class="btn btn-sm btn-success rounded-pill me-1">Approve</button><button class="btn btn-sm btn-outline-secondary rounded-pill">Reject</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="mb-0"><i class="bi bi-lightning-charge-fill me-2"></i> Quick Actions</h6>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-3">
            <a href="#" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-plus-circle"></i> Add Product</a>
            <a href="#" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-images"></i> Add Banner</a>
            <a href="#" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-ticket-perforated"></i> Add Coupon</a>
            <a href="#" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-eye"></i> View Orders</a>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Revenue (₹)',
                data: [125000, 148000, 172000, 205000],
                borderColor: '#E91E8C',
                borderWidth: 3,
                fill: true,
                backgroundColor: 'rgba(233,30,140,0.05)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'top' } }
        }
    });
</script>

@endsection