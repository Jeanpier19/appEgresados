<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarRecomendaciones extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $address;
    public $imagen;
    public $recomendacion;
    public $empresa_nombre;
    public $curso_nombre;
    public $fecha_inicio;
    public $fecha_fin;
    public function __construct($address,$subject,$empresa_nombre,$curso_nombre,$fecha_inicio,$fecha_fin,$recomendacion,$imagen)
    {
        $this->address = $address;
        $this->subject = $subject;
        $this->empresa_nombre = $empresa_nombre;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->curso_nombre = $curso_nombre;
        $this->recomendacion = $recomendacion;
        $this->imagen = $imagen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.enviarRecomendacion')
            ->to($this->address)
            ->subject($this->subject);
    }
}
