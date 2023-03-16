<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'login', 'password', 'surname','status', 'group_id', 'patronymic', 'path'
    ];

    protected $guarded = [ 'id' ];

    protected $hidden = [
        'password', 'api_token', 'created_at', 'updated_at'
    ];

    protected $table = 'users';

    public function group(): BelongsTo
    {
        return $this->belongsTo(UsersGroup::class);
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(UsersStatus::class);
    }
}
