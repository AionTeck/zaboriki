<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GateSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'price',
        'gate_id',
    ];

    public function gate(): BelongsTo
    {
        return $this->belongsTo(Gate::class);
    }
}
