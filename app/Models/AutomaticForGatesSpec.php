<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomaticForGatesSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'automatic_for_gate_id',
        'gate_type_id',
        'price',
    ];

    public function automaticForGates(): BelongsTo
    {
        return $this->belongsTo(AutomaticForGates::class, 'automatic_for_gate_id', 'id');
    }

    public function gateType(): BelongsTo
    {
        return $this->belongsTo(GateType::class, 'gate_type_id', 'id');
    }
}
