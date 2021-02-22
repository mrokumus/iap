<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\RegisterModel;
use App\Models\Api\ApplicationModel;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDOException;

class RegisterController extends Controller
{

    public function register($uid, $os, $language, $clientToken = null)
    {
        //uid'si verilen ciahazın DB'den çekilmesi.
        $device = RegisterModel::where('uid', '=', $uid)->get();

        if (!empty($device[0])) {

            //uid bilgisi ile clientTokenın belirlenmesi.
            if (!empty($device[0]->clientToken)) {
                $clientToken = $device[0]->clientToken;
                $message = [
                    'uid' => $uid,
                    'os' => $os,
                    'language' => $language,
                    'clientToken' => $clientToken,
                ];
                return response()->json($message);
            } else {
                //Eğer clientToken DB'de kayıtlı değilse yeni clientToken oluşturulup kayıt yapılıyor.
                $clientToken = Str::random(10);
                $dev = [
                    'uid' => $uid,
                    'os' => $os,
                    'language' => $language,
                    'clientToken' => $clientToken
                ];
                $app = [
                    'appId' => Str::random(5),
                    'uid' => $uid,
                ];
                try {
                    RegisterModel::where('uid',$uid)->update($dev);
                    ApplicationModel::create($app);
                    $message = [
                        'uid' => $uid,
                        'os' => $os,
                        'language' => $language,
                        'clientToken' => $clientToken,
                        'message' => 'Cihaz Kaydedildi'
                    ];
                    return response()->json($message);

                } catch (PDOException $e) {
                    $message = [
                        'uid' => $uid,
                        'os' => $os,
                        'language' => $language,
                        'clientToken' => $clientToken,
                        'message' => [
                            'Bir sorun ile karşılaşıldı. Hata:' => $e
                        ]
                    ];
                    return response()->json($message, 500);
                }
            }

        } else {
            return response()->json('Böyle bir cihaz yok', 400);
        }
    }

}
