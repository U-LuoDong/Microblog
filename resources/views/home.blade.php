@extends('layouts.default')
@section('content')
    @include('layouts._message')
    @auth
        <form action="{{route('blog.store')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="card">
                <div class="card-header">
                    发布博客
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">内容</label>
                        <textarea class="form-control" name="content">{{old('content')}}</textarea>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-success">发表</button>
                </div>
            </div>
        </form>
    @endauth
    {{--博客列表--}}
    <div class="card mt-2">
        <div class="card-header">
            博客列表
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                @foreach($blogs as $blog)
                    <tr>
                        <td>
                            {{$blog['content']}}
                            @can('delete',$blog)
                                <form action="{{route('blog.destroy',$blog)}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                    {{--        @method('PUT')--}}{{--  5.6的--}}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger btn-sm">删除</button>
                                </form>
                            @endcan
                        </td>
                        <td>
                            <a href="{{route('user.show',$blog->user)}}" class="card-link">{{$blog->user->name}}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">
            {{$blogs->links()}}
        </div>
    </div>
@endsection