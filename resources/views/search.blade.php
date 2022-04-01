@extends('master')

@section('content')
    
    <div class="container">
        @if(!count($products))
            <div style="text-align: center" class="alert alert-danger">
                <h2 >商品が見つかりません。<h2>
                <h3> 検索条件を変えて、再度お試しください。</h3>
            </div>
        @else
            <div class="search-word">
                <h3>"{{$word}}"の検索結果</h3>
            </div>
            <div class="row">
                @foreach($products as $p)
                    <div class="col-sm-3">
                        <a href="{{route('ProductDetail',['id' => $p->id])}}"><img src="{{asset('assets/images/' . $p->image)}}" width="200" height="200" alt=""></a>
                        <h4>{{$p->name}}</h4>
                        <h4 style="color:#B12704">{{number_format($p->price)}}</h4>      
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection