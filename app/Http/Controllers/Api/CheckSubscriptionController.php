<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckSubscriptionController extends Controller
{

    public function checkSubscription()
    {
        return response()->json('haha');

    }
}
