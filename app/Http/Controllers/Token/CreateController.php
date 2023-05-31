<?php
namespace App\Http\Controllers\token;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
	    //dd($request);
	$token_generate = $request->token_generate;
	$name = $request->name;
	$e_mail = $request->e_mail;
	$password = $request->password;
	$token  = $request->token;
	$user_kbn  = $request->user_kbn;
	$ua = $request->server('HTTP_USER_AGENT');
	$remote_addr = $request->server('REMOTE_ADDR');
	if ($user_kbn == 'new_user') {
	   if ($token_generate == $token){
		$newUser = User::create([
            	'name' => $name,
            	'email' => $e_mail,
            	'password' => $password,
		'user_agent' => $ua,
		'remote_addr' => $remote_addr,
            	]);

           	event(new Registered($newUser));

           	Auth::login($newUser);
	   	return redirect()->route('tweet.index');
	   }else{
	   	return redirect()->route('token.index')->with(['errmsg' => 'ワンタイムパスワードが違います！','name' => $name,'e_mail' => $e_mail,'password' => $password,'user_kbn' => $user_kbn,'token_generate' => $token_generate]);
	   }  
	}else{
	    if ($token_generate == $token){
		// saveメソッドを使ってEloquentモデルのインスタンスを更新
            	$user = User::where('email',$e_mail)->firstOrFail();
            	$user->user_agent = $ua;
            	$user->remote_addr = $remote_addr;
            	$user->save();
            	return redirect()->route('tweet.index');
	   }else{
		return redirect()->route('token.index')->with(['errmsg' => 'ワンタイムパスワードが違います！','name' => $name,'e_mail' => $e_mail,'password' => $password,'user_kbn' => $user_kbn,'token_generate' => $token_generate]);
	   }
	}
	 
    }
}

