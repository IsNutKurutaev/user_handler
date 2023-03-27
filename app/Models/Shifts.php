<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shifts extends Model
{
    use HasFactory;

    protected $fillable = [ 'start', 'end', 'active' ];

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $table = 'shifts';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'worker_on_shift', 'shift_id');
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'shift_id');
    }
}
