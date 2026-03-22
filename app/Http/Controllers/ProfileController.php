<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View|ViewContract|RedirectResponse
    {
        if ($request->routeIs('admin.*') && $request->user()->role !== 'admin') {
            return Redirect::route('dashboard');
        }

        if (! $request->routeIs('admin.*') && $request->user()->role === 'admin') {
            return Redirect::route('admin.settings');
        }

        return view('profile.edit', [
            'user' => $request->user(),
            'isAdminSettings' => $request->routeIs('admin.*'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->routeIs('admin.*') && $request->user()->role !== 'admin') {
            abort(403);
        }

        if (! $request->routeIs('admin.*') && $request->user()->role === 'admin') {
            abort(403);
        }

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $settingsRoute = $request->routeIs('admin.*') ? 'admin.settings' : 'profile.edit';

        return Redirect::route($settingsRoute)->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        $isGoogleUser = ($user->auth_provider ?? 'local') === 'google';

        if ($isGoogleUser) {
            $confirmedAt = $request->session()->get('google_delete_confirmed_at');

            if (!$confirmedAt) {
                return Redirect::route('profile.edit')
                    ->withErrors(['google_reauth' => 'Please confirm with Google before deleting your account.'], 'userDeletion');
            }

            $confirmedAtTime = CarbonImmutable::parse((string) $confirmedAt);
            if (now()->greaterThan($confirmedAtTime->addMinutes(5))) {
                $request->session()->forget('google_delete_confirmed_at');

                return Redirect::route('profile.edit')
                    ->withErrors(['google_reauth' => 'Google confirmation expired. Please confirm again.'], 'userDeletion');
            }

            $request->session()->forget('google_delete_confirmed_at');
        } else {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        $request->session()->forget('google_delete_reauth');

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('account_deleted', 'Your account deleted successfully.');
    }
}
