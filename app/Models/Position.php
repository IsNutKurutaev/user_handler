<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $fillable = [ 'count', 'position', 'price' ];

    protected $table = 'position';

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
