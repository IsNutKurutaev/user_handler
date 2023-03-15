<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsersGroup extends Model
{
    use HasFactory;

    protected $fillable = [ 'group' ];

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $table = 'users_group';


    public function group(): HasMany
    {
        return $this->HasMany(User::class);
    }
}
