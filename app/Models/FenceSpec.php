<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FenceSpec extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'fence_id',
        'spec_type',
        'value',
        'price'
    ];

    public function fence(): BelongsTo
    {
        return $this->belongsTo(Fence::class);
    }
}
