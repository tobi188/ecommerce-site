<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="container mt-5" style="text-align:center">
    <a href="{{route('home')}}">
        <h2 class="">Kamazon</h2>
    </a>
</div>

<div class="container mt-5" style="text-align:center">
    <div class="">
        @if (isset($notSecureYet))
            @if ($notSecureYet)
                <h3>アカウントは既に登録されましたが、<br>
                    まだ、メールで確認していません。
                </h3>
            @endif
        @else    
            <h3>新しいアカウントの作成が完了しました。</h3>
        @endif
        
        <p>   
            {{$email}}に<b>認証コード</b>を送りました。<br>
            以下にメールで受け取ったコードを入力してください 
        </p> 

        <form action="{{route('secure')}}" method="POST">
            @csrf
            <div class="form-group">
                @if(isset($fail))
                    @if($fail)
                        <div class="alert alert-danger" id="enteredCode_alert">
                            <strong>認証コードが違います</strong>
                        </div>
                    @endif   
                @endif
                <label for="secure_code"></label>
                <input type="text" class="form-control w-25 m-auto" name="secure_code" placeholder="" id="secure_code">
                <input type="hidden" name="user_id" value="{{$id}}">
            </div>
            <button type="submit" class="btn btn-success w-25">認証</button>
        </form>

    </div>
</div>   


<script>
    
</script>