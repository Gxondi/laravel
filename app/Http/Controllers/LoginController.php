<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     * ログイン　プロセス
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        $username = $request->post('username');
        $password = $request->post('password');
        $user = UserInfo::where('username', $username)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', 'パスワードが一致しない');
        }
        $jwt = $this->getValidTokenByUserId($user->id);
        if (!$jwt) {
            $jwt = $this->generateJwt($user->id);
            DB::beginTransaction();
            try {
                $this->saveInRedis($user, $jwt);
                $user->token = $jwt;
                $user->save();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'ログイン失敗');
            }
        }
        Cookie::queue('token', $jwt, 60);
        return redirect()->route('userCenter')->with([
            'success' => 200,
        ]);

    }
    /*
     * @param $token
     * 验证token是否有效
     */
    private function isValidToken($jwt): bool
    {
        try {
            $key = config('jwt.secret',env('JWT_SECRET'));

            JWT::decode($jwt, $key, ['HS256']);
            return true;
        }catch (Exception $e) {
            return false;
        }
    }
    /*
     * @param $id
     * 获取有效token
     */
    private function getValidTokenByUserId($id): ? string
    {
        $jwt = Redis::get('jwt_token_' . $id);
        if($jwt && $this->isValidToken($jwt)){
            return $jwt;
        }
        return '';
    }
    /**
     * @param $userId
     * @return string
     */
    public function generateJwt($userId): string
    {
        $payload = [
            'iss' => "myNotes",
            'sub' => $userId,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ];
        $key = env('JWT_SECRET');
        $keyId = "keyId";
        return JWT::encode($payload, $key, 'HS256', $keyId);
    }

    /**
     * @param $user
     * @param string $jwt
     * @return void
     */
    public function saveInRedis($user, string $jwt): void
    {
        Redis::set('jwt_token_' . $user->id, $jwt);
        Redis::expire('jwt_token_' . $user->id, 60 * 60);
    }




}
