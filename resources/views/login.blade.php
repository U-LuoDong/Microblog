@extends('layouts.default')
@section('content')
    @include('layouts._errors')
    @include('layouts._message')
    <form action="{{route('login')}}" method="post">
        {{--        跨域连接问题--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="card">
            <div class="card-header">用户登录</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">邮箱</label>
                    <input type="text" class="form-control" name="email" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label for="">密码</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for=""></label>
                    <a href="{{route('FindPasswordEmail')}}">找回密码</a>
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-success">登录</button>
            </div>
        </div>
    </form>
@endsection