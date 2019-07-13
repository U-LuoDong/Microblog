<?php

namespace App\Http\Controllers;

use App\Mail\RegMail;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    /**
     * 使用中间件实现必须登录才能访问某些页面 except【不用登录也可以访问】
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show', 'create', 'store', 'confirmEmailToken']
        ]);
        //guest：游客状态【未登录】 仅限未登录用户使用的方法
        $this->middleware('guest', [
            'only' => ['create', 'store']
        ]);
    }
    /**
     * 显示用户列表
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(3);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *用户注册界面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * 用户注册处理逻辑
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:5|confirmed'
        ]);
        $data=array();
        $data['name']=($request['name']);
        $data['email']=($request['email']);
        $data['password'] = bcrypt($request['password']);//进行加密
//        dump($data);
        //添加用户
        $user = User::create($data);
        //发送注册邮件
        \Mail::to($user)->send(new RegMail($user));//发送给用户【表中一定要有email字段】
        session()->flash('success', '请查看邮箱完成注册验证');
        return redirect()->route('home');
    }

    /**
     * 关注或取关逻辑
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow(User $user)
    {
        $user->followToggle(\Auth::user()->id);
        return back();
    }

    /**
     * Display the specified resource.
     *个人博客页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $blogs = $user->blogs()->paginate('5');
        if (\Auth::check())//必须要在登录状态才能有关注功能
            $followTitle = $user->isFollow(\Auth::user()->id) ? '取消关注' : '关注';
        return view('user.show',compact('user','blogs', 'followTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *修改用户页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *修改用户信息逻辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'password' => 'nullable|min:5|confirmed'
        ]);
        $user->name = $request->name;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        session()->flash('success', '修改成功');
        return redirect()->route('user.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *删除用户
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        session()->flash('success', '删除成功');
        return redirect()->route('user.index');
    }

    /**
     * 注册邮箱验证
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmEmailToken($token)
    {
        $user = User::where('email_token', $token)->first();
        if ($user) {
            $user->email_active = true;
            $user->save();
            session()->flash('success', '验证成功');
            \Auth::login($user);
            return redirect('/');
        }
        session()->flash('danger', '邮箱验证失败');
        return redirect('/');
    }
}
