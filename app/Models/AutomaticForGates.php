<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AutomaticForGates extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function specs(): HasMany
    {
        return $this->hasMany(AutomaticForGatesSpec::class, 'automatic_for_gate_id', 'id');
    }
}
