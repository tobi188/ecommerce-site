<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="container mt-5 mb-5 ml-auto" >
        <a href="{{route('home')}}">
            <h2 class="" style="text-align:center">Kamazon</h2>
        </a>
    </div>
    
    <div class="container w-25">
        
        <h2 style="text-align: center">ログイン</h2>
        
        <div class="alertRegister">
            <div class="alert-content">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <h1 style="text-align:center">{{$error}}</h1>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="loginFail">
            @if(session()->has('login'))
                @if((session()->get('login')) == "fail")
                    <div class="alert alert-danger">
                        メールアドレスまたはパスワードが違います
                    </div>
                @elseif((session()->get('login')) == "notYet")
                    <div class="alert alert-danger  ">
                        レジに進むの前に、ログインが必要です
                    </div>
                @endif
            @endif
        </div>

        <div class="login_form">
            <form action="{{route('postLogin')}}" method="POST" id="myForm">
                @csrf
            <div class="form-group">
                <label for="email">Eメール</label>
                <input type="email" class="form-control" id="email"  name="email" required>
            </div>
            <div class="form-group">
                <label for="pwd">パスワード</label>
                <input type="password" class="form-control" id="pwd"  name="pwd" required>
            </div> 
            <div class=""><a href="">パスワードを忘れた場合</a></div><br>
            
            <div style="text-align: center">
                <button type="submit" class="btn btn-success btn-block" id="login-btn">ログイン</button>
            </div>
            </form>
        </div>
        <hr>
        <div class="" style="text-align:center">
            <h5>初めてご利用ですか?</h5>
            <a href="{{route('register')}}">
                <button type="button" class="btn btn-danger btn-block">新規登録</button>
            </a>
        </div>
    </div>

<script>

    function submitLoading(event){
            event.preventDefault();
            $('#login-btn').prop('disabled', true);
            $('#login-btn').html("<span class='spinner-border spinner-border-sm' disabled></span>読み込み中...");
            $('#myForm').submit();
    }

    $(function(){
        $(document).on('click', '#login-btn' , submitLoading);
    })

</script>


      