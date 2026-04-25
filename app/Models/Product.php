<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('products')]

class Product extends Model
{
    use HasFactory;

    public function category(): HasOne
    {
        return $this->belongsTo(Category::class);
    }
}
