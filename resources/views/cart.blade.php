@extends('master')

@section('content')

    <div class="container mt-3">
        <h1 style="text-align: center">カート</h1>
    </div> 
    @if(!session()->has('Cart'))
        <div style="text-align:center" class="container">
            <h2 >商品はありません</h2>
            <a href="{{ route('home') }}"><button class="btn btn-primary">ホームページㇸ</button></a>
        </div>
    
    @else

        @php
            $cart = session()->get('Cart');     
        @endphp

      
        <div class="container allCartPage">            
            <br>
            <div class="row">
                <div class="col-sm-8 cart_list">
                    <table class="table" class="update_cart_url" data-url="{{ route('updateCart') }}">
                
                        <tbody class="products_list">
                            @foreach($cart->products as $id => $c)
                                <tr class="up">
                                    <td>
                                        <img class="productLogo" src="assets/images/{{ $c['productInfo']->image}}" alt="">
                                        {{ $c['productInfo']->name }} 
                                    </td>
                                    <td>
                                        <input type="number" class="qty" value="{{ $c['quantity'] }}" data-id="{{$id}}" min="1" style="width: 3em"> 個
                                    </td>
                                    <td> 
                                        ￥{{ number_format($c['productInfo']->price)}}(単価)
                                    </td>
                                    <td> 
                                        <button type="button" class="btn btn-danger btn-sm del" data-id="{{$id}}">削除</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4 checkout">
                    <div class="checkout-total">
                        <h2>品数 :  {{$cart->quantities}}  個</h2>
                        <h2>合計 : ￥{{number_format($cart->total)}} </h2>
                        <input type="hidden" id="cart-quantity-update" value="{{$cart->quantities}}">
                    </div>
                    <div class="buy-btn">
                        <a class="pres" href="{{route('buy')}}">
                            <button type='button' class='btn btn-success btn-lg'>レジに進む</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>  

        <script>
            function cartUpdate(event){
                event.preventDefault();
                
                let id = $(this).data('id');
                quantity = $(this).parents('tr').find('input.qty').val();
                
                
                $.ajax({
                    type: "GET",
                    url: "updateCart",
                    data: {
                        id : id,
                        quantity : quantity,
                    },
                    success: function (response) {
                        $('.checkout-total').empty();
                        $('.checkout-total').html(response);
                        quantities = $('#cart-quantity-update').val();
                        cartIcon_html = "<span style='font-size:16px' class='label label-primary'>" + quantities + "</span></a>";   
                        $('#cart #cart_total').empty();
                        $('#cart #cart_total').html(cartIcon_html);
                    }   
                });
            }

            function cartDelete(event){
                event.preventDefault();
                
                let id = $(this).data('id');
                
                $.ajax({
                    type: "GET",
                    url: "deleteCart",
                    data: {
                        id : id,
                    },
                    success: function (response) {
                        quantities = $('#cart-quantity-update').val();
                        $('.allCartPage').empty();
                        $('.allCartPage').html(response);
                        quantities = $('#cart-quantity-update').val();
                        if(typeof quantities == "undefined"){
                            cartIcon_html = "<span style='font-size:16px' class='label label-primary'>0</span></a>";   
                        }else
                            cartIcon_html = "<span style='font-size:16px' class='label label-primary'>" + quantities + "</span></a>";   
                        $('#cart #cart_total').empty();
                        $('#cart #cart_total').html(cartIcon_html);
                    }   
                });
            }
            $(function () {
                $(document).on('blur', '.qty', cartUpdate);
            })

            $(function () {
                $(document).on('click', '.del', cartDelete);
            })

        </script>

    @endif
    
@endsection

