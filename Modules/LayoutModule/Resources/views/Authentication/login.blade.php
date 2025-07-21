<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon" />

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css">
    <link rel="stylesheet" href="../assets/fonts/feather.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="../assets/fonts/material.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="../assets/css/style-preset.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
    <!-- Preloader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Login Wrapper -->
    <div class="auth-main v2">
        <div class="bg-overlay"></div>
        <div class="auth-wrapper">
            <div class="auth-form">
                <div class="card my-5 mx-3">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('/assets/images/logo-esf-300.jpeg') }}" alt="Logo" class="img-fluid"
                                style="max-width: 120px;">
                        </div>

                        <!-- Header -->
                        <h4 class="fw-bold mb-4 text-center">
                            <i class="fas fa-user-lock me-2 text-primary"></i> Login
                        </h4>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('loginUser') }}">
                            @csrf

                            <!-- email -->
                            <div class="input-group mb-3 mt-4">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="email" class="form-control" placeholder="email" required>
                            </div>

                            <!-- Password -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </div>
                        </form>

                        @if (session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Files -->
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/fonts/custom-font.js"></script>
    <script src="../assets/js/pcoded.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>

    <script>
        layout_change('light');
        layout_sidebar_change('light');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false'); // RTL turned off
        preset_change("preset-1");
    </script>
</body>

</html>
