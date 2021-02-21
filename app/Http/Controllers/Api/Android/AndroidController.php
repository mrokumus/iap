<?php

namespace App\Http\Controllers\Api\Android;

use App\Http\Controllers\Controller;
use App\Models\Android\AndroidModel;
use Illuminate\Http\Request;

class AndroidController extends Controller
{
    public function check(Request $request)
    {
        $receipt = $request->receipt;
        $data = AndroidModel::where('receipt', '=', $receipt)->get();

        $validation = $data[0]->receipt . $data[0]->validation ;
        return response()->json($validation, 200);

    }

}
