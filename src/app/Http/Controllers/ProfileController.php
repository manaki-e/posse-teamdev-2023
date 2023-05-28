<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SlackUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @var SlackController
     */
    public function __construct(SlackController $slackController)
    {
        $this->slackController = $slackController;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('mypage.account')->with(['flush.message' => 'プロフィール情報の編集に成功しました。', 'flush.alert_type' => 'success']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function setSlackProfile(Request $request)
    {
        $this -> slackController -> createUsers($request);

        $user = Auth::user();
        $user_name = SlackUser::where('slackID', $user->slackID)->first()->name;
        $user_display_name = SlackUser::where('slackID', $user->slackID)->first()->display_name;

        $user_data = User::findOrFail($user->id);
        $user_data -> name = $user_name;
        $user_data -> display_name = $user_display_name;
        $user_data -> save();

        return Redirect::route('mypage.account')->with(['flush.message' => 'Slackのプロフィール情報を反映しました。', 'flush.alert_type' => 'success']);
    }
}
