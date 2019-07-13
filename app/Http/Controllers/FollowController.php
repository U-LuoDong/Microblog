<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * 显示粉丝页面
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function follower(User $user)
    {
        $users = $user->follower()->paginate(10);
        $title = '粉丝列表';
        return view('follow', compact('users','title'));
    }

    /**
     * 显示关注页面
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function following(User $user)
    {
        $users = $user->following()->paginate(10);
        $title = '关注列表';
        return view('follow', compact('users','title'));
    }
}
