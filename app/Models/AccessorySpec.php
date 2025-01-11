<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessorySpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'accessory_id',
        'dimension',
        'price',
    ];

    public function accessory(): BelongsTo
    {
        return $this->belongsTo(Accessory::class, 'accessory_id', 'id');
    }
}
