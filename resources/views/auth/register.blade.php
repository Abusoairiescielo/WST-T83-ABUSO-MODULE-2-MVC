<x-guest-layout>
    <div class="card-header text-center bg-transparent">
        <h2 class="text-gradient font-weight-bolder mb-3">Create Account</h2>
        <p class="text-muted">Join our community today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="px-3">
        @csrf
        <div class="mb-4">
            <label class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="fas fa-user text-primary"></i>
                </span>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name') }}" required autofocus>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="fas fa-envelope text-primary"></i>
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
                <span class="input-group-text bg-light">
                    <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" name="password" class="form-control" required>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" name="password_confirmation" 
                       class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-4">
            Create Account
        </button>

        <p class="text-center text-muted mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                Sign in
            </a>
        </p>
    </form>
</x-guest-layout>
