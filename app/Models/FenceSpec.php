<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FenceSpec extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'fence_id',
        'value',
        'price',
    ];

    public function fence(): BelongsTo
    {
        return $this->belongsTo(Fence::class);
    }
}
