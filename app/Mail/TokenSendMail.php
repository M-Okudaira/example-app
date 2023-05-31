<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TokenSendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build()
    {
        return $this->from('laravel@example.com') // 送信元
        ->subject('ワンタイムパスワード発行') // メールタイトル
        ->view('email.token_send_mail') // どのテンプレートを呼び出すか
        ->with(['token' => $this->content]); // withオプションでセットしたデータをテンプレートへ受け渡す
    }
}

