<header>
    <div class="bd-header">
        <!-- header top area start  -->
        <div class="bd-header-top bd-header-top-2 d-none d-xl-block">
            <!-- header top clip shape  -->
            <div class="bd-header-top-clip-shape"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bd-header-top-wrapper d-flex justify-content-between">
                            <div class="bd-header-top-left">
                                <div class="bd-header-meta-items-2  d-flex align-items-center">
                                    <div class="bd-header-meta-item is-white d-flex align-items-center">
                                        <div class="bd-header-meta-icon">
                                            <i class="fa-sharp fa-solid fa-flag"></i>
                                        </div>
                                        <div class="bd-header-meta-text">
                                            <p>Journey Since 2016</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bd-header-top-right d-flex align-items-center">
                                <div class="bd-header-meta-items d-flex align-items-center">
                                    <div class="bd-header-meta-item d-flex align-items-center">
                                        <div class="bd-header-meta-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="bd-header-meta-text">
                                            <p><a
                                                    href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bd-header-meta-item d-flex align-items-center">
                                        <div class="bd-header-meta-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="bd-header-meta-text">
                                            <p>8.00am-4.00pm</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header top area end -->

        <!-- header bottom area start -->
        <div id="header-sticky" class="bd-header-bottom-2">
            <!-- header bottom clip shape  -->
            <div class="bd-header-bottom-clip-shape"></div>
            <div class="container">
                <div class="mega-menu-wrapper p-relative">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="bd-header-logo">
                            <a href="{{ route('home') }}">
                                <img style="height:80px;" src="{{ asset('assets/images/mae-logo.png') }}"
                                    alt="MAE_LOGO">
                            </a>
                        </div>
                        <div class="bd-main-menu d-none d-lg-flex align-items-center">
                            <nav id="mobile-menu">
                                <ul>

                                    <li>
                                        <a href="{{ route('about_us') }}">About MAE</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('school') }}">School</a>
                                    </li>
                                    <li class="has-dropdown">

                                        <a href="javasript:void(0);">Overnight Camps</a>
                                        <ul class="submenu" style="min-width: 280px;">
                                            @foreach ($vc_program_categories->whereNotIn('type', 'program') as $category)
                                                <li><a
                                                        href="{{ route('programs.category', $category->slug) }}">{{ $category->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>



                                    <li class="has-dropdown">
                                        <a href="javasript:void(0);">Programs</a>
                                        <ul class="submenu" style="min-width: 280px;">
                                            @foreach ($vc_program_categories->whereNotIn('type', 'camp') as $category)
                                                <li><a
                                                        href="{{ route('programs.category', $category->slug) }}">{{ $category->title }}</a>
                                                </li>
                                            @endforeach
                                            <li><a href="{{ route('birthday') }}">Birthday Party</a></li>
                                        </ul>
                                    </li>




                                    <li class="">
                                        <a href="{{ route('shop.categories') }}">Shop</a>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="javasript:void(0);">Help</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
                                            <li><a href="{{ route('faqs') }}">FAQs</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="javasript:void(0);">General Info</a>
                                        <ul class="submenu" style="min-width: 280px;">
                                            <li><a href="{{ route('venue') }}">Venue/Facilities</a></li>
                                            <li><a href="{{ route('health') }}">Health & Safety</a></li>
                                            <li><a href="{{ route('camp') }}">Camp/Program Preparations</a></li>
                                            <li><a href="{{ route('travel') }}">Travel & Transportation</a></li>
                                            <li>
                                                <a href="{{ route('calendar') }}">Calendar</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-dropdown">
                                        <a href="javasript:void(0);">Media & Galleries</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                            <li><a href="{{ route('articles') }}">Article</a></li>
                                            <li><a href="{{ route('media') }}">Media</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        @livewire('search-programs-component')

                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="bd-header-bottom-right d-flex justify-content-end align-items-center">

                            <div>
                                <a href="" class="ms-0 m-0 text_green position-relative"
                                    data-bs-toggle="offcanvas" data-bs-target="#cartCanvas"
                                    aria-controls="cartCanvas">@livewire('cart-icon-component')<i
                                        class="fa-regular fa-cart-shopping"></i></a>

                            </div>
                            @auth
                                <div class="me-2 ms-4">
                                    <a href="{{ route('redirect-to-dashboard') }}" class="bd-btn">
                                        <span class="bd-btn-inner">
                                            <span class="bd-btn-normal">{{ auth()->user()->name }}</span>
                                            <span class="bd-btn-hover">{{ auth()->user()->name }}</span>
                                        </span>
                                    </a>
                                </div>
                            @else
                                <div class="d-none d-md-flex">
                                    <div class="me-2 ms-4">
                                        <a href="{{ route('login') }}" class="bd-btn">
                                            <span class="bd-btn-inner">
                                                <span class="bd-btn-normal">Login</span>
                                                <span class="bd-btn-hover">Login</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('register', ['intended_url' => url()->current()]) }}"
                                            class="bd-btn bd-btn-grey">
                                            <span class="bd-btn-inner">
                                                <span class="bd-btn-normal">Signup</span>
                                                <span class="bd-btn-hover">Signup</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex d-md-none">
                                    <div class="me-2 ms-5">
                                        <a href="{{ route('login') }}" class="text-success">
                                            Login
                                        </a> <br>
                                        <a href="{{ route('register', ['intended_url' => url()->current()]) }}"
                                            class="text-success">
                                            Signup
                                        </a>
                                    </div>
                                </div>
                            @endauth
                            <div class="header-hamburger d-md-none">
                                <button type="button" class="hamburger-btn offcanvas-open-btn">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header bottom area end -->
    </div>
</header>
