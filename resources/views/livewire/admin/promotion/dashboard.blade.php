@push('styles')
<style>
    :root {
        --primary: #6366f1;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --dark: #1f2937;
        --light: #f9fafb;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .dashboard-container {
        padding: 2rem;
    }

    /* ═══════════════════════════════════════════════════════
       STAT CARDS - Modern Design
    ═══════════════════════════════════════════════════════ */
    .stat-card {
        position: relative;
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        background: white;
        min-height: 120px;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--color-start), var(--color-end));
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-card .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }

    .stat-card.primary-stat {
        --color-start: #6366f1;
        --color-end: #8b5cf6;
    }

    .stat-card.success-stat {
        --color-start: #10b981;
        --color-end: #059669;
    }

    .stat-card.danger-stat {
        --color-start: #ef4444;
        --color-end: #dc2626;
    }

    .stat-card.info-stat {
        --color-start: #3b82f6;
        --color-end: #1d4ed8;
    }

    .stat-card.warning-stat {
        --color-start: #f59e0b;
        --color-end: #d97706;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--dark);
        letter-spacing: -0.5px;
        margin-left: 10px;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        margin-left: 10px;
    }

    /* ═══════════════════════════════════════════════════════
       SECTION CARDS
    ═══════════════════════════════════════════════════════ */
    .section-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background: white;
    }

    .section-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .section-card .card-header {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-bottom: 1px solid #e5e7eb;
        padding: 1.5rem;
        font-weight: 600;
        font-size: 16px;
        color: var(--dark);
    }

    .section-card .card-body {
        padding: 1.5rem;
    }

    /* ═══════════════════════════════════════════════════════
       PROGRESS BARS - Modern Style
    ═══════════════════════════════════════════════════════ */
    .progress {
        height: 8px;
        background-color: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 13px;
        font-weight: 500;
    }

    .progress-item {
        margin-bottom: 1.2rem;
    }

    /* ═══════════════════════════════════════════════════════
       TABLE STYLING
    ═══════════════════════════════════════════════════════ */
    .table-modern {
        font-size: 13px;
    }

    .table-modern thead {
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        border-bottom: 2px solid #e5e7eb;
    }

    .table-modern thead th {
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
    }

    .table-modern tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s;
    }

    .table-modern tbody tr:hover {
        background-color: #f9fafb;
    }

    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
    }

    /* ═══════════════════════════════════════════════════════
       BADGES & BADGES
    ═══════════════════════════════════════════════════════ */
    .badge-modern {
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-danger {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e3a8a;
    }

    /* ═══════════════════════════════════════════════════════
       BUTTONS - Modern Style
    ═══════════════════════════════════════════════════════ */
    .btn-modern {
        border-radius: 10px;
        font-weight: 500;
        padding: 0.6rem 1.2rem;
        transition: all 0.2s ease;
        border: none;
        font-size: 14px;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        color: white;
    }

    .btn-success-modern {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-success-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .btn-outline-modern {
        border: 2px solid #e5e7eb;
        color: var(--dark);
        background: white;
        font-weight: 500;
    }

    .btn-outline-modern:hover {
        border-color: #6366f1;
        color: #6366f1;
        background: #f0f4ff;
    }

    /* ═══════════════════════════════════════════════════════
       ACTIVITY TIMELINE
    ═══════════════════════════════════════════════════════ */
    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s;
    }

    .activity-item:hover {
        background-color: #f9fafb;
        padding-left: 0.5rem;
    }

    .activity-badge {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 0.4rem;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        font-size: 13px;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .activity-subtitle {
        font-size: 12px;
        color: #9ca3af;
    }

    .activity-time {
        font-size: 12px;
        color: #d1d5db;
        white-space: nowrap;
    }

    /* ═══════════════════════════════════════════════════════
       SECTION TITLES
    ═══════════════════════════════════════════════════════ */
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 24px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 2px;
    }

    /* ═══════════════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .stat-card {
            min-height: 100px;
        }

        .stat-value {
            font-size: 22px;
        }

        .section-title {
            font-size: 20px;
            margin-bottom: 1.5rem;
        }
    }
</style>
@endpush

<div class="dashboard-container">

    {{-- ═══════════════════════════════════════════════════════
         HEADER
    ═══════════════════════════════════════════════════════ --}}
    <div class="mb-5">

        {{-- ═══════════════════════════════════════════════════════
         ACTION BUTTONS
    ═══════════════════════════════════════════════════════ --}}
    <div class="d-flex gap-3 flex-wrap">
        <a href="{{ route('admin.promotions.index') }}" class="btn btn-modern btn-outline-modern mx-2">
            📋 View All Promotions
        </a>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-modern btn-success-modern mx-2">
            ➕ Create New Promotion
        </a>
        <button wire:click="loadStats" class="btn btn-modern btn-outline-modern mx-2">
            <span wire:loading.remove wire:target="loadStats">↻ Refresh Data</span>
            <span wire:loading wire:target="loadStats">
                <span class="spinner-border spinner-border-sm me-1"></span> Loading...
            </span>
        </button>
    </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         ROW 1 — Key Metrics (4 Cards)
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Total Promotions --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card primary-stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));">
                        🏷️
                    </div>
                    <div>
                        <div class="stat-label">Total Promotions</div>
                        <div class="stat-value">{{ $totalPromotions }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Promotions --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card success-stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));">
                        ✅
                    </div>
                    <div>
                        <div class="stat-label">Active Now</div>
                        <div class="stat-value text-success">{{ $activePromotions }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Expired Promotions --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card danger-stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));">
                        ⏰
                    </div>
                    <div>
                        <div class="stat-label">Expired</div>
                        <div class="stat-value text-danger">{{ $expiredPromotions }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Uses --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card info-stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(29, 78, 216, 0.1));">
                        🔥
                    </div>
                    <div>
                        <div class="stat-label">Total Uses</div>
                        <div class="stat-value">{{ $totalUsage }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════
         ROW 2 — Additional Metrics
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Expiring in 7 Days --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card warning-stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));">
                        ⚠️
                    </div>
                    <div>
                        <div class="stat-label">Expiring Soon</div>
                        <div class="stat-value text-warning">{{ count($expiringSoon) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Unused Active --}}
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card stat-card primary-stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));">
                        💤
                    </div>
                    <div>
                        <div class="stat-label">Unused Active</div>
                        <div class="stat-value">{{ $unusedPromotions }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Discount Given --}}
        <!-- <div class="col-lg-6 col-md-12">
            <div class="card stat-card success-stat">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));">
                        💰
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-label">Total Discount Given</div>
                        <div class="d-flex align-items-baseline gap-2">
                            <div class="stat-value text-success">RM {{ number_format($totalDiscountGiven, 2) }}</div>
                            <span class="text-muted small">in total savings</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>

    {{-- ═══════════════════════════════════════════════════════
         ROW 3 — Analytics (Type Breakdown + Expiring Soon)
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Promotions by Type --}}
        <div class="col-lg-4">
            <div class="card section-card">
                <div class="card-header">
                    📈 Promotion Types
                </div>
                <div class="card-body">
                    @php
                    $typeColors = [
                    'percentage' => 'primary',
                    'fixed' => 'success',
                    'free_gift' => 'warning',
                    ];
                    $typeLabels = [
                    'percentage' => 'Percentage Discounts',
                    'fixed' => 'Fixed Amount',
                    'free_gift' => 'Free Gifts',
                    ];
                    @endphp

                    @forelse ($typeBreakdown as $type => $count)
                    @php
                    $color = $typeColors[$type] ?? 'secondary';
                    $label = $typeLabels[$type] ?? ucfirst(str_replace('_', ' ', $type));
                    $pct = $totalPromotions > 0 ? round(($count / $totalPromotions) * 100) : 0;
                    @endphp
                    <div class="progress-item">
                        <div class="progress-label">
                            <span class="fw-500">{{ $label }}</span>
                            <span class="text-end"><strong>{{ $count }}</strong> <span class="text-muted">({{ $pct }}%)</span></span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-{{ $color }}" style="width: {{ $pct }}%;"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-3">No promotion data yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Expiring Soon Table --}}
        <div class="col-lg-8">
            <div class="card section-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>⚠️ Expiring Soon</span>
                    <span class="badge badge-warning badge-modern">Next 7 Days</span>
                </div>
                <div class="card-body" style="padding: 0;">
                    @if (count($expiringSoon) === 0)
                    <div class="py-5 text-center text-muted">
                        <p class="mb-0">✅ No promotions expiring soon. You're all set!</p>
                    </div>
                    @else
                    <div style="overflow-x: auto;">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Promotion Name</th>
                                    <th>Code</th>
                                    <th>Expires On</th>
                                    <th>Days Left</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expiringSoon as $promo)
                                <tr>
                                    <td>
                                        <strong>{{ $promo['name'] }}</strong>
                                    </td>
                                    <td>
                                        <code style="background: #f3f4f6; padding: 4px 8px; border-radius: 6px; font-size: 12px;">
                                            {{ $promo['code'] }}
                                        </code>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($promo['end_date'])->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-modern {{ $promo['days_left'] <= 2 ? 'badge-danger' : 'badge-warning' }}">
                                            {{ $promo['days_left'] }} day{{ $promo['days_left'] !== 1 ? 's' : '' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('admin.promotions.edit', $promo['id']) }}"
                                            class="btn btn-modern btn-outline-modern btn-sm">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════
         ROW 4 — Top Promotions & Activity
    ═══════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- Top Promotions by Usage --}}
        <div class="col-lg-6">
            <div class="card section-card">
                <div class="card-header">
                    🏆 Top Promotions by Usage
                </div>
                <div class="card-body">
                    @forelse ($topPromotions as $i => $promo)
                    <div class="d-flex align-items-center justify-content-between p-2 mb-2"
                        style="background: #f9fafb; border-radius: 10px; transition: all 0.2s;">
                        <div class="d-flex align-items-center gap-2 flex-grow-1">
                            <div style="width: 32px; height: 32px; border-radius: 8px;
                                            background: linear-gradient(135deg, #6366f1, #8b5cf6);
                                            display: flex; align-items: center; justify-content: center;
                                            color: white; font-weight: 700; font-size: 14px;margin-right: 10px;">
                                #{{ $i + 1 }}
                            </div>
                            <div>
                                <div class="fw-600 small">{{ $promo['name'] }}</div>
                                <div class="text-muted" style="font-size: 11px;">
                                    @if ($promo['code'] !== '—')
                                    <code>{{ $promo['code'] }}</code>
                                    @endif
                                    {{ ucfirst(str_replace('_', ' ', $promo['type'])) }}
                                    @if ($promo['value'])
                                    • @if ($promo['type'] === 'percentage')
                                    {{ $promo['value'] }}%
                                    @else
                                    RM {{ number_format($promo['value'], 2) }}
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div style="font-weight: 700; color: #6366f1; font-size: 16px;">
                                {{ $promo['used'] }}
                            </div>
                            <div class="text-muted" style="font-size: 11px;">
                                of {{ $promo['max_uses'] ?? '∞' }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4">No usage data available yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent Activity Timeline --}}
        <div class="col-lg-6">
            <div class="card section-card">
                <div class="card-header">
                    🕐 Recent Activity
                </div>
                <div class="card-body" style="max-height: 420px; overflow-y: auto;">
                    @forelse ($recentUsages as $usage)
                    <div class="activity-item">
                        <div class="activity-badge" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);"></div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $usage['promo_name'] }}</div>
                            <div class="activity-subtitle">
                                @if ($usage['promo_code'] !== '—')
                                <code>{{ $usage['promo_code'] }}</code> •
                                @endif
                                Used by <strong>{{ $usage['user_name'] }}</strong>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="badge badge-modern badge-info" style="background: #dbeafe; color: #1e3a8a;">
                                ×{{ $usage['used_count'] }}
                            </div>
                            <div class="activity-time">
                                {{ \Carbon\Carbon::parse($usage['updated_at'])->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4">No activity yet</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>



</div>