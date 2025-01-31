<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GateType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function gates(): HasMany
    {
        return $this->hasMany(Gate::class, 'type_id', 'id');
    }

    public function automaticForGatesSpec(): HasMany
    {
        return $this->hasMany(AutomaticForGateSpec::class, 'gate_type_id', 'id');
    }
}
