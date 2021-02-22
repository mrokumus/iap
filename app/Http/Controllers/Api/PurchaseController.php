<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Android\AndroidController;
use App\Http\Controllers\Api\Ios\IosController;
use App\Http\Controllers\Controller;
use App\Models\Api\PurchaseModel;
use App\Models\Api\RegisterModel;
use App\Models\Api\ApplicationModel;
use Illuminate\Http\Request;
use PDOException;

class PurchaseController extends Controller
{

    private $receipt;
    private $os;


//    function callApi()
//    {
//        $AndroidController = new AndroidController();
//        $name = $AndroidController->check($this->receipt);
//        echo $name;    //Prints John
//    }


    public function purchase(Request $request): \Illuminate\Http\JsonResponse
    {
        //clientToken Değeri ile Requestin geldiği cihazı ve sistemini belirliyoruz.
        $register = RegisterModel::where('clientToken', '=', $request->clientToken)->get();
        $uid = $register[0]->uid;
        $this->os = $register[0]->os;
        $this->receipt = $request->receipt;

        //clientToken Değeri ile Requestin geldiği uygulamayı belirliyoruz.
        $applications = ApplicationModel::where('uid', '=', $uid)->get();
        $appId = $applications[0]->appId;

        //Cihaz ve uygulama bilgisi ile birlikte satın alma ıd'sini oluşturuyoruz.
        $purchaseId = $uid . $appId;

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

        $apiResponse = callApi($this->os, $this->receipt);

        //Mock Api dan gelen verilerin değişlkenlere aktarılması
        $status = $apiResponse['status'];
        $expireDate = isset($apiResponse['expireDate']);
        $message = isset($apiResponse['message']);
        $code = $apiResponse['code'];

        //status false olma durumunda hata mesajı return ediliyor.
        if ($status == true) {
            //Purchases tablosuna veri yazılıyor.
            try {
                //Purchase değerlerinin DB yazılması için purchase dizisi oluşturuldu.
                $purchase = ['purchaseId' => $purchaseId, 'expireDate' => $expireDate,];
                PurchaseModel::create($purchase);
                return response()->json([
                    'uid' => $uid,
                    'os' => $this->os,
                    'appId' => $appId,
                    'expireDate' => $expireDate,
                ]);
            } catch (PDOException $e) {
                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'message' => 'Bir sorun oluştu. Daha sonra tekrar deneyin'
                ], 500);
            }
        } else {
            //receipt kodu kabul edilmedi
            return response()->json($message, $code);
        }
    }
}
