<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title') | MAE Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('dist-assets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist-assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">
    <!-- FilePond -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('dist-assets/css/custom_styles.css') }}" rel="stylesheet" />
    @stack('styles')
    @livewireStyles
    <!-- Alpine js -->
    <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
    <!-- CKEditor -->
    <script src="{{ asset('ck-editor/ckeditor.js') }}"></script>
    <style>
        .ck-editor__editable {height: 500px;}
        .text_orange
        {
           color: #FF9B24;
        }
        .text_green
        {
           color: #00BBAE;
        }

        .bg_orange
        {
           background-color: #FF9B24;
        }
        .bg_green
        {
           background-color: #00BBAE;
        }

        .btn-orange {
           background-color: #FF9B24;
           color: #fff;
           transition: all .7s;
         }
         .btn-orange:hover {
           background-color: #d27a0e;
           color: #fff;
         }

         .btn-green {
           background-color: #00BBAE;
           color: #fff;
           transition: all .7s;
         }
         .btn-green:hover {
           background-color: #039a90;
           color: #fff;
         }
         .border_green{
           border-color: #039a90;
         }
         .border_orange{
           border-color: #d27a0e;
         }
      </style>
</head>

<body class="text-left">
    <form action="{{ route('logout') }}" method="post" id="logout-form">
        @csrf
    </form>
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header">
            <div class="logo">
                <img  src="{{ asset('assets/images/mae-icon.png') }}" alt="">
            </div>
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div style="margin: auto"></div>
            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
                <!-- Grid menu Dropdown -->
                <!-- <div class="dropdown">
                    <i class="i-Safe-Box text-muted header-icon" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div class="menu-icon-grid">
                            <a href="#"><i class="i-Shop-4"></i> Home</a>
                            <a href="#"><i class="i-Library"></i> UI Kits</a>
                            <a href="#"><i class="i-Drop"></i> Apps</a>
                            <a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a>
                            <a href="#"><i class="i-Checked-User"></i> Sessions</a>
                            <a href="#"><i class="i-Ambulance"></i> Support</a>
                        </div>
                    </div>
                </div> -->
                <!-- Notificaiton -->

                <!-- Notificaiton End -->
                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="{{ asset('dist-assets/images/faces/1.jpg') }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header text-capitalize">
                                <i class="i-Lock-User mr-1"></i> {{ auth()->user()->name }}
                            </div>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Account settings</a>
                            <!-- <a class="dropdown-item">Billing history</a> -->
                            <a class="dropdown-item logout-button" href="route('logout')">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layout.menu')
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2">@yield('title')</h1>
                    <!-- <ul>
                        <li><a href="">Dashboard</a></li>
                        <li>Version 1</li>
                    </ul> -->
                </div>
                <div class="separator-breadcrumb border-top"></div>
                @yield('content')
            </div><!-- Footer Start -->
            <div class="flex-grow-1"></div>
            <div class="app-footer mb-5">
                <!-- <div class="row">
                    <div class="col-md-9">
                        <p><strong>Gull - Laravel + Bootstrap 4 admin template</strong></p>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Libero quis beatae officia saepe perferendis voluptatum minima eveniet voluptates dolorum, temporibus nisi maxime nesciunt totam repudiandae commodi sequi dolor quibusdam
                            <sunt></sunt>
                        </p>
                    </div>
                </div> -->
                <div class="footer-bottom sborder-top pt-3 mb-5 d-flex flex-column flex-sm-row align-items-center">
                    <a class="btn btn-primary text-white btn-rounded" href="javascript::void(0)" >MAE Education</a>
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">

                        <div>
                            <p class="m-0">&copy; {{date('Y')}} MAE Education</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fotter end -->
        </div>
    </div><!-- ============ Search UI Start ============= -->

    <!-- ============ Search UI End ============= -->
    <script src="{{ asset('dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/echart.options.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/dashboard.v1.script.min.js') }}"></script>
    <script src="{{ asset('dist-assets/js/scripts/customizer.script.min.js') }}"></script>
    <!-- FilePond -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImagePreview);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.logout-button').on('click',function(e){
            e.preventDefault();
            submitLogoutForm();
        });
        function submitLogoutForm()
        {
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
    <script>

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
                icon:'success'
            });
        })

        window.addEventListener('info-notification', event => {
            toastMixin.fire({
                title: event.detail.message,
                icon:'info'
            });
        })
        window.addEventListener('error-notification', event => {
            toastMixin.fire({
                title: event.detail.message,
                icon:'error'
            });
        })
        window.addEventListener('warning-notification', event => {
            toastMixin.fire({
                title: event.detail.message,
                icon:'warning'
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

    @stack('scripts')
    @livewireScripts
</body>

</html>
