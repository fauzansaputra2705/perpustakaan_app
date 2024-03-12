<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\EMISTrait;
use App\Models\m_pendidik;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): mixed
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ]);

        DB::beginTransaction();
        try {

            $user = User::create([
                'name' => $request->username ?? '',
                'username' => $request->username ?? '',
                'email' => $request->email,
                'role' => 'siswa',
                // @phpstan-ignore-next-line
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles('pendidik');

            DB::commit();
            event(new Registered($user));
            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return to_route('register')->withErrors([
                'message' => $th->getMessage(),
                'messageFlash' => true,
                'type' => 'error'
            ]);
        }
    }
}
