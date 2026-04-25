<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
#[Table('categories')]

class Category extends Model
{
    use HasFactory;
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
