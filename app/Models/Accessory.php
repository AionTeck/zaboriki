<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'measurement_id',
    ];

    public function measurement(): BelongsTo
    {
        return $this->belongsTo(Measurement::class);
    }

    public function specs(): HasMany
    {
        return $this->hasMany(AccessorySpec::class, 'accessory_id', 'id');
    }

    public function accessoryables(): HasMany
    {
        return $this->hasMany(Accessoryable::class, 'accessory_id', 'id');
    }
}
