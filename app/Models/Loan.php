<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';

    protected $fillable = [
        'member_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'penalty_amount',
        'penalty_paid',
        'penalty_paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_at'     => 'datetime',
            'due_date'        => 'date',
            'returned_at'     => 'datetime',
            'penalty_amount'  => 'decimal:2',
            'penalty_paid'    => 'boolean',
            'penalty_paid_at' => 'datetime',
            'created_at'      => 'datetime',
            'updated_at'      => 'datetime',
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Calculate days overdue (negative means not yet overdue).
     */
    public function getDaysOverdueAttribute(): int
    {
        if ($this->returned_at) {
            return 0;
        }
        return max(0, now()->startOfDay()->diffInDays($this->due_date->startOfDay(), false) * -1);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->days_overdue > 0;
    }
}
