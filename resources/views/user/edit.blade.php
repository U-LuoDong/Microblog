@extends('layouts.default')
@section('content')
    @include('layouts._errors')
    <form action="{{route('user.update',$user)}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
{{--        @method('PUT')--}}{{--  5.6的--}}
        {{ method_field('PUT') }}
        <div class="card">
            <div class="card-header">修改资料</div>
            <div class="card-body">
                <div class="form-group">
                    <label >昵称</label>
                    <input type="text" class="form-control" name="name" value="{{$user['name']}}">
                </div>
                <div class="form-group">
                    <label >密码</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label >确认密码</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            </div>
            <div class="card-footer text-muted">
                <button type="submit" class="btn btn-success">确定修改</button>
            </div>
        </div>
    </form>
@endsection