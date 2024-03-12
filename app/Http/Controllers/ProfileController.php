<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\{
    DB,
    Log,
    Validator,
    Auth,
    Hash,
};

class ProfileController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user;

    public function __construct(
        UserRepositoryInterface $user
    ) {
        $this->user = $user;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        // @phpstan-ignore-next-line
        $request->user()?->fill($request->validated());

        if ($request->user()?->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()?->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Update image profile.
     * @param Request $request
     * @return mixed
     */
    public function updateFoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path_image' => 'file|mimes:png,jpg|max:500'
        ]);

        if ($validator->fails()) {
            return back()->withErrors([
                'message' => implode(",", $validator->messages()->all()),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }

        $pathImage = '';
        if ($request->hasFile('path_image')) {
            deleteFile(auth()->user()?->path_image);
            $pathImage = uploadFile('path_image', $request->path_image, 'path_image');
        }

        $this->user->update([
            'path_image' => $pathImage,
        ], auth()->user()?->id);
    }

    /**
     * Ubah password
     *
     * @param   Request  $request
     *
     * @return  mixed
     */
    public function ubahPassword(Request $request)
    {
        $this->validate($request, [
            'password_now' => ['required', 'string'],
            'password_new' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ]);

        DB::beginTransaction();
        try {
            /** @var User $user */
            $user = $this->user->find(auth()->user()?->id);

            // Check if the current password matches the user's password
            /** @var string $passwordNow */
            $passwordNow = $request->password_now;
            if (!Hash::check($passwordNow, $user->password)) {
                return back()->withErrors([
                    'message' => 'Current password is incorrect',
                    'messageFlash' => true,
                    'type' => 'error'
                ]);
            }

            // Update the user's password
            /** @var string $passwordNew */
            $passwordNew = $request->password_new;
            $user->update([
                'password' => Hash::make($passwordNew),
            ]);

            DB::commit();
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return back()->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user?->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
