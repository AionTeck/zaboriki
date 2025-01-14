<?php

namespace App\Models;

use App\Enum\Measurement;
use App\Enum\SpecType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Fence extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'measurement_type',
        'type_id',
    ];

    protected $casts = [
        'measurement_type' => Measurement::class
    ];

    public function specs(): HasMany
    {
        return $this->hasMany(FenceSpec::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(FenceType::class, 'type_id', 'id');
    }

    public function polyAccessory(): MorphMany
    {
        return $this->morphMany(Accessoryable::class, 'accessoryable');
    }
}
