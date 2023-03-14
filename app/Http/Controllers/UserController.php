<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Http\Requests\Register;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegistrationResource;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function userRegistration(Register $request)
    {
        if(isset($request->photo_file)) {
            $img = Storage::put('photos', $request->photo_file);
            $storagePath  = Storage::disk('local')->path($img);
        }

        $user = User::forceCreate([
            'name' => $request['name'],
            'login' => $request['login'],
            'surname' => $request['surname'],
            'patronymic' => $request['patronymic'],
            'path' => $storagePath ?? null,
            'password' => Hash::make($request['password']),
            'remember_token' => Str::random(100),
        ]);

        return response(new RegistrationResource($user), 201);
    }
    public function login(Login $request)
    {
        $find_user = User::firstWhere('login', $request->login);
        if(isset($find_user)) {
            if(Hash::check($request->password, $find_user->password))
            {
                $find_user->remember_token = Str::random(100);
                $find_user->save();
                return response(new LoginResource($find_user),200);
            }
        }
        return response(['error' => ['code' => 401, 'message' => 'Authentication failed']], 401);
    }
}
