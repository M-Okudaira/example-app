<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testSuccessfulLogin()
    {
	    $this->browse(function (Browser $browser) {
		$user = User::factory()->create(); // テスト用のユーザーを作成する
		$browser->visit('/login') // パスを変更する
	  	->type('email', $user->email)
		->type('password', 'password') // パスワードを入力する
		->press('LOG IN') // 「LOG IN」ボタンをクリックする 
		->assertPathIs('/tweet') // /tweetに遷移したことを確認する 
                ->assertSee('つぶやきアプリ');
        });
    }
}
