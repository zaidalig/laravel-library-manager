<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use LogsActivity;

    protected $fillable = [
        'isbn', 'title', 'author', 'genre_id', 'published_year',
        'total_copies', 'available_copies', 'shelf_location', 'cover_path', 'status',
    ];

    public function coverUrl(): ?string
    {
        return $this->cover_path ? media_url($this->cover_path) : null;
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }

    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }
}
