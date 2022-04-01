@extends('master')

@section('content')
<style>
    .pdtDetail-div {
        margin-top: 50px;
    }
</style>
<div class="container pdtDetail-div">
    <div class="row">
        <div class="col-sm-6">
            <div class="product-image">
                <img src="{{asset('assets/images/' . $product->image)}}" alt="">
            </div>
            <br>
            <div class="product-detail">
                {{$product->description}}   
            </div>
        </div>
        <div class="col-sm-6">
            <h1>{{$product->name}}</h1>
            <h3>価格：{{number_format($product->price)}}円</h3>
            <form action="{{route('AddCart',["id" => $product->id ])}}" method="POST">
                {{ csrf_field() }}
                <br>
                <label for="quantity" style="font-size:16px" >数量:　</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" style="width: 3.5em">
                <br><br>
                <button type="submit" class="btn btn-primary btn-lg " name="buy_btn" >カートに入れる</button>
                <button type="submit" class="btn btn-danger btn-lg " name="buy_btn" value="1">今すぐ購入する</button>
            </form>
            
        </div>
    </div>
</div>

@endsection

<script>
    
</script>