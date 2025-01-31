<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Gate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type_id',
    ];

    public function specs(): HasMany
    {
        return $this->hasMany(GateSpec::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(GateType::class, 'type_id', 'id');
    }

    public function polyAccessory(): MorphMany
    {
        return $this->morphMany(Accessoryable::class, 'accessoryable');
    }
}
