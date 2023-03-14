<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'login', 'password', 'surname', 'patronymic', 'path'
    ];

    protected $guarded = [ 'id' ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';
}
