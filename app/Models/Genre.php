<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'description', 'status'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
