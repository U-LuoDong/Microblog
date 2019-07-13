<?php

namespace App\Http\Controllers;

use App\Notifications\FindPasswordNotify;
use App\User;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * 显示找回密码的视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function email()
    {
        return view('password.email');
    }

    /**
     * 发送邮件
     * @param Request $request
     */
    public function send(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        \Notification::send($user, new FindPasswordNotify($user->email_token));
        return view('password.send');
    }

    /**
     * 修改密码界面
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($token)
    {
        $user = $this->getUserByToken($token);
        return view('password.edit', compact('user'));
    }

    /**
     * 更新密码
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:5|confirmed'
        ]);
        $user = $this->getUserByToken($request->token);
        $user->password = bcrypt($request->password);
        $user->save();
        session()->flash('success', '修改密码成功');
        return redirect()->route('login');
    }

    /**
     * 封装 通过验证码找到对应用户
     * @param $token
     * @return User|\Illuminate\Database\Eloquent\Model|null
     */
    protected function getUserByToken($token)
    {
        return User::where('email_token', $token)->first();
    }
}
