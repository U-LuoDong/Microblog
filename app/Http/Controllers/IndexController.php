<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Mail\RegMail;
use App\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home(){
        //1、使用降序【最新的在前面】
        //2、with相当于MySQL的内连接查询 后面视图中就可以直接使用了
        //这里使用了关联模型进行查找
        $blogs = Blog::orderBy('id','DESC')->with('user')->paginate(10);
        return view("home",compact("blogs"));
    }
}
