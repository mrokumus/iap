<?php

namespace App\Http\Controllers\Api\Ios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IosController extends Controller
{
    public function check(Request $request)
    {
        return response()->json('OK', 200);

    }
}
