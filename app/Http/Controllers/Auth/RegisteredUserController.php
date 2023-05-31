<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Mail\NewUserIntroduction;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\TokenSendMail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Mailer $mailer)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
	]);
        // ワンタイムパスワード発行、メール送信、ワンタイムパスワード入力ページへリダイレクト(追加)
	$name = $request->name;
        $password = Hash::make($request->password);
        $e_mail = $request->email;
        $ua = $request->header('User-Agent');
        $token_generate = str_pad(random_int(0,999999),6,0, STR_PAD_LEFT);
        $mailer->to($e_mail)
               ->send(new TokenSendMail($token_generate));
		$user_kbn = 'new_user';
        return redirect('token')->with(['name' => $name,'e_mail' => $e_mail,'password' => $password,'user_kbn' => $user_kbn,'token_generate' => $token_generate]);  // withでsession情報をセット
        return redirect(RouteServiceProvider::HOME);
    }
}
