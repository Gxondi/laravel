<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
/**
 * @mixin Builder
 */
class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public $timestamps = true;
    //DB　新規登録　作業
    public static function doReg($regValue): bool
    {
        //usernameが存在するかどうかを確認
        $user = UserInfo::where('username', $regValue['username'])->first();
        //dump("user" , $user);
        if ($user !== null) {
            return true;
        }else{
            //新規登録DBに保存
            $newUser = new self();
            $newUser->username = $regValue['username'];
            $newUser->password = Hash::make($regValue['password']);
            //dump("newUser" , $newUser);
            return $newUser->save();
        }
    }

    /**
     * @param $userId
     * @return Collection
     * ユーザーの記事を取得
     */
    public static function getArticles($userId): Collection
    {
        return ArticleUser::getArticleById($userId);
    }
}
