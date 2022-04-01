@extends('master')

@section('content')
    
<div class="container-fluid addToCart_Done">
    <div class="alert alert-success">
        <img class="productLogo" src="{{asset('assets/images/' . $product->image)}}" alt="">
        <h3>{{$product->name}} (商品{{$quantity}}点)</h3>
        <h2><strong>カートに入れました</strong></h2>
    </div>
    
    <a href="{{route('checkCart')}}"><button type="button" class="btn btn-outline btn-lg">カートの編集</button></a>
    <a href="{{route('home')}}"><button type="button" class="btn btn-warning btn-lg">買い物を続ける</button></a>
    
</div>

@endsection