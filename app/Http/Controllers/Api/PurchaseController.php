<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Android\AndroidModel;
use App\Models\Api\PurchaseModel;
use App\Models\Api\RegisterModel;
use App\Models\Api\ApplicationModel;
use App\Models\Ios\IosModel;
use http\Exception;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase(Request $request): \Illuminate\Http\JsonResponse
    {
        //clientToken Değeri ile Requestin geldiği cihazı ve sistemini belirliyoruz.
        $register = RegisterModel::where('clientToken', '=', $request->clientToken)->get();
        $uid = $register[0]->uid;
        $os = $register[0]->os;

        //clientToken Değeri ile Requestin geldiği uygulamayı belirliyoruz.
        $applications = ApplicationModel::where('uid', '=', $uid)->get();
        $appId = $applications[0]->appId;

        //Cihaz ve uygulama bilgisi ile birlikte satın alma ıd'sini oluşturuyoruz.
        $purchaseId = $uid . $appId;


        if ($os == 1)#android
        {
            $result = AndroidModel::where('receipt','=',$request->receipt)->list('receipt','validation');

        }else{#ios
            $result = IosModel::where('receipt','=',$request->receipt)->get();
        }
        $purchase = ['purchaseId' => $purchaseId,];

        return response()->json($result, 200);

//        try {
//            PurchaseModel::create($purchase);
//        } catch (Exception $e) {
//            return response()->json(['Bir sorun oluştu lütfen daha sonra deneyin. Hata: ' . $e->getMessage()], 500);
//        }
//        return response()->json(['Satın alma başarılı', 'Satın alma Id: ' . $purchaseId], 200);
    }
}
