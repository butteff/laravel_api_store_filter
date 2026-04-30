<?php

namespace App\Models\Api;

use App\Models\Product;
use App\Models\Api\Validation;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class Api extends Validation
{
    const PER_PAGE = 10; // per page value

    public $res = [];
    private $params = [];
    private $action = null;
    private $model = null;

    function __construct(Request $request, String $action) {
        $this->params = $request->all();
        $this->action = $action;

        switch ($this->action) {
            case 'store':
                $this->model = new Product();
            break;

            /*
            case 'another request':
                another model...
            break; 
            */
        }
    }

    public function filter(): void
    {
        // filter:
        $this->model->where('name', 'like', '%' . $this->params['q'] . '%'); //search name filter
        if (isset($this->params['rating_from'])) $this->model->where('rating', '>=', $this->params['rating_from']); // rating filter
        if (isset($this->params['category_id'])) $this->model = $this->model->where(['category_id' => $this->params['category_id']]); //category filter
        if (isset($this->params['in_stock'])) $this->model = $this->model->where(['in_stock' => $this->params['in_stock']]); //in_stock filter
        if (isset($this->params['price_from'])) $this->model = $this->model->where('price', '>=', $this->params['price_from']); //price filter
        if (isset($this->params['price_to'])) $this->model = $this->model->where('price', '<=', $this->params['price_to']); //price filter
    }

    public function sorting(): void
    {        
        // sorting:
        if (isset($this->params['sort'])) { 
            $split = explode('_', $this->params['sort']);
            if (count($split) == 2) {
                $prefix = $split[0];
                $ascdesc = $split[1];
                $this->model->orderBy($prefix, $ascdesc); // price or rating sort
            }
            $this->model->orderBy('updated_at', 'desc'); //newest sort
        }
    }

    public function pagination(): void
    {
        // pagination:
        $this->model = $this->model->simplePaginate(self::PER_PAGE)->withQueryString();
    }

    public function result(): array
    {  
        $all_count = $this->model->count();
        $this->res['products'] = $this->model->items();
        $this->res['products_amount'] = $all_count;
        $this->res['pagination'] = [
            'next_page_url' => $this->model->nextPageUrl(),
            'previous_page_url' => $this->model->previousPageUrl(),
            'page' => $this->params['page'] ?? 1,
            'pages_amount' => ceil($all_count/self::PER_PAGE)
        ];
        return $this->res;
    }

    public function validation(): Validator
    {
        switch($this->action) {
            case 'store':
                return $this->validationStore($this->params);
            break;

            /*
            case 'another request':
                another validation...
            break; 
            */
        }
    }
   
}