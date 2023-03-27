<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static firstWhere(string $string, string|null $bearerToken)
 */
class User extends Model
{
    use HasFactory, HasApiTokens;

    public const ADMINISTRATOR = 'admin';

    public const WAITER = 'waiter';

    public const COOK = 'cook';

    protected $guarded = [ 'id' ];

    protected $hidden = [
        'password', 'api_token', 'created_at', 'updated_at'
    ];

    protected $table = 'users';

    public function shifts(): BelongsToMany
    {
        return $this->belongsToMany(Shifts::class, 'worker_on_shift', 'user_id', 'shift_id');
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
