<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ mainMenuActiveBySegment('') }}"><a class="nav-item-hold"
                    href="{{ route('admin.dashboard') }}"><i class="nav-icon i-Safe-Box1"></i><span
                        class="nav-text">Dasboard</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item  {{ mainMenuActiveBySegment('system') }}" data-item="system"><a class="nav-item-hold"
                    href="#"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">System</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ mainMenuActiveBySegment('programs') }}" data-item="camp"><a class="nav-item-hold"
                    href="#"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">Programs</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ mainMenuActiveBySegment('shop') }}" data-item="shop"><a class="nav-item-hold"
                    href="#"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">Shop</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ mainMenuActiveBySegment('promotions') }}" data-item="promotions"><a
                    class="nav-item-hold" href="#"><i class="nav-icon i-Bar-Chart"></i><span
                        class="nav-text">Promotions</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ mainMenuActiveBySegment('others') }}" data-item="others"><a class="nav-item-hold"
                    href="#"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">Others</span></a>
                <div class="triangle"></div>
            </li>

        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <!-- Submenu Dashboards-->
        <ul class="childNav" data-parent="system">
            <li class="nav-item"><a href="{{ route('admin.roles') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Role Management</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.users') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">User Management</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.website-users') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Website Users</span></a></li>
        </ul>
        <ul class="childNav" data-parent="camp">
            <li class="nav-item"><a href="{{ route('admin.programs.category') }}"><i
                        class="nav-icon i-Clock-3"></i><span class="item-name">Category</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.programs') }}"><i class="nav-icon i-Clock-4"></i><span
                        class="item-name">Programs</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.forms') }}"><i class="nav-icon i-Clock-4"></i><span
                        class="item-name">Forms</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.program-bookings') }}"><i
                        class="nav-icon i-Clock-4"></i><span class="item-name">Bookings</span></a></li>
        </ul>
        <ul class="childNav" data-parent="shop">
            <li class="nav-item"><a href="{{ route('admin.shop.products') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Products</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.shop.product-categories') }}"><i
                        class="nav-icon i-Clock-3"></i><span class="item-name">Product Categories</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.shop.orders') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Orders</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.shop.subscriptions') }}"><i
                        class="nav-icon i-Clock-3"></i><span class="item-name">Subscriptions</span></a></li>
        </ul>
        <ul class="childNav" data-parent="promotions">
            <li class="nav-item"><a href="{{ route('admin.promotions.dashboard') }}"><i
                        class="nav-icon i-Clock-3"></i><span class="item-name">Promotions Dashboard</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.promotions.index') }}"><i
                        class="nav-icon i-Clock-3"></i><span class="item-name">All Promotions</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.promotions.create') }}"><i
                        class="nav-icon i-Clock-3"></i><span class="item-name">Create/Edit Promotions</span></a></li>
        </ul>
        <ul class="childNav" data-parent="others">
            <li class="nav-item"><a href="{{ route('admin.gallery') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Gallery</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.media') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Media</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.articles') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Article</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.newsletter') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Newsletter Subcription</span></a></li>
            <li class="nav-item"><a href="{{ route('admin.carousel') }}"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Carousel</span></a></li>
        </ul>
        <ul class="childNav" data-parent="dashboard">
            <li class="nav-item"><a href="dashboard1.html"><i class="nav-icon i-Clock-3"></i><span
                        class="item-name">Version 1</span></a></li>
            <li class="nav-item"><a href="dashboard2.html"><i class="nav-icon i-Clock-4"></i><span
                        class="item-name">Version 2</span></a></li>
            <li class="nav-item"><a href="dashboard3.html"><i class="nav-icon i-Over-Time"></i><span
                        class="item-name">Version 3</span></a></li>
            <li class="nav-item"><a href="dashboard4.html"><i class="nav-icon i-Clock"></i><span
                        class="item-name">Version 4</span></a></li>
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
