<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        if (!$user || !Hash::check($password, $user->password)) {
            $blocked = session('login_blocked_' . $email);
            if ($blocked && now()->lessThan($blocked)) {
                return back()->withErrors(['email' => 'Akun Anda diblokir'])->withInput();
            }

            $attempts = session()->get('login_attempts_' . $email, 0) + 1;
            session()->put('login_attempts_' . $email, $attempts);

            if ($attempts >= 5) {
                $blockTime = now()->addMinutes(30);
                session()->put('login_blocked_' . $email, $blockTime);
                return back()->withErrors(['email' => 'Akun Anda telah diblokir'])->withInput();
            }

            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        Auth::login($user);

        session()->forget('login_attempts_' . $email);
        session()->forget('login_blocked_' . $email);

        if ($user->role == 'user') {
            return redirect()->route('home');
        }

        if ($user->role == 'operator') {
            return redirect()->route('dashboard');
        }

        if ($user->role == 'doctor') {
            return redirect()->route('doctor');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    function register(Request $request)
    {
        Session::flash('name', $request->name);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users|',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.filter' => 'Email harus menggunakan variabel.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        User::create($data);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset-password.request-form');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password.reset-form', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}

