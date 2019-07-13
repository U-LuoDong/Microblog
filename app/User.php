<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 与博客表进行一对多关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    /**
     * 获取所有粉丝 通过用户表的id字段查找follow表的user_id字段  然后找到其follower字段对应的值【下面同理 只是换了个顺序】
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follower()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower');
    }

    /**
     * 获取所有关注【就是获取该用户关注的人】
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower', 'user_id');
    }

    /**
     * 该用户是否是登录用户的粉丝
     * @param $uid
     * @return mixed
     */
    public function isFollow($uid)
    {
        return $this->follower()->wherePivot('follower', $uid)->first();
    }

    /**
     * 关注或取关 利用框架的toggle实现【如果follower函数没有查询到就会自动添加数据】
     * @param $ids
     * @return array
     */
    public function followToggle($ids)
    {
        $ids = is_array($ids) ?: [$ids];//如果不是数组就包装成数组
        //$this代表的就是该博客的用户实例【前面控制器中对应的博客用户调用模型的方法】
        return $this->follower()->withTimestamps()->toggle($ids);//withTimestamps实现向follow表中补充那两个时间的字段
    }
}
