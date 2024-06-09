<?php
use App\Models\User;
use App\Models\Artist;
use App\Models\Community;

use App\Http\Controllers\PublicationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PengajuanController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

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

Route::apiResources([
    'publication' => PublicationController::class,
    'event' => EventController::class,
    'pengajuan' => PengajuanController::class,
]);
