{{--循环success和danger两个session数组--}}
@foreach(['success','danger'] as $t)
    @if(session()->has($t))
        <div class="alert alert-{{$t}}" role="alert">
            <strong>{{session()->get($t)}}</strong>
        </div>
    @endif
@endforeach