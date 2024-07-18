<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function () {
    $credential = [
        'email' => 'admin@admin.com',
        'password' => 'password',
    ];

    if (!Auth::attempt($credential)) {
        $user = new User();

        $user->name = "Admin";
        $user->NIK = '327512548457';
        $user->email = $credential['email'];
        $user->username = 'admin';
        $user->password = Hash::make($credential['password']);
        $user->save();

        if (Auth::attempt($credential)) {
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
            $updateToken = $user->createToken('update-token', ['create', 'update']);
            $basicToken = $user->createToken('basic-token');

            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken,
            ];
        }
    }
});
