<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\RegisterModel;
use App\Models\Api\ApplicationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        //Eğer $request->clientToken varsa önce DB'de clientToken araması yapılyor.
        if (!$request->clientToken == null) {
            $device = RegisterModel::where('clientToken', $request->clientToken)->get();
            //Eğer $request->clientToken DB'de kayıtlı değilse yeni clientToken oluşturulup kayıt yapılıyor.
            if (isset($device)) {
                $clientToken = Str::random(10);
                $device = [
                    'uid' => $request->uid,
                    'os' => $request->os,
                    'language' => $request->language,
                    'clientToken' => $clientToken
                ];
                RegisterModel::create($device);
                return response()->json(['Kayıt Başarılı','Client Token: ' . $clientToken], 200);
            //Eğer $request->clientToken DB'de varsa 200 OK mesajı gönderiliyor.
            } else {
                return response()->json(['Kayıt Zaten Var !','Client Token: ' . $request->clientToken], 200);
            }
        } else {
        //Eğer $request->clientToken yoksa kayıt yapılıyor.
            $clientToken = Str::random(10);
            $device = [
                'uid' => $request->uid,
                'os' => $request->os,
                'language' => $request->language,
                'clientToken' => $clientToken
            ];
            $appId = [
              'appId' => $request->uid.$request->appId,
              'uid' =>$request->uid,

            ];

            RegisterModel::create($device);
            ApplicationModel::create($appId);
            return response()->json(['Kayıt Başarılı','Client Token: ' . $clientToken], 200);
        }
    }
}
