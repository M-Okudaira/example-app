<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\TokenSendMail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request, Mailer $mailer): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
	$e_mail = $request->email;
	$ua = $request->server('HTTP_USER_AGENT');
	$remote_addr = $request->server('REMOTE_ADDR');
	if (User::where('email',$e_mail)
		->where('user_agent',$ua)
		->where('remote_addr',$remote_addr)->exists()) {
       		return redirect()->intended(RouteServiceProvider::HOME);
	}else{
		$token = str_pad(random_int(0,999999),6,0, STR_PAD_LEFT);
		session(['token_generate' => $token, 'e_mail' => $e_mail]);
	  	$mailer->to($e_mail)
			->send(new TokenSendMail($token));
	  	return redirect('token');
	}
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/tweet');
    }
}
