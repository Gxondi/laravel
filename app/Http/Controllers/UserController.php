<?php

namespace App\Http\Controllers;

use App\Models\ArticleUser;
use App\Models\UserInfo;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use Illuminate\View\View;

class UserController extends Controller
{
    public function showData(Request $request): View
    {
        $token = $request->cookie('token');
        $userInfoResp = $this->getUserInfo($token);
        $articlesResp = $this->getArticles($token);
        $userInfo = json_decode($userInfoResp->content(), true);
        $articles = json_decode($articlesResp->content(), true);
        return view('user/userCenter', ['userInfo' => $userInfo, 'articles' => $articles]);
    }
    /**
     * @param $token
     * @return JsonResponse
     */
    public function getUserInfo($token): JsonResponse
    {
        $result = $this->validateAndDecodeToken($token);
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error'], 'message' => $result['message'] ?? ''], $result['status']);
        }
        $userId = $result['userId'];
        $user = UserInfo::find($userId);
        if ($user) {
            return response()->json(['success' => 200, 'user' => $user]);
        } else {
            return response()->json(['error' => 'ユーザーが見つかない'], 404);
        }
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function getArticles($token): JsonResponse
    {
        $result = $this->validateAndDecodeToken($token);
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error'], 'message' => $result['message'] ?? ''], $result['status']);
        }

        $userId = $result['userId'];
        $user = UserInfo::find($userId);
        if (!$user) {
            return response()->json(['error' => 'ユーザーが見つかない'], 404);
        }

        $articles = $user->getArticles($userId);
        if ($articles->isEmpty()) {
            return response()->json(['error' => '記事が見つかない'], 404);
        }

        return response()->json(['success' => 200, 'articles' => $articles->toArray()]);
    }
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     * 記事をアップロード
     */
    public function upload(Request $request): RedirectResponse
    {
        $title = $request->input('title');
        $body = $request->input('body');
        $token = $request->cookie('token');

        // token
        $result = $this->validateAndDecodeToken($token);
        if ($title === null || $body === null) {
            return redirect()->route('userCenter')->with('error', 'タイトルと本文は必須');
        }
        if (isset($result['error'])) {
            return redirect()->route('userCenter')->with('error', 'ログインしてください');
        }

        $userId = $result['userId'];
        // トランザクション開始
        DB::beginTransaction();
        try {
            $articleId = Article::insert($title, $body);
            if ($articleId) {
                $result = ArticleUser::insertArticleUser($articleId, $userId);
                if ($result) {
                    DB::commit();
                    return redirect()->route('userCenter')->with(['success' => '200']);
                }
            }
            DB::rollBack();
            return redirect()->route('userCenter')->with('error', '記事のアップロードに失敗しました');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('userCenter')->with('error', '記事のアップロードに失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function deleteArticle(Request $request, $id): RedirectResponse
    {
        try {
            $article = Article::find($id);
            if ($article) {
                $article->status = 0;
                $article->save();
                return redirect()->route('userCenter')->with(['success' => '200'],);
            } else {
                return redirect()->route('userCenter')->with('error', '記事が見つかない');
            }
        } catch (Exception $e) {
            return redirect()->route('userCenter')->with('error', '記事の削除に失敗しました: ' . $e->getMessage());
        }
    }
    private function validateAndDecodeToken($token): array
    {
        if (!$token) {
            return ['error' => '不正訪問', 'status' => 401];
        }
        try {
            $key = new Key(env('JWT_SECRET'), 'HS256');
            $payload = JWT::decode($token, $key);
            return ['userId' => $payload->sub];
        } catch (Exception $e) {
            return ['error' => '無効訪問', 'message' => $e->getMessage(), 'status' => 401];
        }
    }
}
