<x-guest-layout>
    <div class="card-header text-center bg-transparent">
        <h2 class="text-gradient font-weight-bolder mb-3">Welcome Back!</h2>
        <p class="text-muted">Sign in to your account to continue</p>
    </div>
    
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <form method="POST" action="{{ route('login') }}" class="px-3">
        @csrf
        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email') }}" required autofocus 
                       placeholder="Enter your email">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" id="password" 
                       class="form-control" required 
                       placeholder="Enter your password">
                <span class="password-toggle-icon" onclick="togglePassword()">
                    <i class="fas fa-eye" id="togglePassword"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label text-muted" for="remember_me">
                    Remember me
                </label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none fw-semibold" style="color: var(--violet-medium);">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-4">
            <span class="fw-semibold text-white">Sign In</span>
        </button>

        <p class="text-center text-muted mb-0">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: var(--violet-medium);">
                Create Account
            </a>
        </p>
    </form>
</x-guest-layout>

<style>
    .input-group {
        position: relative;
    }
    
    .password-toggle-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
        color: #6c757d;
        padding: 5px;
    }

    .password-toggle-icon:hover {
        color: var(--violet-medium);
    }

    /* Add padding to password input to prevent text from going under the icon */
    input[type="password"] {
        padding-right: 40px !important;
    }
    
    /* Remove the previous toggle-password styles if they exist */
    .toggle-password {
        display: none;
    }
</style>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePassword');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
