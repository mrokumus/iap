<?php

namespace App\Http\Controllers\Api\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AndroidController extends Controller
{
    public function check(Request $request)
    {
        return response()->json('OK', 200);

    }

}
