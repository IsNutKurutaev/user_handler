<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at' ];

    protected $fillable = [ 'table', 'shift_worker', 'create_at', 'status' ];

    protected $table = 'orders';

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shifts::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
