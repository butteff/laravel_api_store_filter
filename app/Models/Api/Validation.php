<?php

namespace App\Models\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Validation
{
	protected function validationStore(array $params)
    {
        // validation rules for store API request:
        return Validator::make($params, [
            'q' => 'bail|string|max:250',
            'category_id' => 'integer',
            'price_from' => 'decimal:0,4',
            'price_to' => 'decimal:0,4',
            'in_stock' => 'boolean',
            'rating_from' => 'bail|decimal:0,4|min:1|max:5',
            'sort' => Rule::in(['price_asc', 'price_desc', 'rating_desc', 'rating_asc', 'newest']),
        ]);
        // ------
    }
}