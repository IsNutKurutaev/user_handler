<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerOnShift extends Model
{
    use HasFactory;

    protected $guarded = [ 'id' ];

    protected $hidden = [ 'created_at', 'updated_at'];

    protected $fillable = [ 'user_id', 'role_id' ];

    protected $table = 'worker_on_shift';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shifts::class);
    }
}
