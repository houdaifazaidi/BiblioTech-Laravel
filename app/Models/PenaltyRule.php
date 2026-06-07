<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenaltyRule extends Model
{
    protected $table = 'penalty_rules';

    protected $fillable = [
        'grace_days',
        'fine_per_day',
        'max_fine',
        'currency',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'grace_days'  => 'integer',
            'fine_per_day' => 'decimal:2',
            'max_fine'    => 'decimal:2',
            'is_active'   => 'boolean',
            'created_at'  => 'datetime',
            'updated_at'  => 'datetime',
        ];
    }

    public static function active(): ?self
    {
        return static::where('is_active', 1)->first();
    }
}
