<?php

namespace App\Http\Controllers;
use MercadoPago\SDK;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use MercadoPago\Payment;
use MercadoPago\Payer;
use MercadoPago\Item;
use MercadoPago\Preference;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{

    public function mercadoPagoPay(){
        // dd($request->all());
        
        $preference = new Preference();

        // Crea un ítem en la preferencia
        $item = new Item();
        $item->title = 'Mi producto';
        $item->quantity = 1;
        $item->unit_price = 75.56;
        $preference->items = array($item);
        $preference->save();

        return $preference->id;
        
            // $payment = new Payment();
            // $payment->transaction_amount = (float)$request->transactionAmount;
            // $payment->token = $request->token;
            // $payment->description = $request->description;
            // $payment->installments = (int)$request->installments;
            // $payment->issuer_id = (int)$request->issuer;
            // $payment->payment_method_id = $request->paymentMethodId;

            // $payer = new Payer();
            // $payer->email = $request->email;
            // $payment->payer = $payer;
            // $payment->save();
            // // dd($payment);
            // $response = array(
            //     'status' => $payment->status,
            //     'status_detail' => $payment->status_detail,
            //     'id' => $payment->id
            // );
            // dd($response['status']);

            // if($response['status'] == "approved"){
            //     // dd('alv');
            //     $validator = Validator::make($request->all(),['idDomicilio' => 'required',
            //     'idTipoPago' => 'required']);
            //     // dd($validator);
            //     if($validator->fails()){
            //         return Redirect::back()->with('status', 'Es necesario que ingreses un domicilio!');
            //     }else{
            //             // return $request->idDomicilio;
            //         $cfdi = DatosFiscales::find($request->idFacturacion);
            //         $pedido = Pedidos::find($request->idPedido);

            //         if($request->facturacion == null){
            //             $usoCFDI = "P01";
            //         }elseif($request->facturacion == 'si'){
            //             $usoCFDI = $cfdi->CFDI;
            //         }

            //             $tipoPago = 7;
            //             $estatus = 2;

            //         $user = User::find(Auth::user()->id);
            //         $id = $user->idBonance;

            //         $productos = Carrito::where('pedido_id',$request->idPedido)->get();

            //         // dd($productos);
            //         $data['form_params'] = [
            //             'idUsuario' => $id,
            //             'Folio' => $request->folio,
            //             'Fecha' => Carbon::now()->format('Y-m-d'),
            //             'TipoDePago' => $request->idTipoPago,
            //             'TipoDeCambio' => $request->tipoCambio,
            //             'CuentaDePago' => '',
            //             'idDomicilio' => $request->idDomicilio,
            //             'UsoCFDI' => $usoCFDI,
            //             'Estatus' => $estatus,
            //             'Partidas' => [],
            //         ];

            //         foreach($productos as $product){
            //             // dd($product);
            //             $row=[];
            //             $row['idProducto'] = $product->Producto;
            //             $row['Cantidad'] = $product->Cantidad;
            //             $row['PrecioUnitario'] = $product->Precio;
            //             $row['CodigoCliente'] = $product->id_usuario;
            //             $data['form_params']['Partidas'][] = $row;
            //         }
            //             // dd($data);
            //         $client = new Client([
            //             'base_uri' => 'http://asserver.ddns.net/grupobonance/api/',
            //             'timeout' => 30.0,
            //         ]);

            //         $response = $client->request('POST', 'pedido', $data);

            //         $respuesta  = json_decode($response->getBody());

            //         dd($request->all());
            //         // return response(json_encode($respuesta->status),200);

            //         if($respuesta->status == 'ok'){
            //             // dd($respuesta->status);
            //             $pedido->id_pedidoBonance = $respuesta->id;
            //             $pedido->Total = $request->total;
            //             $pedido->save();

            //             foreach($productos as $prod){
            //                 $prod->delete();
            //             }

            //             return view('flujo-compra.orderCompleta', compact('pedido'));

            //         }elseif($respuesta->status == 'error'){
            //             return view('pages.404');
            //         }
            //     }
            // }
    }

    public function metodosPago(){
        SDK::setAccessToken("APP_USR-7429297907881490-092316-83a76f1b7f28ebed00557daa74226f5d-649986936");
        $payment_methods = SDK::get("/v1/payment_methods");
        // dd($payment_methods);
        return response($payment_methods['body']);
    }

}
