<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Promociones;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;

class SuscripcionMultiverso extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $msg;
    public function __construct($message)
    {
        $this->msg = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cupones = Promociones::where('Correo',1)->first();
        $fecha = Carbon::now();
        $actual =$fecha->format('Y-m-d'); 
        $fechaInicio = strtotime($cupones->FechaI);
        $fechaFin = strtotime($cupones->FechaF);
        $fechaActual = strtotime($actual);

        if(($fechaActual >= $fechaInicio) && ($fechaActual <= $fechaFin)){
            $cupones->Limite = $cupones->Limite - 1;
            $cupones->save();
            return $this->view('emails.suscripcionBienvenida', compact('cupones'));
        }
            return $this->view('emails.suscripcionBienvenida');
    }
}
