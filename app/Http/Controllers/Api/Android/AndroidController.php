<?php

namespace App\Http\Controllers\Api\Android;

use App\Http\Controllers\Controller;
use App\Models\Android\AndroidModel;
use Illuminate\Http\Request;

class AndroidController extends Controller
{

    public static function check(Request $request)
    {
        //Requesten gelen recipt'in bulunduğu satırın çekilmesi
        $data = AndroidModel::where('receipt', '=', $request->receipt)->get();

        //UTC 0 olan tarih ve saati istenilen formatta UTC-6 değerine dönüştürülmesi
        $expireDate = date('Y-m-d H:i:s T', (strtotime($data[0]->expireDate) - 21600));

        //String olan ve sonu rakam olan validation değişkenin oluşturulması
        $validation = $data[0]->receipt . $data[0]->validation;

        //Eğer recipt değerinin sonu 1 ise Response true dönecek değilse false
        if ($validation == 1) {
            $response =
                [
                    'status' => 'true',
                    'code' => 200,
                    'expireDate' => $expireDate
                ];
            return response()->json($response, 200);
        } else {
            $response =
                [
                    'status' => 'false',
                    'code' => 401,
                ];
            return response()->json($response, 401);
        }

    }

}
