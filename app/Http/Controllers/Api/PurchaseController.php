<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\PurchaseModel;
use App\Models\Api\RegisterModel;
use App\Models\Api\ApplicationModel;
use http\Exception;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase(Request $request): \Illuminate\Http\JsonResponse
    {
//        $receipt = $request->receipt;

        //clientToken Değeri ile Requestin geldiği cihazı belirliyoruz.
        $register = RegisterModel::where('clientToken', '=', $request->clientToken)->get();
        $uid = $register[0]->uid;

        //clientToken Değeri ile Requestin geldiği uygulamayı belirliyoruz.
        $applications = ApplicationModel::where('uid', '=', $uid)->get();
        $appId = $applications[0]->appId;

        //Cihaz ve uygulama bilgisi ile birlikte satın alma ıd'sini oluşturuyoruz.
        $purchaseId = $uid . $appId;


        $receipt = mt_rand(1000000000, 9999999999);


        $purchase = ['purchaseId' => $purchaseId,];


//        try {
//            PurchaseModel::create($purchase);
//        } catch (Exception $e) {
//            return response()->json(['Bir sorun oluştu lütfen daha sonra deneyin. Hata: ' . $e->getMessage()], 500);
//        }
//        return response()->json(['Satın alma başarılı', 'Satın alma Id: ' . $purchaseId], 200);
    }
}
