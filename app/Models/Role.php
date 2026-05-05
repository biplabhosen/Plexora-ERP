<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'label',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getLabelAttribute(): string
    {
        return $this->name === 'user'
            ? 'Buyer'
            : str($this->name)->headline()->toString();
    }
}
