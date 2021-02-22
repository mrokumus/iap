<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Android\AndroidController;
use App\Http\Controllers\Api\Ios\IosController;
use App\Http\Controllers\Controller;
use App\Models\Api\PurchaseModel;
use App\Models\Api\RegisterModel;
use App\Models\Api\ApplicationModel;
use PDOException;

class PurchaseController extends Controller
{

    public function purchase($receipt, $clientToken)
    {
        //clientToken Değeri ile Requestin geldiği cihazı ve sistemini belirliyoruz.
        $register = RegisterModel::where('clientToken', '=', $clientToken)->get();
        $uid = $register[0]->uid;
        $os = $register[0]->os;

        //clientToken Değeri ile Requestin geldiği uygulamayı belirliyoruz.
        $applications = ApplicationModel::where('uid', '=', $uid)->get();
        $appId = $applications[0]->appId;

        //Cihaz ve uygulama bilgisi ile birlikte satın alma ıd'sini oluşturuyoruz.
        $purchaseId = $appId . $uid;

        //callApi metodu mock api'a receipt göndererek expireDate'i alıyoruz.
        function callApi($os, $receipt)
        {
            if ($os == 1) {
                $androidController = new AndroidController();
                $response = $androidController->check($receipt);
                return $response;
            } elseif ($os == 0) {
                $iosController = new iosController();
                $response = $iosController->check($receipt);
                return $response;
            } else {
                return response()->json(['Bilinmeyen İşletim Sistemi', 400]);
            }
        }

        $apiResponse = callApi($os, $receipt);

        //Mock Api dan gelen verilerin değişlkenlere aktarılması
        $status = $apiResponse['status'];
        if (isset($apiResponse['expireDate'])) {
            $expireDate = date('Y-m-d H:i:s', strtotime($apiResponse['expireDate']));
        };

        if (isset($apiResponse['message'])){
            $message = $apiResponse['message'];
        }
        $code = $apiResponse['code'];

        //status false olma durumunda hata mesajı return ediliyor.
        if ($status == true) {
            //Purchases tablosuna veri yazılıyor.
            try {
                //Purchase değerlerinin DB yazılması için purchase dizisi oluşturuldu.
                $purchase = [
                    'purchaseId' => $purchaseId,
                    'receipt' => $receipt,
                    'expireDate' => $expireDate
                ];
                PurchaseModel::insert($purchase);
                return response()->json([
                    'uid' => $uid,
                    'os' => $os,
                    'receipt'=>$receipt,
                    'appId' => $appId,
                    'expireDate' => $expireDate,
                ]);
            } catch (PDOException $e) {
                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'receipt' =>$receipt,
                    'message' => [
                        'Bir sorun oluştu. Daha sonra tekrar deneyin' => $e
                    ],
                ], 500);
            }
        } else {
            //receipt kodu kabul edilmedi
            return response()->json($message, $code);
        }
    }
}
