<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisher',
        'published_year',
        'genre',
        'description',
        'cover_image',
        'cover_image_public_id',
        'total_copies',
        'available_copies',
    ];

    protected function casts(): array
    {
        return [
            'published_year'   => 'integer',
            'total_copies'     => 'integer',
            'available_copies' => 'integer',
            'created_at'       => 'datetime',
            'updated_at'       => 'datetime',
        ];
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->whereIn('status', ['active', 'overdue']);
    }

    /**
     * Scope for fulltext search on title, author, genre.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->whereRaw(
            'MATCH(title, author, genre) AGAINST(? IN BOOLEAN MODE)',
            [$search . '*']
        );
    }

    /**
     * Scope to filter available books.
     */
    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0);
    }
}
