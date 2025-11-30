<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>403 - Forbidden | Ahryxx Course</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- Dùng lại CSS backend --}}
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fc;
        }

        .error-hero-card {
            border: 0;
            border-radius: .75rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }

        .error-code {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .error-title {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .error-text {
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="row justify-content-center w-100">
        <div class="col-xl-10">
            <div class="card error-hero-card">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        {{-- Text --}}
                        <div class="col-md-7">
                            <div class="mb-1 text-uppercase text-muted small">
                                Access denied
                            </div>
                            <div class="error-code text-danger mb-1">
                                403
                            </div>
                            <h5 class="error-title text-gray-800 mb-2">
                                You don’t have permission to access this page
                            </h5>
                            <p class="error-text text-muted mb-4">
                                If you believe this is a mistake, please contact the administrator
                                or try logging in with another account.
                            </p>

                            <div class="d-flex flex-wrap">
                                <a href="{{ url()->previous() }}"
                                   class="btn btn-light btn-sm mr-2 mb-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Go back
                                </a>

                                <a href="{{ route('admin.dashboard') }}"
                                   class="btn btn-primary btn-sm mb-2">
                                    <i class="fas fa-home mr-1"></i> Back to dashboard
                                </a>
                            </div>
                        </div>

                        {{-- Illustration / icon --}}
                        <div class="col-md-5 text-center mt-4 mt-md-0">
                            <i class="fas fa-lock fa-5x text-gray-400 mb-3"></i>
                            <p class="text-muted small mb-0">
                                Restricted area
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
