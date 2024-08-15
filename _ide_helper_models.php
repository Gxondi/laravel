<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $Id
 * @property string|null $title
 * @property string|null $body
 * @property string|null $status
 * @property string|null $createtime
 * @property string|null $updatetime
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatetime($value)
 */
}

namespace App\Models{
/**
 * App\Models\ArticleUser
 *
 * @property int $Id
 * @property string|null $user_id 用户id
 * @property string|null $article_id
 * @property string|null $createtime
 * @property string|null $updatetime
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser whereCreatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser whereUpdatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleUser whereUserId($value)
 */
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password
 * @property string|null $token
 * @property string|null $createtime 创建时间
 * @property string|null $updatetime 修改时间
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserInfo
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password
 * @property string|null $token
 * @property string|null $createtime 创建时间
 * @property string|null $updatetime 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereCreatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereUpdatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInfo whereUsername($value)
 */

}

