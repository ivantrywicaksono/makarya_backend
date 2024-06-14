<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CommunityController;
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

Route::get('/', function (Request $request) {
    $data = [
        "status"=> "OK",
        "data"=> [
            "user" => [
                "name"=> "Shriyansh",
                "email"=>"some@email.com",
                "contact"=>"1234567890",
                "fcmToken"=>"Token@123"
            ],
            "event" => [
                "status" => "successful",
                "status_code" => 4,
            ],
        ]
    ];

    return json_encode($data);
});

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
                'phone_number' => $request->phone_number,
                'description' => '',
                'user_id' => $user->id,
            ]);
            break;

        case 'Community':
            $profile = Community::create([
                'phone_number' => $request->phone_number,
                'description' => '',
                'user_id' => $user->id,
            ]);
            break;
    }

    return json_encode($user);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $role = $user->getRoleNames()->first();
    switch ($role) {
        case 'Artist':
            $user->artist;
            break;

        case 'Community':
            $user->community;
            break;
    }

    $username = $user->name;

    $token = $user->createToken($username, ['*'], now()->addMonth())->plainTextToken;

    return json_encode([
        'user' => $user,
        'token' => $token,
    ]);
});

Route::get('/publication/artist/{id}', [PublicationController::class, 'getAllByArtistId']);
Route::get('/publication/popular', [PublicationController::class, 'popular']);

Route::get('/event/community/{id}', [EventController::class, 'getAllByCommunityId']);
Route::get('/event/latest', [EventController::class, 'getLatest']);

Route::get('artist/get/{id}', [ArtistController::class, 'get']);

Route::apiResources([
    'publication' => PublicationController::class,
    'event' => EventController::class,
    'pengajuan' => PengajuanController::class,
    'artist' => ArtistController::class,
    'community' => CommunityController::class,
]);
