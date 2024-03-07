<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
