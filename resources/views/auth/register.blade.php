<x-guest-layout>
    <div class="card-header text-center bg-transparent">
        <h2 class="text-gradient font-weight-bolder mb-3">Create Account</h2>
        
    </div>

    <form method="POST" action="{{ route('register') }}" class="px-3">
        @csrf
        <div class="mb-4">
            <label class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user" style="color: var(--violet-medium);"></i>
                </span>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name') }}" required autofocus>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope" style="color: var(--violet-medium);"></i>
                </span>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email') }}" required>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <small class="text-muted">Use your BukSU email address</small>
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock" style="color: var(--violet-medium);"></i>
                </span>
                <input type="password" name="password" id="password" 
                       class="form-control" required>
                <span class="password-toggle-icon" onclick="togglePassword('password', 'togglePassword')">
                    <i class="fas fa-eye" id="togglePassword" style="color: var(--violet-medium);"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock" style="color: var(--violet-medium);"></i>
                </span>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control" required>
                <span class="password-toggle-icon" onclick="togglePassword('password_confirmation', 'togglePasswordConfirm')">
                    <i class="fas fa-eye" id="togglePasswordConfirm" style="color: var(--violet-medium);"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-4">
            Create Account
        </button>

        <p class="text-center text-muted mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: var(--violet-medium);">
                Sign in
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
</style>

<script>
    function togglePassword(inputId, toggleIconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(toggleIconId);
        
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
