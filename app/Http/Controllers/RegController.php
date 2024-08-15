<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\UserInfo;

class RegController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     * ログイン　プロセス
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        $username = $request->post('username');
        $password = $request->post('password');
        $confirm_password = $request->post('confirm_password');
        //$post = $request->post();
        //dump($post);
        if ($password != $confirm_password) {
            return redirect()->back()->with('error', 'パスワードが一致しない');
        }

        $regValue = [
            'username' => $username,
            'password' => $password,
        ];

        if (UserInfo::doReg($regValue) === true) {
            return redirect()->route('login')->with(['success' => '登録成功']);
        } else {
            return redirect()->back()->with('error', '登録失敗');
        }
    }
}
