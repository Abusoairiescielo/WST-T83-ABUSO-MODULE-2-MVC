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
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                box-shadow: 0 4px 12px rgba(85, 50, 133, 0.2);
            }
            .text-gradient {
                background: linear-gradient(135deg, var(--violet-light) 0%, var(--violet-medium) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .input-group-text {
                border-radius: 0.75rem 0 0 0.75rem;
                background: #f8fafc;
            }
            .card-header {
                border-bottom: 1px solid #e2e8f0;
                padding-bottom: 1.5rem;
                margin-bottom: 1.5rem;
            }
            .form-label {
                font-weight: 600;
                color: #1e293b;
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
