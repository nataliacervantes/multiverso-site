<?php

namespace App\Http\Controllers;
use App\Pedidos;
use App\Promociones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionDePago;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function subirFicha(Request $request){
        return view('checkout.subirFicha');
    }

    public function subirFichaPago(Request $request){
        $pedido = Pedidos::where('Folio',$request->folio)->first();

        if($request->hasFile('FichaPago')){
            $var = $request->file('FichaPago');
            $ext = $request->file('FichaPago')->getClientOriginalExtension();
            $name = 'FichaPago_'.$request->folio.'.'.$ext;
            $var->move('Clientes/',$name);
            $pedido->FichaPago = $name;
        }
        $pedido->save();

        Mail::to('nataliaglezcervantes@gmail.com')->send(new NotificacionDePago($pedido));

        return back();
    }
    
    public function cupon(){
        $cupon = $_GET['cupon'];
        // var_dump($_GET['cupon']);
        // return $cupon;
        // $cupon = 'Welcome2020';
        $cupones = Promociones::where('Cupon',$cupon)->first();
        $fecha = Carbon::now();
        $actual =$fecha->format('Y-m-d'); 
        $fechaInicio = strtotime($cupones->FechaI);
        $fechaFin = strtotime($cupones->FechaF);
        $fechaActual = strtotime($actual);
        // dd($cupones->Tipo);
        /*
            '1' => 'Porcentaje',
            '2' => 'Dinero',
            '3' => 'Sin Costo de Envío',
        */
        if($cupones->Tipo == '3'){
            // dd($actual);
             if(($fechaActual >= $fechaInicio) && ($fechaActual <= $fechaFin)){
                return '3';
             }else{
                 return 'nel';
             }
            
        }elseif ($cupones->Tipo == '2') {
            if(($fechaActual >= $fechaInicio) && ($fechaActual <= $fechaFin)){
                return $cupones->Dinero.'/2';
             }else{
                 return 'nel';
             }
           
        }elseif ($cupones->Tipo == '1') {
            if(($fechaActual >= $fechaInicio) && ($fechaActual <= $fechaFin)){
                return $cupones->Porcentaje.'/1';
             }else{
                 return 'nel';
             }
        }
        // return $cupon;
    }
}
