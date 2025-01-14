<?php

namespace App\Models;

use App\Enum\Measurement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'measurement_type',
    ];

    protected $casts = [
        'measurement_type' => Measurement::class,
    ];

    public function specs(): HasMany
    {
        return $this->hasMany(AccessorySpec::class, 'accessory_id', 'id');
    }

    public function accessoryables(): HasMany
    {
        return $this->hasMany(Accessoryable::class, 'accessory_id', 'id');
    }
}
