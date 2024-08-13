<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleUser extends Model
{
    use HasFactory;

    protected $table = 'article_user';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'updateTime';
    //填充字段
    protected $fillable = ['userId', 'articleId', 'createTime', 'updateTime'];
    // ユーザーＩＤによって記事ＩＤを取得
    public static function getArticleById($userId): \Illuminate\Support\Collection
    {
        return self::join("article as a", "article_user.article_id", "=", "a.id")
            ->where("article_user.user_id", $userId)
            ->where("a.status", "1")
            ->select("a.id", "a.title", "a.body", "a.createTime", "a.updateTime", "a.status")
            ->get();
    }
    /**
     * @param $articleId
     * @param $userId
     * @return bool
     * 記事とユーザーを関連付ける
     */
    public static function insertArticleUser($articleId, $userId): bool
    {
        $articleUser = new self();
        $articleUser->article_id = $articleId;
        $articleUser->user_id = $userId;
        $articleUser->createTime = now();
        $articleUser->updateTime = now();
        $articleUser->save();
        return true;
    }
}
