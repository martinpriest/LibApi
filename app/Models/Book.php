<?php

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publication_date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => BookStatus::class,
    ];

    public function isAvailable(): bool
    {
        return $this->status->isAvailable() && ! $this->customer_id;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
