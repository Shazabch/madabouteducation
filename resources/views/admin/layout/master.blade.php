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
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('dist-assets/css/custom_styles.css') }}" rel="stylesheet" />

    @stack('styles')

    <!-- Alpine -->
    <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>

    <!-- CKEditor -->
    <script src="{{ asset('ck-editor/ckeditor.js') }}"></script>

    <style>
        .ck-editor__editable {
            height: 500px;
        }

        .text_orange {
            color: #FF9B24;
        }

        .text_green {
            color: #00BBAE;
        }

        .bg_orange {
            background-color: #FF9B24;
        }

        .bg_green {
            background-color: #00BBAE;
        }
    </style>

    {{-- ✅ LIVEWIRE STYLES (MUST BE HERE) --}}
    @livewireStyles
</head>

<body class="text-left">

    <form action="{{ route('logout') }}" method="post" id="logout-form">
        @csrf
    </form>

    <div class="app-admin-wrap layout-sidebar-large">

        {{-- HEADER --}}
        <div class="main-header">
            <div class="logo">
                <img src="{{ asset('assets/images/mae-icon.png') }}" alt="">
            </div>

            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div style="margin: auto"></div>

            <div class="header-part-right">
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>

                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="{{ asset('dist-assets/images/faces/1.jpg') }}" id="userDropdown"
                            data-toggle="dropdown">

                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header text-capitalize">
                                {{ auth()->user()->name }}
                            </div>

                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Account settings</a>

                            <a class="dropdown-item logout-button" href="#">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layout.menu')

        {{-- CONTENT --}}
        <div class="main-content-wrap sidenav-open d-flex flex-column">

            <div class="main-content">

                <div class="breadcrumb">
                    <h1 class="mr-2">@yield('title')</h1>
                </div>

                <div class="separator-breadcrumb border-top"></div>

                @yield('content')

            </div>

            <div class="flex-grow-1"></div>

            {{-- FOOTER --}}
            <div class="app-footer mb-5">
                <div class="footer-bottom sborder-top pt-3 mb-5 d-flex flex-column flex-sm-row align-items-center">
                    <a class="btn btn-primary text-white btn-rounded">MAE Education</a>

                    <span class="flex-grow-1"></span>

                    <div>
                        <p class="m-0">&copy; {{ date('Y') }} MAE Education</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPTS --}}

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
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
            FilePondPluginImagePreview
        );
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.logout-button').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Log out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("logout-form").submit();
                }
            });
        });
    </script>

    {{-- STACK --}}
    @stack('scripts')

    {{-- ✅ LIVEWIRE SCRIPTS (MUST BE LAST) --}}
    @livewireScripts

</body>

</html>
