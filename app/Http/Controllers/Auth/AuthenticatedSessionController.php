<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function handleSocialiteCallback($providerUser, string $provider)
    {
        // Verifica se já existe usuário com este email 
        $userByEmail = User::where('email', $providerUser->getEmail())->first();

        // Verifica se já existe usuário com este ID do provedor
        $userByProviderId = User::where("{$provider}_id", $providerUser->getId())->first();

        // Caso 1: Usuário já está vinculado a este provedor - faz login
        if ($userByProviderId) {
            Auth::login($userByProviderId, true);
            return redirect()->intended('/dashboard');
        }

        // Caso 2: Email já existe mas não está vinculado a este provedor
        if ($userByEmail && !$userByProviderId) {

            $userByEmail->update([
                "{$provider}_id" => $providerUser->getId(),
                "{$provider}_token" => $providerUser->token,
                "{$provider}_refresh_token" => $providerUser->refreshToken,
            ]);

            Auth::login($userByEmail, true);
            return redirect()->intended('/dashboard');
        }

        // Caso 3: Novo usuário
        $user = User::updateOrCreate([
                'email' => $providerUser->getEmail(),
            ],
            [
                'name' => $providerUser->getName(),
                'nickname' => $providerUser->getNickname() ?? Str::slug($providerUser->getName()),
                "{$provider}_id" => $providerUser->getId(),
                "{$provider}_token" => $providerUser->token,
                "{$provider}_refresh_token" => $providerUser->refreshToken,
                'password' => null,
                'email_verified_at' => now()
            ]
        );

        Auth::login($user, true);
        return redirect()->intended('/dashboard');
    }

    public function githubRedirect()
    {
        return Socialite::driver('github')->setScopes(['user:email', 'repo'])->redirect();
    }

    public function githubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->setScopes(['user:email', 'repo'])->stateless()->user();
            return $this->handleSocialiteCallback($githubUser, 'github');
        } catch (\Exception $e) {
            \Log::error('GitHub Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors('Falha na autenticação com GitHub');
        }
    }

    // Métodos similares para Google
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            return $this->handleSocialiteCallback($googleUser, 'google');
        } catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors('Falha na autenticação com Google');
        }
    }
}
