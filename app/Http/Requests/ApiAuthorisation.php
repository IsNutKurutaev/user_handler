<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorsResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ApiAuthorisation extends ApiValidation
{
    public function authorize(Request $request)
    {
        if(!$request->bearerToken()) {
            throw new HttpResponseException(response()->json(new ErrorsResource([
                'code' => 403,
                'message' => 'Login failed'
            ]), 403));
        }
        return true;
    }
}
