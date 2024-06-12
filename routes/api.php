<?php
use App\Models\User;
use App\Models\Artist;
use App\Models\Community;

use App\Http\Controllers\PublicationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PengajuanController;

//
use Illuminate\Auth\Events\PasswordReset;
//

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

//
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
//

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/regist', function (Request $request) {
    $user = User::create([
        'email' => $request->email,
        'name' => $request->name,
        'password' => $request->password,
    ]);

    $role = $request->role;
    $user->assignRole($role);
    $user->getRoleNames()->first();

    switch ($role) {
        case 'Artist':
            $profile = Artist::create([
                'description' => '',
                'user_id' => $user->id,
            ]);
            break;

        case 'Community':
            $profile = Community::create([
                'description' => '',
                'user_id' => $user->id,
            ]);
            break;
    }

    return json_encode($user);
});

Route::post('/token', function (Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required',
        'name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->name, ['*'], now()->addMonth())->plainTextToken;

    return json_encode([
        'user' => $user,
        'token' => $token,
    ]);
});

//UBAH PASSWORD
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? response()->json(['status' => __($status)])
                : response()->json(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    /*
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    */
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
                : back()->withErrors(['email' => [($status)]]);
})->middleware('guest')->name('password.update');
//

Route::apiResources([
    'publication' => PublicationController::class,
    'event' => EventController::class,
    'pengajuan' => PengajuanController::class
    ,]);