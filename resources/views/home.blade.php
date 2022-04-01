
@extends('master')

@section('content')
    
    {{-- banner --}}

    <div class="banner">
        <img class="banner-img" src="{{asset('assets/images/ip-banner.jpg')}}" alt="">
    </div>
    <div class="favProducts-title">
        <h1 >人気の商品</h1><br>
    </div>
    @foreach($cate as $c)
        <div class="container my-5 favProducts-show">
            <h3 class="cate-name">{{$c->name}}</h3><br>
            <div class="row">
                @foreach($brand as $b)
                    @if($b->category_id == $c->id)
                        @foreach($product as $p)
                            @if($p->brand_id == $b->id)
                                <div class="col-sm-3"> 
                                    <div>
                                        <a href="{{route('ProductDetail',['id' => $p->id])}}"><img src="assets/images/{{$p->image}}" width="200" height="200" alt=""></a>
                                    </div>                       
                                    <h4>{{$p->name}}</h4>
                                    <h4 style="color:#B12704">¥{{number_format($p->price)}}</h4>                     
                                </div>              
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>   
        </div>
    @endforeach

@endsection
