<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class createUser extends Mailable
{
    use Queueable, SerializesModels;
    /* Public Variables */
    public $nombres, $link;
    private $address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($address, $subject, $link, $nombres)
    {
        $this->address = $address;
        $this->subject = $subject;
        $this->nombres = $nombres;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.createUser')
            ->to($this->address)
            ->subject($this->subject);
    }
}
