<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>
        @yield('meta_title', 'Youth & Summer Camp For Kids in Malaysia')
    </title>

    <meta name="description" content="@yield('meta_description', 'Exciting Youth & Summer Camp For Kids & Teens in Malaysia. Fun & Skills Building Activities During School Holidays by Mad About Education.')">

    <meta name="keywords" content="@yield('meta_keywords', 'summer camp malaysia, youth camp malaysia')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/mae-logo.png') }}" width="32"
        height="32">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nouislider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backtotop.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon_kindedo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    {{-- Custom Css --}}
    <link rel="stylesheet" href="{{ asset('assets/custom_styles.css') }}?v1.1">
    <!-- Alpine js -->
    <script script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>

    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '232520091416931');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=232520091416931&ev=PageView&noscript=1" /></noscript>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '377867244183991');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=377867244183991&ev=PageView&noscript=1" /></noscript>

    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '336478082235929');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
            src="https://www.facebook.com/tr?id=336478082235929&ev=PageView
        &noscript=1" />
    </noscript>
    <!-- End Meta Pixel Code -->


    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5QJN68M');
    </script>
    <!-- End Google Tag Manager -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-674257837"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-674257837');
    </script>

    @stack('styles')
    @livewireStyles
</head>
<style>
    p {
        text-align: justify;
    }
</style>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QJN68M" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <form action="{{ route('logout') }}" method="post" id="logout-form">
        @csrf
    </form>
    <!-- pre loader area start -->
    <!-- <div id="loading">
      <div id="preloader">
         <div class="preloader-thumb-wrap">
            <div class="preloader-thumb">
               <div class="preloader-border"></div>
               <img src="{{ asset('assets/images/mae_logo.png') }}" alt="img not found!">
            </div>
         </div>
      </div>
   </div> -->
    <!-- pre loader area end -->

    <!-- back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- back to top end -->

    <!-- header area start -->
    @include('layouts.header')
    <!-- header area end here -->

    <!-- main area start here  -->
    <main>
        @yield('content')
    </main>
    <!-- main area end here  -->

    <div class="offcanvas offcanvas-top" style="height: 100%;" tabindex="-1" id="cartCanvas"
        aria-labelledby="cartCanvasLabel">
        <div class="offcanvas-header d-flex justify-content-end px-4">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>
        <div class="offcanvas-body pb-100">
            @livewire('parent.cart-component', key('off-canvas-component'))
        </div>
    </div>
    <!-- footer area start -->
    @include('layouts.footer')
    <!-- footer area end -->

    <!-- offcanvas area start -->
    <div class="offcanvas__area">
        <div class="offcanvas__bg"></div>
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-40 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/images/mae-logo.png') }}" alt="logo">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button class="offcanvas__close-btn">
                            <i class="fa-thin fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="offcanvas__search mb-0">
                    <form action="#">
                        <button type="submit"><i class="flaticon-search"></i></button>
                        <input type="text" placeholder="Search here">
                    </form>
                </div>
                <div class="mobile-menu fix mt-40"></div>
                <div class="offcanvas__about d-none d-lg-block mt-30 mb-30">
                    <h4>About Kindedo</h4>
                    <p>With the help of teachers and environment as the third teacher, students have opportunities to
                        confidently take risks.</p>
                </div>
                <div class="offcanvas__contact mt-30 mb-30">
                    <h4>Contact Info</h4>
                    <ul>
                        <li class="d-flex align-items-center gap-2">
                            <div class="offcanvas__contact-icon">
                                <a target="_blank"
                                    href="https://www.google.com/maps/place/Dhaka/@23.7806207,90.3492859,12z/data=!3m1!4b1!4m5!3m4!1s0x3755b8b087026b81:0x8fa563bbdd5904c2!8m2!3d23.8104753!4d90.4119873">
                                    <i class="fal fa-map-marker-alt"></i></a>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="#">
                                    Unit 405 & 406 Block A, Level 4, Kelana Business Centre
                                </a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <div class="offcanvas__contact-icon">
                                <a href="tel:+601127758056"><i class="far fa-phone"></i></a>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="tel:+601127758056">+6011 2775 8056</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <div class="offcanvas__contact-icon">
                                <a href="mailto:enquiry@madabouteducation.com><i class="fal fa-envelope"></i></a>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="mailto:enquiry@madabouteducation.com">enquiry@madabouteducation.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="offcanvas__social">
                    <ul>
                        <li><a target="_blank" href="https://www.facebook.com/madabouteducationgroup"><i
                                    class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li><a target="_blank" href=" https://www.instagram.com/madabouteducation.group/"><i
                                    class="fa-brands fa-instagram"></i></a></li>
                        <!-- <li><a target="_blank" href="#"><i class="fa-brands fa-youtube"></i></a>
                  </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div>
                        <h5 class="modal-title text-warning text-center mb-2">Welcome to MAE <span
                                data-bs-dismiss="modal" class="mx-4 text-dark  fs-3"><b class="cursor-pointer"
                                    title="dismiss">&times;</b></span></h5>
                    </div>
                    <ul class="list-group ">
                        <li class="list-group-item">Already a member ? <a href="{{ route('login') }}"
                                class="text-success">Login</a></li>
                        <li class="list-group-item">New to MAE ? <a href="{{ route('register') }}"
                                class="text-success">Register</a></li>
                    </ul>
                </div>
                <span class="text-center bg-light rounded m-2">
                    <b>Note : </b> If you are here for first time we have a manual for you to follow please check our <a
                        href="{{ route('instruction') }}" class="text-info">Instruction page</a>
                </span>
                <br>
            </div>
        </div>
    </div>
    <div class="body-overlay"></div>
    <!-- offcanvas area end -->

    <!-- serach popup area start here  -->
    <!-- search popup overlay  -->
    <div class="bd-search-overlay"></div>
    <!-- serach popup area end here  -->

    <a href="https://wa.me/+601127758056" class="wa-float-wrapper" target="_blank">
        <i class="fa-brands fa-whatsapp wa-float"></i>
    </a>
    <!-- JS here -->
    <script src="{{ asset('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/meanmenu.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>
    <script src="{{ asset('assets/js/nouislider.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/parallax.js') }}"></script>
    <script src="{{ asset('assets/js/backtotop.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope-pkgd.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded-pkgd.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('status') && session('message'))
        <script>
            // Check for session status and show SweetAlert
            window.addEventListener('load', function() {
                let status = "{{ session('status') }}";
                let message = "{{ session('message') }}";

                if (status == 1) {
                    Swal.fire(
                        'Success!',
                        message,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        message,
                        'error'
                    );
                }
            });
        </script>
    @endif

    <script>
        $('.logout-button').on('click', function(e) {
            e.preventDefault();
            submitLogoutForm();
        });

        function submitLogoutForm() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of the system!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Log out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("logout-form").submit();
                }
            })

        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('scroll-to-top', event => {
            const targetOffset = 300;
            window.scrollTo({
                top: targetOffset,
                behavior: 'smooth' // Optional: Add smooth scrolling behavior
            });
            console.log('scroll-to-top')
        });


        window.addEventListener('openModalSearch', event => {
            $(".bd-search-popup-area").addClass("bd-search-opened");
            $(".bd-search-overlay").addClass("bd-search-opened");
        })

        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
        });

        window.addEventListener('success-notification', event => {
            toastMixin.fire({
                title: event.detail.message,
                icon: 'success'
            });
        })

        window.addEventListener('info-notification', event => {
            toastMixin.fire({
                title: event.detail.message,
                icon: 'info'
            });
        })
        window.addEventListener('error-notification', event => {
            toastMixin.fire({
                title: event.detail.message,
                icon: 'error'
            });
        })
        window.addEventListener('warning-notification', event => {
            toastMixin.fire({
                title: event.detail.message,
                icon: 'warning'
            });
        })

        window.addEventListener('success-prompt', event => {
            Swal.fire(
                'Success!',
                event.detail.message,
                'success'
            )
        })

        window.addEventListener('error-prompt', event => {
            Swal.fire(
                'Error!',
                event.detail.message,
                'error'
            )
        })
    </script>
    @if (request()->has('status') && request()->has('message'))
        <script>
            window.onload = function() {
                const status = "{{ request('status') }}";
                const message = "{{ request('message') }}";

                toastMixin.fire({
                    title: message,
                    icon: status == 1 ? 'success' : 'error'
                });


            }
        </script>
    @endif
    <script>
        window.authUser = @json(auth()->user());

        const myModal = new bootstrap.Modal('#popupModal', {
            keyboard: false
        })

        // Function to show the alert
        function showAlert() {
            myModal.show();
        }

        // Function to check if the alert should be shown today
        function shouldShowAlert() {
            // Retrieve the last time the alert was shown from localStorage
            const lastAlertTime = localStorage.getItem("lastAlertTime");
            // If the lastAlertTime is not set or if it's been more than a day, show the alert
            if (!lastAlertTime || Date.now() - parseInt(lastAlertTime) >= 24 * 60 * 60 * 1000) {
                if (!window.authUser) {
                    showAlert();
                }
                // Update the lastAlertTime in localStorage to the current time
                localStorage.setItem("lastAlertTime", Date.now().toString());
            }
        }

        // Call the function to check if the alert should be shown today
        shouldShowAlert();
    </script>
    @stack('scripts')
    @livewireScripts
</body>

</html>
