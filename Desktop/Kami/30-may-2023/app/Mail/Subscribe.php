<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Subscribe extends Mailable
{
    use Queueable, SerializesModels;

 
    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }
    
    
    public function build()
    {
        return $this->subject('Thank you for subscribing to our Jeevansoft')
                     ->markdown('emails.subscribers');
    }
}
