<?php

namespace App\Models;

use App\Enum\SpecType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fence extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'measurement_id',
        'type_id'
    ];

    public function measurement(): BelongsTo
    {
        return $this->belongsTo(Measurement::class);
    }

    public function specs(): HasMany
    {
        return $this->hasMany(FenceSpec::class)
            ->whereNot('spec_type', '=', SpecType::COLOR->value);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(FenceSpec::class)
            ->where('spec_type', SpecType::COLOR->value);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(FenceType::class, 'type_id', 'id');
    }
}
