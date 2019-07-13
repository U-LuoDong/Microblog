<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * 跳转到登录界面
     */
    public function login(){
        return view('login');
    }

    /**
     * 实现用户登录功能
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);
        $data=array();
        $data['email']=($request['email']);
        $data['password'] = $request['password'];
//        $data['password'] = bcrypt($request['password']);//进行加密

        if (\Auth::attempt($data)) {
            session()->flash('success', '登录成功');
            return redirect('/');
        }
        session()->flash('danger', '帐号或密码错误');
        return back();
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        \Auth::logout();////使用系统的函数进行退出登录
        session()->flash('success', '退出成功');
        return redirect('/');
    }
}
