<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const ACCEPTED = 'Принят';

    public const DECLINED = 'Отменен';

    public const PREPARING = 'Готовится';

    public const READY = 'Готов';

    public const PAID = 'Оплачен';

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at',];

    protected $table = 'orders';

//    public function product(): BelongsTo
//    {
//        return $this->belongsTo(Product::class);
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shift_workers');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shifts::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function productOrder(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }
}
