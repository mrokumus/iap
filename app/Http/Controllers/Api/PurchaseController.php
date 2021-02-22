<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Android\AndroidController;
use App\Http\Controllers\Api\Ios\IosController;
use App\Http\Controllers\Controller;
use App\Models\Api\PurchaseModel;
use App\Models\Api\RegisterModel;
use App\Models\Api\ApplicationModel;
use Carbon\Carbon;
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
                $receipt = $androidController->check($receipt);
                $response = $receipt->original;
                $expireDate = $response['expireDate'];
                $status = $response['status'];
                return ['expireDate' => $expireDate, 'status' => $status];
            } elseif ($os == 0) {
                $iosController = new iosController();
                $receipt = $iosController->check($receipt);
                $response = $receipt->original;
                $expireDate = $response['expireDate'];
                $status = $response['status'];
                return ['expireDate' => $expireDate, 'status' => $status];
            } else {
                return response()->json(['Bilinmeyen İşletim Sistemi', 400]);
            }
        }

        $apiResponse = callApi($this->os, $this->receipt);

        //expireDate ve status'un tanımlanması
        $expireDate = $apiResponse['expireDate'];
        $status = $apiResponse['status'];


        //status false olma durumunda hata mesajı return ediliyor.
        if ($status == true) {
            //Purchases tablosuna veri yazılıyor.
            //Purchase değerlerinin DB yazılması için purchase dizisi oluşturuldu.
            $purchase = ['purchaseId' => $purchaseId, 'expireDate' => $expireDate,];
            PurchaseModel::create($purchase);
            return response()->json([
                'uid' => $uid,
                'os' => $this->os,
                'appId' => $appId,
                'expireDate' => $expireDate,
            ]);
        } else {
            //receipt kodu kabul edilmedi
            $message = ['message' => 'Geçersiz kod'];
            return response()->json($message, 401);
        }
    }
}
