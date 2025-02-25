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
                <span class="input-group-text bg-light">
                    <i class="fas fa-envelope text-primary"></i>
                </span>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email') }}" required autofocus>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" name="password" class="form-control" required>
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
                <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-4">
            Sign In
        </button>

        <p class="text-center text-muted mb-0">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-primary text-decoration-none">
                Create one
            </a>
        </p>
    </form>
</x-guest-layout>
