<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookLoan extends Model
{
    use LogsActivity;

    protected $fillable = [
        'book_id', 'member_id', 'loaned_at', 'due_at',
        'returned_at', 'fine_amount', 'fine_paid', 'fine_paid_at',
        'status', 'user_id',
    ];

    protected function casts(): array
    {
        return [
            'loaned_at' => 'date',
            'due_at' => 'date',
            'returned_at' => 'date',
            'fine_amount' => 'decimal:2',
            'fine_paid' => 'boolean',
            'fine_paid_at' => 'datetime',
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && $this->due_at->lt(today());
    }
}
