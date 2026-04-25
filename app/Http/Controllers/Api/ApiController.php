<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validator2;
use \Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Product;

class ApiController extends Controller
{
    const PER_PAGE = 10; // per page value

    public function store(Request $request): array
    {
        $res = [];
        $validated = $this->validation($request); // request validation

        if ($validated->fails()) {
            // errors on validation:
            $res['status'] = 'fail';
            foreach ($validated->errors()->all() as $err) {
                $res['errors'][] = $err;
            }
            // ------
        } else {
            $res['status'] = 'ok';
            // params collection:
            $q = $request->get('q');
            $category_id = $request->get('category_id');
            $price_from = $request->get('price_from');
            $price_to = $request->get('price_to');
            $in_stock = $request->get('in_stock');
            $rating_from = $request->get('rating_from');
            $sort = $request->get('sort');
            $page = (int) $request->get('page') ?? 1;

            // filter:
            $products = Product::where('name', 'like', '%' . $q . '%'); //search name filter
            if ($rating_from) $products->where('rating', '>=', $rating_from); // rating filter
            if ($category_id) $products = $products->where(['category_id' => $category_id]); //category filter
            if ($in_stock) $products = $products->where(['in_stock' => $in_stock]); //in_stock filter
            if ($price_from) $products = $products->where('price', '>=', $price_from); //price filter
            if ($price_to) $products = $products->where('price', '<=', $price_to); //price filter
            // ------
            
            // sorting:
            if ($sort) { 
                $split = explode('_', $sort);
                if (count($split) == 2) {
                    $prefix = $split[0];
                    $ascdesc = $split[1];
                    $products->orderBy($prefix, $ascdesc); // price or rating sort
                }
                $products->orderBy('updated_at', 'desc'); //newest sort
            }
            // ------

            //pagination:
            $all_count = $products->count();
            $products = $products->simplePaginate(self::PER_PAGE)->withQueryString();
            
            $res['products'] = $products->items();
            $res['products_amount'] = $all_count;
            $res['pagination'] = [
                'next_page_url' => $products->nextPageUrl(),
                'previous_page_url' => $products->previousPageUrl(),
                'page' => $page,
                'pages_amount' => ceil($all_count/self::PER_PAGE)
            ];
            // ------
        }

        return $res;
    }

    protected function validation(Request $request): Validator  
    {
        // validation rules:
        return Validator2::make($request->all(), [
            'q' => 'bail|string|max:250',
            'category_id' => 'integer',
            'price_from' => 'decimal:0,4',
            'price_to' => 'decimal:0,4',
            'in_stock' => 'boolean',
            'rating_from' => 'bail|decimal:0,4|min:1|max:5|',
            'sort' => Rule::in(['price_asc', 'price_desc', 'rating_desc', 'rating_asc', 'newest']),
        ]);
        // ------
    }
}