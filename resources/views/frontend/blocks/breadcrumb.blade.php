<ul class="breadcrumb">
    <li><a href="/">Trang chủ</a></li>
    @foreach($breadcrumb as $i => $bc)
        @if ($i+1 == count($breadcrumb))
            <li class="active">{{$bc['name']}}</li>
        @else
            <li><a href="{{$bc['link']}}">{{$bc['name']}}</a></li>
        @endif
    @endforeach
</ul>