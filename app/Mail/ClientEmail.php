<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $good;


    public function __construct($client,$good)
    {
        $this->client = $client;
        $this->good = $good;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $client = $this->client;

        $subject=' إنتهت صلاحية المنتج'.$this->good->title_ar;

        return $this->view('mails.client', compact('client','good'))->subject($subject);
    }
}
