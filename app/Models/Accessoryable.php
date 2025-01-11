<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Accessoryable extends Model
{
    use HasFactory;

    protected $fillable = [
        'accessory_id',
        'accessoryable_type',
        'accessoryable_id'
    ];

    public function accessory(): BelongsTo
    {
        return $this->belongsTo(Accessory::class);
    }

    public function accessoryable(): MorphTo
    {
        return $this->morphTo();
    }
}
