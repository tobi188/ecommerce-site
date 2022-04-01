<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="banner-content">
                <h1 style="color:#337ab7;text-align: center" >Kamazon</h1>
            </div>
            <div style="text-align:center;font-size:16px;"　class="panel-content m-5">
                <p>
                    <b>{{$customer->name}}様 </b><br>
                    Kamazonをご利用いただき、ありがとうございます。
                </p>
                <div>
                    <h3>ご注文の内容</h3>
                    @php
                    foreach($bill_detail as $b){
                        $p = $products->where('id', $b->product_id)->first();
                        echo "<i>" . $p->name . "</i> (" . $b->quantity . "点)<br>";
                    } 
                    @endphp
                    <p>
                        注文合計：<span style="color:red;font-size:22px">{{number_format($bill->total)}}円</span>
                    </p> 
                </div>
                <div>
                    <h3>注文者</h3>
                    <p>{{$customer->name}}様</p>
                </div>
                <div>
                    <h3>お届け先</h3>
                    <p>〒{{$customer->post}}</p>
                    <p>{{$customer->address}}</p>
                    <p>{{$customer->tel}}</p>
                </div>
                <div>
                    <h3>お支払い方法</h3>
                    <p>{{$bill->payment_method}} </p>
                </div>
                <div>
                    <img src="assets/images/barcode.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

