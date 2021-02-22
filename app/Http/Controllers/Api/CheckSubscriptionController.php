<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Android\AndroidController;
use App\Http\Controllers\Api\Ios\IosController;
use App\Http\Controllers\Controller;
use App\Models\Api\ApplicationModel;
use App\Models\Api\PurchaseModel;
use App\Models\Api\RegisterModel;

class CheckSubscriptionController extends Controller
{

    public function checkSubscription($clientToken)
    {
        $device = RegisterModel::where('clientToken', '=', $clientToken)->get();
        if (!empty($device[0])) {

            //clientToken ile cihazın belirlenmesi
            $uid = $device[0]->uid;
            $os = $device[0]->os;

            //uid ile appId belirlenmesi
            $app = ApplicationModel::where('uid', '=', $uid)->get();
            $purchaseId = $app[0]->appId . '1';

            //appId ile birlikte purchase expireDate belirlenmesi
            $purchase = PurchaseModel::where('purchaseId', '=', $purchaseId)->get();
            $receipt = $purchase[0]->receipt;

            //callApi metodu mock api'a receipt göndererek expireDate'i alıyoruz.
            function callApi($os, $receipt)
            {
                if ($os == 1) {
                    $androidController = new AndroidController();
                    return $androidController->check($receipt);
                } elseif ($os == 0) {
                    $iosController = new iosController();
                    return $iosController->check($receipt);
                } else {
                    return response()->json(['Bilinmeyen İşletim Sistemi', 400]);
                }
            }

            $apiResponse = callApi($os, $receipt);

            //Mock Api dan gelen verilerin değişlkenlere aktarılması
            $status = $apiResponse['status'];
            $code = $apiResponse['code'];
            if (isset($apiResponse['expireDate'])) {
                $expireDate = date('Y-m-d H:i:s', strtotime($apiResponse['expireDate']));
            };

            if ($status == true) {
                $message = [
                    'code' => 200,
                    'expireDate' => $expireDate,
                ];
                return $message;
            } else {
                return response()->json('Bir hata oluştu lütfen daha sonra tekrar deneyin', $code);
            }
        } else {
            $message = [
                'code' => 404,
                'message' => 'Token hatalı',
            ];
            return response()->json($message, 404);
        }
    }
}
