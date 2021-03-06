<?php

namespace App\Http\Controllers\Api\Ios;

use App\Http\Controllers\Controller;
use App\Models\Ios\IosModel;
use Carbon\Carbon;

class IosController extends Controller
{

    public static function check($receipt)
    {

        //Requesten gelen recipt'in bulunduğu satırın çekilmesi
        $data = IosModel::where('receipt', '=', $receipt)->first();

        if (isset($data)) {

            //UTC 0 olan tarih ve saati istenilen formatta UTC-6 değerine dönüştürülmesi
            $expireDate = date('Y-m-d H:i:s', (strtotime($data->expireDate) - 21600));

            //String olan ve sonu rakam olan validation değişkenin oluşturulması
            $validation = $data->receipt . $data->validation;

            //currentDate'in belirlenmesi
            $mytime = Carbon::now();
            $mytime = strtotime($mytime);
            $currentDate = date('Y-m-d H:i:s', $mytime);

            //Eğer recipt değerinin sonu 1 ise Response true dönecek değilse false


            //deger yoksa hata donsun
            if (substr($validation, -1) == 1) {
                //Eğer şimdiki zaman bitiş tarihinden küçükse respons true dönecek
                if ($currentDate < $expireDate) {
                    $response =
                        [
                            'status' => true,
                            'code' => 200,
                            'expireDate' => $expireDate
                        ];
                    return $response;
                } elseif ($currentDate >= $expireDate) {
                    $response =
                        [
                            'status' => false,
                            'code' => 401,
                            'message' => 'Abonelik süreniz dolmuştur. Yenileyiniz!'
                        ];
                    return $response;
                }
            } else {
                $response =
                    [
                        'status' => false,
                        'code' => 401,
                    ];
                return $response;
            }
        } else {
            $response =
                [
                    'status' => false,
                    'code' => 404,
                    'message' => 'Receipt bulunamadı'
                ];
            return $response;
        }
    }
}
