<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\UserInfo;

class RegController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * ログイン　プロセス
     */
    public function doRegister(Request $request): JsonResponse
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $confirm_password = $request->post('confirm_password');
        //$post = $request->post();
        //dump($post);
        if ($password != $confirm_password) {
            return response()->json(['error' => 'パスワードが一致しない'], 400);
        }

        $regValue = [
            'username' => $username,
            'password' => $password,
        ];

        if (UserInfo::doReg($regValue) === true) {
            return response()->json(['success' => 200, 'redirect_url' => route('login')]);
        } else {
            return response()->json(['error' => '登録に失敗した'], 401);
        }
    }
}
