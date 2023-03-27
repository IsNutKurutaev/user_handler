<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiAuthorisation;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Logout;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ShowRequest;
use App\Http\Resources\ErrorsResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\LogoutResource;
use App\Http\Resources\RegistrationResource;
use App\Http\Resources\ShowUsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function userRegistration(RegisterRequest $request)
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
            'api_token' => Str::random(100),
            'group_id' => $request['role_id'],
            'status' => $request['status'] ?? 'working',
        ]);

        return (new RegistrationResource($user))->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        /** @var User $find_user */
        $find_user = User::firstWhere('login', $request->login);
        if(isset($find_user)) {
            if(Hash::check($request->password, $find_user->password))
            {
                $find_user->api_token = Str::random(100);
                $find_user->save();
                return response(['data' => ['user_token' => $find_user->createToken('login')->plainTextToken]],200);
            }
        }
        return response(['data' => ['code' => 401, 'message' => 'Authentication failed']], 401);
    }

    public function logout(Request $request)
    {
        $user = User::firstWhere('api_token', $request->bearerToken());
        $user->api_token = null;
        $user->save();

        return response(['data' => ['message' => 'logout']], 200);
    }

    public function showUsers()
    {
        return (ShowUsersResource::collection(User::all()))->response()->setStatusCode(200);
    }
}
