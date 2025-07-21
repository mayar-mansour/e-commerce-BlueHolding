<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title> ecommerce @yield('title')</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- [Page specific CSS] start -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">
    <!-- [Page specific CSS] end -->



    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <!-- [Icons and Fonts] -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}" id="main-style-link">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    @include('layoutmodule::layouts.sidebar')
    <!-- [ Sidebar Menu ] end -->


    <!-- [ Header Topbar ] start -->
    @include('layoutmodule::layouts.header')
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    @yield('content')
    <!-- [ Main Content ] end -->



    @include('layoutmodule::layouts.footer')
    <!-- [ Main Content ] end -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pc-dt-simple').DataTable({
                // Optional configurations
                pageLength: 20,
                ordering: true,
                language: {
                    search: "Filter:"
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.toggle-submenu');

            toggles.forEach(toggle => {
                toggle.addEventListener('click', function(event) {
                    event.preventDefault();
                    const parent = this.closest('.pc-item-has-children');
                    const submenu = parent.querySelector('.pc-submenu');

                    // Toggle the 'active' class for the submenu
                    submenu.classList.toggle('active');
                });
            });
        });
    </script>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- [Page Specific JS] -->
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/peity-vanilla.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/course-dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.style.transition = 'opacity 0.5s';
                    flashMessage.style.opacity = '0';
                    setTimeout(() => flashMessage.remove(), 500); // Remove the element after fade out
                }, 3000); // Adjust the timeout duration (3 seconds in this case)
            }
        });
    </script>

    @stack('scripts')
</body>
<!-- [Body] end -->

</html>
