<link rel="stylesheet" href="{{asset('assets/css/app.css')}}" type="text/css">
@extends('master')

@section('content')

    @if(!Auth::user())
        <div class="alert alert-danger">
            <h1>ログインが必要です。</h1>
        </div>
    @else
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $e)
                    <h4 style="text-align: center">{{$e}}</h4>
                @endforeach
            </div>
        @endif
        <div class="user-info_banner">
            <h2>プロファイル</h2>
        </div>
        <div class="container user-info">
            <form action="{{route('user-page')}}" method="POST">
            @csrf
                <div class="form-group">

                    <label for="name">名前 : </label> {{Auth::user()->fullname}}

                    <div id="userName-change" style="display: none">
                        <input type="text" class="form-control" name="name" placeholder="新しい名前を入力してください" id="name">
                        <button type="submit" class="btn btn-success" id="changeName-process">確認</button>
                        <button type="button" class="btn btn-danger" id="changeName-cancer">キャンセル</button>
                    </div>
                    
                    <button type="button" class="btn sm-btn" id="changeName-btn">編集</button>

                </div>

                <div class="form-group">

                    <label for="mail">メールアドレス : </label> {{Auth::user()->email}}

                    <div  id="userEmail-change" style="display: none">
                        <input type="email" class="form-control" name="mail" placeholder="新しいメールを入力してください" id="mail">
                        <button type="submit" class="btn btn-success" id="changeEmail-process" >確認</button>
                        <button type="button" class="btn btn-danger" id="changeEmail-cancer">キャンセル</button>
                    </div>
                    
                    <button type="button" class="btn sm-btn" id="changeEmail-btn">編集</button>

                </div>

                <div class="form-group">

                    <label for="address">住所 : </label>
                        @if(!Auth::user()->address)
                            {{"まだ、入力していません。"}}
                        @else 
                            {{Auth::user()->address}}  
                        @endif
                        
                    
                    </label>

                    <div  id="userAddress-change" style="display: none">
                        <input type="text" class="form-control" name="address" placeholder="新しい住所を入力してください" id="address">
                        <button type="submit" class="btn btn-success" id="changeAddress-process" required>確認</button>
                        <button type="button" class="btn btn-danger" id="changeAddress-cancer">キャンセル</button>
                    </div>
                    
                    <button type="button" class="btn sm-btn" id="changeAddress-btn">編集</button>

                </div>

                <div class="form-group">
                    
                    <label for="tel">
                        電話番号 : 
                    </label>
                        @if(!Auth::user()->tel)
                            {{"まだ、入力していません。"}}
                        @else 
                            {{Auth::user()->tel}}  
                        @endif

                    <div id="userTel-change" style="display: none">
                        <input type="text" class="form-control" name="tel" placeholder="新しい電話番号を入力してください" id="tel">
                        <button type="submit" class="btn btn-success" id="changeTel-process" required>確認</button>
                        <button type="button" class="btn btn-danger" id="changeTel-cancer">キャンセル</button>
                    </div>
                    
                    <button type="button" class="btn sm-btn" id="changeTel-btn">編集</button>

                </div>

            </form>
        </div>
    @endif


    <script>

        function showChangeName(e){
            e.preventDefault();
            $('#userName-change').show();
            $('.sm-btn').hide();
        };

        function closeChangeName(e){
            e.preventDefault();
            $('#userName-change').hide();
            $('#changeName-btn').show();
            $('.sm-btn').show();
        }

        function showChangeMail(e){
            e.preventDefault();
            $('#userEmail-change').show();
            $('.sm-btn').hide();
        };        

        function closeChangeMail(e){
            e.preventDefault();
            $('#userEmail-change').hide();
            $('#changeEmail-btn').show();
            $('.sm-btn').show();
        }

        function showChangeAddress(e){
            e.preventDefault();
            $('#userAddress-change').show();
            $('.sm-btn').hide();
        };

        function closeChangeAddress(e){
            e.preventDefault();
            $('#userAddress-change').hide();
            $('#changeAddress-btn').show();
            $('.sm-btn').show();
        }

        function showChangeTel(e){
            e.preventDefault();
            $('#userTel-change').show();
            $('.sm-btn').hide();
        };

        function closeChangeTel(e){
            e.preventDefault();
            $('#userTel-change').hide();
            $('#changeTel-btn').show();
            $('.sm-btn').show();
        }
        
        $(function () {

            $(document).on('click', '#changeName-btn', showChangeName);
            $(document).on('click', '#changeName-cancer', closeChangeName);

            $(document).on('click', '#changeEmail-btn', showChangeMail);
            $(document).on('click', '#changeEmail-cancer', closeChangeMail);

            $(document).on('click', '#changeAddress-btn', showChangeAddress);
            $(document).on('click', '#changeAddress-cancer', closeChangeAddress);

            $(document).on('click', '#changeTel-btn', showChangeTel);
            $(document).on('click', '#changeTel-cancer', closeChangeTel);
 
        })
        
    </script>

@endsection