<?php

namespace App\Http\Controllers;
use App\Pedidos;
use App\Promociones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionDePago;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    public function subirFicha(Request $request){
        return view('checkout.subirFicha');
    }

    public function subirFichaPago(Request $request){
        $pedido = Pedidos::where('Folio',$request->folio)->first();

        if($pedido != null){
            if($request->hasFile('FichaPago')){
                $var = $request->file('FichaPago');
                $ext = $request->file('FichaPago')->getClientOriginalExtension();
                $name = 'FichaPago_'.$request->folio.'.'.$ext;
                $var->move('Clientes/',$name);
                $pedido->FichaPago = $name;
            }
            $pedido->save();

            Mail::to('delaserna@multiversolibreria.com')->send(new NotificacionDePago($pedido));

            if($pedido){
                return Redirect::back()->with('status', 'La ficha de pago se subió con éxito!');
            }else{
                return Redirect::back()->with('status', 'Hubo un problema, inténtalo más tarde!');
            }   
        }else{
            return Redirect::back()->with('status', 'El Folio que ingresaste es incorrecto!');
        }
            
    }
    
    public function cupon(Request $request){
        $cupon = $_GET['cupon'];
        // $cupon = $request->cupon;
        // dd($cupon);
        // var_dump($_GET['cupon']);
        // return $cupon;
        // $cupon = 'Welcome2020';
        $cupones = Promociones::where('Cupon',$cupon)->first();
        // dd($cupones);
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
                $cupones->Limite = $cupones->Limite-1;
                $cupones->save();
                return '3';
             }else{
                 return 'nel';
             }
            
        }elseif ($cupones->Tipo == '2') {
            if(($fechaActual >= $fechaInicio) && ($fechaActual <= $fechaFin)){
                $cupones->Limite = $cupones->Limite-1;
                $cupones->save();
                return $cupones->Dinero.'/2';
             }else{
                 return 'nel';
             }
           
        }elseif ($cupones->Tipo == '1') {
            if(($fechaActual >= $fechaInicio) && ($fechaActual <= $fechaFin)){
                $cupones->Limite = $cupones->Limite-1;
                $cupones->save();
                return $cupones->Porcentaje.'/1';
             }else{
                 return 'nel';
             }
        }
        // return $cupon;
    }
}
