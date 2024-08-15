<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'article';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public static function insert($title, $body): int
    {
        $newArticle = new self();
        $newArticle->title = $title;
        $newArticle->body = $body;
        $newArticle->status = "1";
//        $newArticle->createTime = now();
//        $newArticle->updateTime = now();
        $newArticle->save();
        return $newArticle->id;
    }
}
