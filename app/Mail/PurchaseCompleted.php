<?php

namespace App\Mail;

use App\Models\Item;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $item;
    public $user;

    public function __construct(Item $item, User $user)
    {
        // データをメールで使えるようにセット
        $this->item = $item;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('ご購入ありがとうございます')
            ->view('emails.purchase_completed');
    }
}