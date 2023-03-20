<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [ 'name' ];

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'Updated_at' ];

    protected $table = 'tables';

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
