<div class="container-fluid">

    <div class="row">

        <!-- Total Promotions -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6>Total Promotions</h6>
                    <h3>{{ $totalPromotions }}</h3>
                </div>
            </div>
        </div>

        <!-- Active Promotions -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6>Active Promotions</h6>
                    <h3 class="text-success">{{ $activePromotions }}</h3>
                </div>
            </div>
        </div>

        <!-- Expired Promotions -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6>Expired Promotions</h6>
                    <h3 class="text-danger">{{ $expiredPromotions }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Usage -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6>Total Usage</h6>
                    <h3>{{ $totalUsage }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="mt-4">
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-primary">
            View Promotions
        </a>

        <a href="{{ route('admin.promotions.create') }}" class="btn btn-success">
            Create New Promotion
        </a>
    </div>
</div>
