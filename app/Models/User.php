<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstWhere(string $string, string|null $bearerToken)
 */
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

    public function workerOnShift(): HasMany
    {
        return $this->hasMany(WorkerOnShift::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(UsersGroup::class);
    }
}
