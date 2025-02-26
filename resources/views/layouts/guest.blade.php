<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Nucleo Icons -->
        <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <!-- CSS Files -->
        <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        
        <style>
            :root {
                --violet-darkest: #36175e;
                --violet-dark: #553285;
                --violet-medium: #7b52ab;
                --violet-light: #9768d1;
            }

            body {
                background: linear-gradient(135deg, var(--violet-darkest) 0%, var(--violet-dark) 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .auth-card {
                max-width: 450px;
                width: 90%;
                margin: 2rem auto;
                background: rgba(255, 255, 255, 0.98);
                border-radius: 1.5rem;
                box-shadow: 0 20px 40px rgba(85, 50, 133, 0.3);
                padding: 2rem;
            }
            .form-control {
                border-radius: 0.75rem;
                padding: 0.75rem 1rem;
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            .form-control:focus {
                border-color: var(--violet-medium);
                box-shadow: 0 0 0 3px rgba(123, 82, 171, 0.1);
            }
            .btn-primary {
                background: linear-gradient(135deg, var(--violet-medium) 0%, var(--violet-dark) 100%);
                border: none;
                border-radius: 0.75rem;
                padding: 0.75rem 1.5rem;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, var(--violet-light) 0%, var(--violet-medium) 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(85, 50, 133, 0.2);
            }
            .btn-primary span {
                color: #ffffff;
                letter-spacing: 0.5px;
            }
            .text-gradient {
                background: linear-gradient(135deg, var(--violet-light) 0%, var(--violet-medium) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .input-group-text {
                background-color: #f8f9fa !important;
                border: 1px solid #dee2e6;
                color: #6c757d;
            }
            .input-group .form-control {
                border: 1px solid #dee2e6;
                padding: 0.75rem 1rem;
            }
            .input-group .form-control:focus {
                border-color: var(--violet-medium);
                box-shadow: 0 0 0 0.2rem rgba(123, 82, 171, 0.25);
            }
            .input-group-text i {
                width: 1rem;
                text-align: center;
            }
            .toggle-password {
                cursor: pointer;
                border-left: none;
                background-color: #f8f9fa !important;
            }
            .toggle-password:hover {
                background-color: #e9ecef !important;
            }
            .form-label {
                color: #344767;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            .input-group {
                position: relative;
                margin-bottom: 1rem;
                border-radius: 0.75rem;
                background-color: #f8f9fa;
            }
            
            .input-group-text {
                background-color: transparent !important;
                border: none !important;
                padding: 0.75rem 1rem !important;
                color: var(--violet-medium);
            }
            
            .form-control {
                border: none !important;
                padding: 0.75rem 1.25rem !important;
                background-color: transparent !important;
                font-size: 0.95rem;
            }
            
            .form-control:focus {
                box-shadow: none !important;
                background-color: white !important;
            }
            
            .password-toggle-icon {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 10;
                padding: 0.5rem;
                color: var(--violet-medium);
            }
            
            .password-toggle-icon:hover {
                color: var(--violet-dark);
            }
            
            /* Add hover effect to input group */
            .input-group:hover {
                background-color: #f0f2f5;
            }
            
            /* Add focus effect to input group */
            .input-group:focus-within {
                background-color: white;
                box-shadow: 0 0 0 2px var(--violet-medium);
            }

            a {
                transition: all 0.3s ease;
            }

            a:hover {
                color: var(--violet-dark) !important;
                text-decoration: none;
            }

            .fs-5 {
                font-size: 1.125rem !important;
            }

            .fw-semibold {
                font-weight: 600 !important;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
