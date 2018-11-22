<?php

namespace Roan\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contacto extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;

    public function __construct($msg){
        $this->mensaje = $msg;
    }

    public function build()
    {
        return $this->view('contacto')->with(['mensaje' => $this->mensaje]);
    }
}
