<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shifts extends Model
{
    use HasFactory;

    protected $fillable = [ 'start', 'end', 'active' ];

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $table = 'shifts';

    public function workerOnShift(): HasMany
    {
        return $this->hasMany(WorkerOnShift::class, 'shift_id');
    }
    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'shift_id');
    }
}
