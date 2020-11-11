<?php

namespace App\Http\Controllers;
use App\Pedidos;
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

        return back();
    }
}
