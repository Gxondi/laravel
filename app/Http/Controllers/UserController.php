<?php

namespace App\Http\Controllers;

use App\Models\ArticleUser;
use App\Models\UserInfo;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Article;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * ユーザー情報を取得
     */
    public function getUserInfo(Request $request): JsonResponse
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'トークンが提供されていません'], 401);
        }
        //dump($token);
        try {
            $key = new Key(env('JWT_SECRET'), 'HS256');
            $payload = JWT::decode($token, $key);
            $userId = $payload->sub;
            $user = UserInfo::find($userId);

            if ($user) {
                return response()->json(['success' => 200, 'result' => $user]);
            } else {
                return response()->json(['error' => 'ユーザーが見つかりません'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => '無効なトークン'], 401);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * ユーザーの記事を取得
     */
    public function getArticles(Request $request): JsonResponse
    {
        //TOKENの取得
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'トークンが提供されていません'], 401);
        }
        //チェック
        try {
            $key = new Key(env('JWT_SECRET'), 'HS256');
            $payload = JWT::decode($token, $key);
            $userId = $payload->sub;
        } catch (Exception $e) {
            return response()->json(['error' => '無効なトークン', 'message' => $e->getMessage()], 401);
        }
        //ユーザーＩＤによって情報を取得
        $user = UserInfo::find($userId);
        if (!$user) {
            return response()->json(['error' => 'ユーザーが見つかりません'], 408);
        }
        //ユーザーの記事を取得
        $articles = $user->getArticles($userId);
        if ($articles->isEmpty()) {
            return response()->json(['error' => '記事が見つかりません'], 408);
        }
        return response()->json(['success' => 200, 'result' => $articles->toArray()]);

    }
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * 記事をアップロード
     */
    public function upload(Request $request): JsonResponse
    {
        $title = $request->input('title');
        $body = $request->input('body');
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => '不正訪問'], 401);
        }
        if ($title === null || $body === null) {
            return response()->json(['error' => 'タイトルと本文がNullです'], 400);
        }
        //チェック
        try {
            $key = new Key(env('JWT_SECRET'), 'HS256');
            $payload = JWT::decode($token, $key);
            $userId = $payload->sub;
        } catch (Exception $e) {
            return response()->json(['error' => '無効なトークン', 'message' => $e->getMessage()], 401);
        }
        //トランザクション開始
        DB::beginTransaction();
        try {
            $articleId = Article::insert($title, $body);
            if($articleId){
                $result = ArticleUser::insertArticleUser($articleId, $userId);
                if($result){
                    DB::commit();
                    return response()->json(['success' => 200, 'result' => '記事がアップロードされました']);
                }
            }
        }catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'ロールバックに失敗しました', 'message' => $e->getMessage()], 401);
        }
        return response()->json(['error' => 'アップロードに失敗しました'], 401);
    }
    /**
     * @param $id
     * @return JsonResponse
     * @throws Exception
     * 記事を削除
     */
    public function deleteArticle($id): JsonResponse
    {

        try {
            $article = Article::find($id);
            if ($article) {
                $article->status = 0;
                $article->save();
                return response()->json(['success' => 200, 'result' => '記事が削除されました']);
            } else {
                return response()->json(['error' => '記事が見つかりません'], 404);
            }
        }catch (Exception $e) {
            return response()->json(['error' => '記事の削除に失敗しました', 'message' => $e->getMessage()], 500);
        }
    }
}
