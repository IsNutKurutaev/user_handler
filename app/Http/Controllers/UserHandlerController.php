<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserHandlerRequest;
use App\Models\UserHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserHandlerController extends Controller
{
    protected function userHandler(UserHandlerRequest $data)
    {
        if(isset($data->photo_file)) {
            $img = Storage::put('photos', $data->photo_file);
            $storagePath  = Storage::disk('local')->path($img);
        }

        $user = UserHandler::forceCreate([
            'name' => $data['name'],
            'login' => $data['login'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'path' => $storagePath,
            'password' => Hash::make($data['password']),
            'remember_token' => Str::random(100),
        ]);

        return response(['data' => ['id' => $user->id , 'status' => 'created']], 201);
    }
}
