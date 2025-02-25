<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $userType = null;
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) use (&$userType) {
                    $domain = substr(strrchr($value, "@"), 1);
                    if (!in_array($domain, ['student.buksu.edu.ph', 'buksu.edu.ph'])) {
                        $fail('The email must be a valid BukSU email address.');
                    }
                    
                    // Set user type based on email domain
                    $userType = $domain === 'student.buksu.edu.ph' ? 'student' : 'instructor';
                },
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $userType,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on user type
        if ($user->user_type === 'student') {
            return redirect()->intended(route('student.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }
}
