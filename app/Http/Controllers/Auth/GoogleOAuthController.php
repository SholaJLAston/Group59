<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleOAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->with(['prompt' => 'select_account']) // Forces account chooser
            ->redirect();
    }

    // Redirect logged-in Google users for delete-account re-auth.
    public function startDeleteReauth(Request $request): RedirectResponse
    {
        $request->session()->put('google_delete_reauth', true);

        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            if ($request->session()->pull('google_delete_reauth', false)) {
                return redirect()->route('profile.edit')
                    ->withErrors(['google_reauth' => 'Google confirmation failed. Please try again.'], 'userDeletion');
            }

            return redirect('/login')->with('error', 'Google authentication failed.');
        }

        $email = $googleUser->getEmail();
        if (!$email) {
            if ($request->session()->pull('google_delete_reauth', false)) {
                return redirect()->route('profile.edit')
                    ->withErrors(['google_reauth' => 'Your Google account did not provide an email address.'], 'userDeletion');
            }

            return redirect('/login')->with('error', 'Google account did not provide an email address.');
        }

        $googleId = (string) $googleUser->getId();

        if ($request->session()->pull('google_delete_reauth', false)) {
            $currentUser = $request->user();

            if (!$currentUser) {
                return redirect('/login');
            }

            $providerMatches = $currentUser->provider_id && hash_equals((string) $currentUser->provider_id, $googleId);
            $emailMatches = strcasecmp($currentUser->email, $email) === 0;

            if (!$providerMatches && !$emailMatches) {
                return redirect()->route('profile.edit')
                    ->withErrors(['google_reauth' => 'Google account does not match your signed-in account.'], 'userDeletion');
            }

            $request->session()->put('google_delete_confirmed_at', now()->toIso8601String());

            return redirect()->route('profile.edit')->with('status', 'google-delete-reauth-confirmed');
        }

        $firstName = (string) ($googleUser->user['given_name'] ?? '');
        $lastName = (string) ($googleUser->user['family_name'] ?? '');

        if ($firstName === '') {
            $firstName = 'Google';
        }

        $user = User::query()
            ->where('provider_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        if (!$user) {
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make(str()->random(32)),
                'email_verified_at' => now(),
                'role' => 'customer',
                'password_changed' => true,
                'auth_provider' => 'google',
                'provider_id' => $googleId,
            ]);
        }

        $dirty = false;

        if (!$user->provider_id) {
            $user->provider_id = $googleId;
            $dirty = true;
        }

        if (!$user->auth_provider) {
            $user->auth_provider = 'google';
            $dirty = true;
        }

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $dirty = true;
        }

        if ($dirty) {
            $user->save();
        }

        Auth::login($user, remember: true);

        return redirect('/dashboard');
    }
}
