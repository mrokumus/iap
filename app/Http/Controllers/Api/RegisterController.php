<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        //Eğer $request->token varsa önce DB'de token araması yapılyor.
        if (!$request->token == null) {
            $device = RegisterModel::where('token', $request->token)->get();
            //Eğer $request->token DB'de kayıtlı değilse yeni token oluşturulup kayıt yapılıyor.
            if (isset($device)) {
                $token = Str::random(10);
                $device = [
                    'uid' => $request->uid,
                    'os' => $request->os,
                    'language' => $request->language,
                    'token' => $token
                ];
                RegisterModel::create($device);
                return response()->json(['Kayıt Başarılı','Client Token: ' . $token], 200);
            //Eğer $request->token DB'de varsa 200 OK mesajı gönderiliyor.
            } else {
                return response()->json(['Kayıt Zaten Var !','Client Token: ' . $request->token], 200);
            }
        } else {
        //Eğer $request->token yoksa kayıt yapılıyor.
            $token = Str::random(10);
            $device = [
                'uid' => $request->uid,
                'os' => $request->os,
                'language' => $request->language,
                'token' => $token
            ];
            RegisterModel::create($device);
            return response()->json(['Kayıt Başarılı','Client Token: ' . $token], 200);
        }
    }
}
