<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Student Information System') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <style>
            :root {
                --violet-darkest: #36175e;
                --violet-dark: #553285;
                --violet-medium: #7b52ab;
                --violet-light: #9768d1;
            }

            .welcome-section {
                background: linear-gradient(135deg, var(--violet-darkest) 0%, var(--violet-dark) 100%);
                color: white;
                position: relative;
                overflow: hidden;
            }
            .welcome-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('path/to/pattern.svg');
                opacity: 0.1;
            }
            .text-gradient {
                background: none !important;
                -webkit-background-clip: initial !important;
                -webkit-text-fill-color: #E8E8E8 !important;
                font-weight: bold !important;
            }
            .navbar {
                background: rgba(85, 50, 133, 0.1);
                backdrop-filter: blur(10px);
            }
            .btn-custom {
                background: linear-gradient(135deg, #4B0082 0%, #1E90FF 100%);  /* Indigo to Dodger Blue */
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                font-weight: 500;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                margin: 0 1rem;
            }
            .btn-custom:hover {
                background: linear-gradient(135deg, #1E90FF 0%, #4B0082 100%);  /* Reverse gradient on hover */
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(75, 0, 130, 0.3);
            }
            .btn-custom i {
                margin-right: 0.5rem;
            }
            .navbar-toggler {
                background-color: rgba(255, 255, 255, 0.9);
                border: none;
                padding: 0.5rem;
                border-radius: 0.5rem;
            }
            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2885, 50, 133, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }
            @media (max-width: 991.98px) {
                .navbar-collapse {
                    background: rgba(255, 255, 255, 0.95);
                    padding: 1rem;
                    border-radius: 1rem;
                    margin-top: 1rem;
                }
                
                .nav-item {
                    margin: 0.5rem 0;
                }
                
                .btn-custom {
                    width: 100%;
                    justify-content: center;
                }
            }
            .btn-primary {
                background: linear-gradient(135deg, var(--violet-medium) 0%, var(--violet-dark) 100%);
                color: white;
                border: none;
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                background: linear-gradient(135deg, var(--violet-light) 0%, var(--violet-medium) 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(85, 50, 133, 0.2);
            }
            
            .btn-danger {
                background: linear-gradient(135deg, #dc3545 0%, var(--violet-dark) 100%);
                color: white;
                border: none;
                transition: all 0.3s ease;
            }
            
            .btn-danger:hover {
                background: linear-gradient(135deg, #dc3545 0%, var(--violet-medium) 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(85, 50, 133, 0.2);
            }
            
            .btn-edit {
                background: linear-gradient(135deg, var(--violet-medium) 0%, var(--violet-dark) 100%);
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }
            
            .btn-edit:hover {
                background: linear-gradient(135deg, var(--violet-light) 0%, var(--violet-medium) 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(85, 50, 133, 0.2);
                color: white;
            }
            
            .btn-delete {
                background: linear-gradient(135deg, #dc3545 0%, var(--violet-dark) 100%);
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }
            
            .btn-delete:hover {
                background: linear-gradient(135deg, #dc3545 0%, var(--violet-medium) 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(85, 50, 133, 0.2);
                color: white;
            }
            
            .btn-enroll {
                background: linear-gradient(135deg, var(--violet-medium) 0%, var(--violet-dark) 100%);
                color: white;
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                font-weight: 500;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }
            
            .btn-enroll:hover {
                background: linear-gradient(135deg, var(--violet-light) 0%, var(--violet-medium) 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(85, 50, 133, 0.2);
                color: white;
            }
            .navbar-brand {
                color: #E8E8E8 !important;
                font-weight: bold;
            }
            .welcome-text {
                background: none !important;
                -webkit-background-clip: initial !important;
                -webkit-text-fill-color: #E8E8E8 !important;  /* Dirty white color */
                font-weight: 600 !important;  /* Slightly bold (600) instead of full bold (700) */
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100">
            <div class="container">
                <a class="navbar-brand fs-3" href="/">
                    <span class="font-weight-bold">Student Information System</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="navbar-nav ms-auto">
                        @if (Route::has('login'))
                            @auth
                                @if(Auth::user()->user_type === 'student')
                                    <li class="nav-item">
                                        <a href="{{ route('student.dashboard') }}" class="btn btn-custom">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard') }}" class="btn btn-custom">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="btn btn-custom me-2">
                                        <i class="fas fa-sign-in-alt"></i> Log in
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a href="{{ route('register') }}" class="btn btn-custom">
                                            <i class="fas fa-user-plus"></i> Register
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Section -->
        <header class="welcome-section min-vh-100">
            <div class="container position-relative z-index-2">
                <div class="row min-vh-100 align-items-center">
                    <div class="col-lg-8 text-center mx-auto">
                        <h1 class="welcome-text mb-2 mt-5">Welcome to</h1>
                        <h1 class="text-gradient display-3 font-weight-bolder mb-4">
                            Student Information System
                        </h1>
                        <p class="text-white-50 lead mb-5">
                        This Laravel-based SIS manages students, subjects, enrollments, and grades with secure access.
                        </p>
                        @auth
                            @if(Auth::user()->user_type === 'student')
                                <a href="{{ route('student.dashboard') }}" class="btn btn-custom btn-lg text-white mb-0 me-2">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-custom btn-lg text-white mb-0 me-2">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Go to Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-custom btn-lg text-white mb-0 me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Get Started
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </header>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
