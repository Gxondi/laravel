<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * ログイン　プロセス
     */
    public function doLogin(Request $request): JsonResponse
    {
        $username = $request->post('username');
        $password = $request->post('password');

        if (empty($username) || empty($password)) {
            return response()->json(['error' => '不正訪問'], 400);
        }

        $user = UserInfo::where('username', $username)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['error' => 'パスワードが一致しません'], 401);
        }

        $payload = [
            'iss' => "myNotes",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60*60
        ];

        $key = env('JWT_SECRET');
        $keyId = "keyId";
        $jwt = JWT::encode($payload, $key, 'HS256', $keyId);

        DB::beginTransaction();
        try {
            Redis::set('jwt_token_' . $user->id, $jwt);
            Redis::expire('jwt_token_' . $user->id, 60*60);
            $user->token = $jwt;
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'システムエラー'], 401);
        }

        return response()->json(['success' => 200, 'token' => $jwt, 'redirect_url' => route('userCenter')]);
    }
}
