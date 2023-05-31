<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/token_page.css') }}">
    <title>ワンタイムパスワード入力</title>
</head>
<body class="token_pg">
    <div class="token_area">
    <p class="token_title_color">ワンタイムパスワード入力</p>
	<form action="{{ route('token.create') }}" method="post">
	    @csrf
	    <span class="token_guide">メールアドレスに送信された６桁の数字を入力してください。</span>
	    <input type="number" class="token_input" name="token" placeholder="ワンタイムパスワード入力" required>
	    <br class="clear_both">
	    <input type="hidden" id="name" name="name" value="{{ session('name') }}">
	    <input type="hidden" id="e_mail" name="e_mail" value="{{ session('e_mail') }}">
	    <input type="hidden" id="password" name="password" value="{{ session('password') }}">
	    <input type="hidden" id="user_kbn" name="user_kbn" value="{{ session('user_kbn') }}">
	    <input type="hidden" id="token_generate" name="token_generate" value="{{ session('token_generate') }}">
	    <input type="hidden" id="users_rec" name="users_rec" value="{{ session('users_rec') }}">
	    @if (session('errmsg'))
            	<div class="token_err">{{ session('errmsg') }}</div>
            @endif
            <button type="submit" class="token_input_btn">入力</button>
	</form>
    </div>
</body>
</html>


