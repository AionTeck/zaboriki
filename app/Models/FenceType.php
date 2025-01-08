<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FenceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function fences(): HasMany
    {
        return $this->hasMany(Fence::class);
    }
}
