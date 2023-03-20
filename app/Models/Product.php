<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $fillable = [ 'count', 'position', 'price' ];

    protected $table = 'products';

    public function product_order(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }
}
