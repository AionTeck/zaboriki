<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fence extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'measurement_id',
    ];

    public function measurement(): BelongsTo
    {
        return $this->belongsTo(Measurement::class);
    }
}
