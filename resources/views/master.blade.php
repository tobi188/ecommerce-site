<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K-Ecommerce</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/navbar.css')}}" type="text/css">

</head>

<body>
    <div class="container">
        <div class="row pt-5">
            <div class="col-sm-2">
                <div class="siteLogo">
                    <a href="{{route('home')}}"><h2 class="">Kamazon</h2></a>
                </div>
            </div>

            <div class="col-sm-4">
                <form action="{{route('search')}}" method="POST" >
                    @csrf
                    <div class="input-group search-bar">
                        <input type="text" class="form-control" name="words" placeholder="なにかお探しですか？">
                    </div>
                </form>
            </div>

            @if ( Auth::check() )
                <div class="col-sm-4 user_base">
                    <div class="dropdown userAccount-btn">    
                        <span><b>こんにちは!</b></span>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            {{Auth::user()->fullname}}さん
                            <span class="caret"></span></button>
                        </button>
                        <ul class="dropdown-menu userAccount-info">
                            <li><a href="{{route('user-page')}}">プロファイルの編集</a></li>
                            <li><a href="#">注文歴史</a></li>
                            <li class="divider"><</li>
                            <li><a href="{{route('logout')}}">ログアウト</a></li>
                        </ul>
                    </div>
                </div>
            @else
                @php
                    if(session()->has('Cart'))
                       session()->flush();             
                @endphp
                <div class="col-sm-4 reg-log">
                    <div class="register-btn">      
                        <a href="{{ route('register') }}">
                            <button type="button" class="btn btn-danger">新規登録</button>
                        </a>
                    </div> 
                    <div class="login-btn">
                        <a href="{{route('login')}}">
                            <button type="button" class="btn btn-success">ログイン</button>
                        </a>
                    </div>
                </div>
            @endif   

            <div class="col-sm-2 shopping-cart">
                <a href="{{route('checkCart')}}">
                    <div id="cart">
                        <i class="fa fa-cart-plus fa-2x"></i>
                        <span id="cart_total">
                            @php
                                if(session()->has('Cart')){
                                    $cart = session()->get('Cart');
                                    echo "<span style='font-size:16px' class='label label-primary'>" . $cart->quantities . "</span>";
                                }
                                else {
                                    echo "<span style='font-size:16px' class='label label-primary'>0</span>";   
                                }
                            @endphp
                        </span>  
                    </div>
                </a>
            </div>
        </div>
    </div>
       
    
    {{--Navbar--}}

    @php
        $categories = array();

        foreach($nav as $n){
            $categories[] = $n;
        }
        function showCategories($categories, $parent_id = 0){
            $cate_child = array();
            foreach($categories as $key => $value){
                if($parent_id == $value->parent_id){
                    $cate_child[] = $value;
                    unset($categories[$key]);
                }
            }
            if($cate_child){
                echo "<ul>";
                    foreach($cate_child as $key => $value){
                        echo "<li><a href='". $value->url . "'>" . $value->name . "</a>";
                        showCategories($categories, $value->id);
                        echo "</li>";
                    }
                echo "</ul>";
            }
        }      
    @endphp

    <div class="container">
        <div class="navbar">
            {{showCategories($categories)}}
        </div>
    </div>

    <div class="border-div">
        
    </div>


    {{--CONTENT--}}

    @yield('content')    


    {{-- FOOTER --}}


</body>
</html>

<script>
    $(document).ready(function () {
        $('li').hover(function() {
            $(this).find('ul:first').slideDown();
        }, function(){
            $(this).find('ul:first').hide();
        });
    });
</script>