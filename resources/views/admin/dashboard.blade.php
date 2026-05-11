@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid dashboard">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Admin Dashboard</h4>
        <span class="text-muted">Welcome Back 👋</span>
    </div>

    <!-- ROW 1 -->
    <div class="row g-4 mb-3">
        <div class="col-md-3">
            <div class="dash-card pink">
                <div>
                    <p>Today's Orders</p>
                    <h3>25</h3>
                </div>
                <i class="bi bi-cart"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-card green">
                <div>
                    <p>Today's Revenue</p>
                    <h3>₹12,500</h3>
                </div>
                <i class="bi bi-currency-rupee"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-card blue">
                <div>
                    <p>New Users</p>
                    <h3>18</h3>
                </div>
                <i class="bi bi-people"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-card orange">
                <div>
                    <p>Pending Orders</p>
                    <h3>6</h3>
                </div>
                <i class="bi bi-clock"></i>
            </div>
        </div>
    </div>

    <!-- ROW 2 -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="dash-card">
                <p>Total Products</p>
                <h3>320</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-card red">
                <p>Out of Stock</p>
                <h3>12</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-card yellow">
                <p>Reviews Pending</p>
                <h3>9</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dash-card purple">
                <p>Coupons Active</p>
                <h3>5</h3>
            </div>
        </div>
    </div>

    <!-- CHART + QUICK LINKS -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card dashboard-card">
                <div class="card-header d-flex justify-content-between">
                    <h6>Sales Overview</h6>
                    <select class="form-select w-auto">
                        <option>Last 30 Days</option>
                        <option>Last 7 Days</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h6>Quick Actions</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="#" class="btn btn-primary">+ Add Product</a>
                    <a href="#" class="btn btn-success">+ Add Banner</a>
                    <a href="#" class="btn btn-warning">+ Add Coupon</a>
                    <a href="#" class="btn btn-dark">View Orders</a>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLES -->
    <div class="row g-4">

        <!-- Top Products -->
        <div class="col-md-6">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h6>Top Selling Products</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lipstick</td>
                                <td>120</td>
                                <td class="text-success">₹6000</td>
                            </tr>
                            <tr>
                                <td>Face Wash</td>
                                <td>80</td>
                                <td class="text-success">₹4000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-md-6">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h6>Recent Orders</h6>
                </div>
                <div class="card-body">
                    <div class="order-item">
                        <span>#1001</span>
                        <span class="badge bg-success">Delivered</span>
                    </div>
                    <div class="order-item">
                        <span>#1002</span>
                        <span class="badge bg-warning">Pending</span>
                    </div>
                    <div class="order-item">
                        <span>#1003</span>
                        <span class="badge bg-danger">Cancelled</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOW STOCK -->
        <div class="col-md-6">
            <div class="card dashboard-card border-danger">
                <div class="card-header text-danger">
                    <h6>Low Stock Alert</h6>
                </div>
                <div class="card-body">
                    <div class="low-stock">Serum <span>3 left</span></div>
                    <div class="low-stock">Moisturizer <span>2 left</span></div>
                </div>
            </div>
        </div>

        <!-- REVIEWS -->
        <div class="col-md-6">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h6>Recent Reviews</h6>
                </div>
                <div class="card-body">
                    <div class="review">⭐ 4 - Nice product!</div>
                    <div class="review">⭐ 5 - Excellent quality</div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

<style>
    .dashboard {
    background: #f5f7fb;
    padding: 20px;
}

.dash-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: 0.3s;
}

.dash-card:hover {
    transform: translateY(-5px);
}

.dash-card p {
    margin: 0;
    color: #777;
}

.dash-card h3 {
    margin: 5px 0 0;
    font-weight: bold;
}

.dash-card i {
    font-size: 32px;
    opacity: 0.6;
}

/* COLORS */
.pink { background: #FCE4EC; }
.green { background: #E8F5E9; }
.blue { background: #E3F2FD; }
.orange { background: #FFF3E0; }
.red { background: #FFEBEE; }
.yellow { background: #FFFDE7; }
.purple { background: #F3E5F5; }

/* CARD */
.dashboard-card {
    border-radius: 14px;
    border: none;
}

.dashboard-card .card-header {
    background: transparent;
    border-bottom: 1px solid #eee;
    font-weight: 600;
}

/* ORDER */
.order-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px dashed #eee;
}

/* LOW STOCK */
.low-stock {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    color: #dc3545;
    font-weight: 500;
}

/* REVIEW */
.review {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: ['1','5','10','15','20','25','30'],
        datasets: [{
            label: 'Revenue',
            data: [1000,2000,1500,3000,2500,4000,3500],
            borderWidth: 3,
            tension: 0.4,
            fill: true
        }]
    }
});
</script>