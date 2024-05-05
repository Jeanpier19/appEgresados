<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConveniosPorFinalizar extends Mailable
{
    use Queueable, SerializesModels;
    /* Public Variables */
    public $convenio, $entidad;
    private $address;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($address, $subject, $convenio, $entidad)
    {
        $this->address = $address;
        $this->subject = $subject;
        $this->convenio = $convenio;
        $this->entidad = $entidad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.conveniosPorFinalizar')
            ->to($this->address)
            ->subject($this->subject);
    }
}
