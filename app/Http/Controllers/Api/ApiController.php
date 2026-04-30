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
            $res['status'] = 'fail';
            foreach ($validated->errors()->all() as $err) {
                $res['errors'][] = $err;
            }
        } else { // filter, sorting and pagination:
            $res['status'] = 'ok';
            $api->filter();
            $api->sorting();
            $api->pagination();
            $res['data'] = $api->result();
        }

        return $res;
    }
}