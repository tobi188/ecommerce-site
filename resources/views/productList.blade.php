@extends('master')
@section('content')
    <div class="container">
        <h2>{{$brandName}}</h2>
        <div class="row">
            @foreach($pdtList as $p)
                <div class="col-sm-3">
                    <a href="{{route('ProductDetail',['id' => $p->id])}}"><img src="../assets/images/{{$p->image}}" width="200" height="200" alt=""></a>
                    <h4>{{$p->name}}</h4>
                    <h4 style="color:#B12704">{{number_format($p->price)}}</h4>      
                </div>
            @endforeach
        </div>
    </div>
    
@endsection