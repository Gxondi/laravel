<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \App\Models\ArticleUser;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'updateTime';
    //填充字段
    protected $fillable = ['username', 'password', 'createTime', 'updateTime'];
    //DB　新規登録　作業
    public static function doReg($regValue): bool
    {
        //usernameが存在するかどうかを確認
        $user = DB::table('users')->where('username', $regValue['username'])->first();
        //dump("user" , $user);
        if ($user !== null) {
            return true;
        }else{
            //新規登録DBに保存
            $newUser = new self();
            $newUser->username = $regValue['username'];
            $newUser->password = Hash::make($regValue['password']);
            $newUser->createTime = now();
            $newUser->updateTime = now();
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
