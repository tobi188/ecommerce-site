@extends('master');

@section('content')
<div class="errors_panel" style="text-align: center" >
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{$error}}<br>
            @endforeach
        </div>
    @endif
</div>

    @php
        if(isset($buyNowCart)){
            $buy_url = route('buyNow',['id'=> $buyNowCart['id'], 'quantity' => $buyNowCart['quantity']]);
            unset($buyNowCart);
        }
        else {
            $buy_url = route('bought');
        }
    @endphp

 
<div id="log"></div>
    <div class="container">
        <div class="container-content">
            <form action="{{$buy_url}}" method="POST" id="myForm">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <h2>配送先</h2>
                        <div class="form-group">
                            <label for="customer_name">お客様の名前</label>
                            <input type="text" class="form-control" name="customer_name" id="customer_name" value={{Auth::user()->fullname}} required>
                        </div>
                        <div class="form-group">
                            <label for="customer_post">郵便番号</label>
                            <br>
                            <input type="text" class="form-control" name="post" id="customer_post" size="10" maxlength="8" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_address">住所</label>
                            <br>
                            <input type="text" class="form-control" name="address" id="customer_address" size="40" value={{Auth::user()->address}} required>
                        </div>
                        <div class="form-group">
                            <label for="customer_tel">電話番号</label>
                            <br>
                            <input type="text" class="form-control" name="customer_tel" id="customer_tel" size="2" value={{Auth::user()->tel}} required>
                        </div>
                        <div class="form-group">
                            <label for="customer_email">メールアドレス</label>
                            <br>
                            <input type="text" class="form-control" name="customer_email" id="customer_email" value="{{Auth::user()->email}}" size="2" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h2>支払い方法</h2>
                        <br>
                        <div class="customer_payment">
                      
                            <div class="form-check payment_select">
                                <div class="cvn-payment">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input"  id="cvn" name="payMethod"  value="cvn" checked> 
                                        コンビニ・電子マネー払い可。
                                    </label>
                                </div>
                                <div class="payment-img">
                                    <img src="{{asset('assets/images/con_payment.png')}}" alt="" width="160" height="100">
                                </div>
                            </div>
                            <br>
                            <div class="form-check payment_select">
                                <div class="cod-payment">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input"  id="cod"  name="payMethod" value="cod" > C.O.D(代金引換)
                                    </label>
                                </div>
                                <div class="payment-img">
                                    <img src="{{asset('assets/images/cod.jpg')}}" alt="" width="160" height="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="buy-btn" class="btn btn-danger">購入する</button>
                </div>
                
            </form>
        </div>
    </div>
  
    
    <script>
       
        function submitLoading(event){
            event.preventDefault();
            $('#buy-btn').prop('disabled', true);
            $('#buy-btn').html("<span class='spinner-border spinner-border-sm' disabled></span>通信中...");
            $('#myForm').submit();
        }
        $(function () {
            $(document).on('click', '#buy-btn' , submitLoading);
        })
        
    
    </script>


@endsection

