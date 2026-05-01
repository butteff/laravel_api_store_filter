<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Api;

class ApiController extends Controller
{
    public function store(Request $request): array
    {
        $res = [];
        $api = new Api($request, 'store');
        
        $validated = $api->validation(); // request validation

        if ($validated->fails()) { // errors on validation:
            $res = $api->errors();
        } else { // filter, sorting and pagination:
            $api->filter();
            $api->sorting();
            $api->pagination();
            $res = $api->result();
        }

        return $res;
    }
}