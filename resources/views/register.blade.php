<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="container mt-5 mb-5 ml-auto" >
    <a href="{{route('home')}}">
        <h2 class="" style="text-align:center">Kamazon</h2>
    </a>
</div>

<div class="alertRegister">
    <div class="alert-content">
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p style="text-align:center">{{$error}}</p>
            @endforeach
        </div> 
    @endif
</div>

<div class="container w-25">
        <h2 style="text-align: center">アカウントを作成</h2>
 
        <div class="register_form">
            <form action="{{route('postRegister')}}" method="POST" id="myForm">
                @csrf
                <div class="form-group">
                    <label for="name">名前</label>
                    <input type="text" class="form-control" name="name" id="name" >
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" id="email" >
                </div>
                <div class="form-group">
                    <label for="pwd">パスワード</label>
                    <input type="password" class="form-control" name="pwd" id="pwd" >
                </div> 
                <div class="form-group">
                    <label for="re-pwd">パスワードを確認</label>
                    <input type="password" class="form-control" name="re-pwd" id="re-pwd">
                </div> 
                <div class="createAcc" style="text-align: center">
                    <button type="submit" class="btn btn-success btn-block" id="createAcc-btn">アカウントを作成する</button>
                </div>
            </form>
        </div>
        <hr>
        <div class="">既にアカウントを持っている人は<a href="{{route('login')}}">ログイン</a></div><br>
    
</div>

<script>
    function submitLoading(event){
        event.preventDefault();
        $('#createAcc-btn').prop('disabled', true);
        $('#createAcc-btn').html("<span class='spinner-border spinner-border-sm' disabled></span>Loading...");
        $('#myForm').submit();
    }
    $(function(){
        $(document).on('click', '#createAcc-btn' , submitLoading);
    })
</script>
