<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Config;
use PayPal\Api\PaymentExecution;
 use PayPal\Exception\PayPalConnectionException;
use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use App\Promociones;
use PayPal\Api\ShippingAddress;
use App\Carrito;
use App\Pedidos;
use App\BookPedido;
use App\Mail\ConfirmacionDePago;
use App\Mail\ConfirmacionDePedido;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use Illuminate\Support\Facades\Mail;

class PayPalController extends Controller
{
    public function payWithPaypal(Request $request){
        session_start();
        $pedido = new Pedidos();
        $pedidos = Pedidos::latest('Folio')->first();

        if($pedidos != null){
            $pedido->Folio = $pedidos->Folio + 1;
        }else{
            $pedido->Folio = 000000;
        }
        
        $pedido->session = session_id();
        $pedido->EstatusPago = 'Pendiente';
        $pedido->EstatusEnvio = 'Pendiente';
        $pedido->Nombre = $request->Nombre;
        $pedido->Apellido = $request->Apellido;
        $pedido->Domicilio = $request->Domicilio;
        $pedido->Colonia = $request->Colonia;
        $pedido->Ciudad = $request->Ciudad;
        $pedido->Estado = $request->Estado;
        $pedido->Pais = $request->Pais;
        $pedido->CP = $request->CP;
        $pedido->Email = $request->Email;
        $pedido->Telefono = $request->Telefono;
        $pedido->InfoExtra = $request->InfoExtra;
        $pedido->Total = $request->Total;
        $pedido->Envio = $request->Envio;

        // dd($pedido);
        $pedido->save();

        $apiContext = new \PayPal\Rest\ApiContext(
            new OAuthTokenCredential(
                'AbBav_7FEP9RIE_aTYraX-McSAtmQOZUK-QRfNCO7BuxOm6zkaIEaR-nO_NFYnhQLEI4IJTvukChkZfV',     // ClientID
                'EK0exQkW6RGs4YLm_c38mgyYLmoD5dgqxrzPYN0TT6cJZIa7Rjt-5LkCAymGRF6ygwTCKy-aIFKng5ei'    // ClientSecret
                // Sandbox
                // 'AZqhIzlG5wszF6K-p7mpPKHi_TNsKD27ALvL-KXowrGCafQ6Pcorec0XBxN1oQ6Uy7YQXzjLoYcHW83I',
                // 'EAaPukpHpqFn9aKqG0vWpAsoFT6n_fXfDbp46b2i6QIOABinOcuIzs6qUfrdmmsA8zNerZEwYuR0WoDH'

            )
        );
        $apiContext->setConfig([
            'mode' => 'live',
           ]);
        // dd($request->all());
        // dd($apiContext);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->Total);
        $amount->setCurrency('MXN');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $callBackUrl = url("paypal/status");

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callBackUrl)
        ->setCancelUrl($callBackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
                return redirect()->away($payment->getApprovalLink());
        }catch (PayPalConnectionException $ex) {
            $status = $ex->getData();
            echo $status;
        }
    }

    public function paypalStatus(Request $request){
        session_start();
        $apiContext = new \PayPal\Rest\ApiContext(
            new OAuthTokenCredential(
                'AbBav_7FEP9RIE_aTYraX-McSAtmQOZUK-QRfNCO7BuxOm6zkaIEaR-nO_NFYnhQLEI4IJTvukChkZfV',     // ClientID
                'EK0exQkW6RGs4YLm_c38mgyYLmoD5dgqxrzPYN0TT6cJZIa7Rjt-5LkCAymGRF6ygwTCKy-aIFKng5ei'    // ClientSecret
            )
        );
        $apiContext->setConfig([
            'mode' => 'live',
           ]);
        $paymentId = $request->input('paymentId');
        $payerId = $request->PayerID;
        $token = $request->token;

        if(!$paymentId || !$payerId || !$token){
            $status = 'Hubo un problema con la transacción, inténtalo más tarde por favor';
        }

        $payment = Payment::get($paymentId, $apiContext);
        
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $apiContext);
        
        if($result->getState() === 'approved'){
            $pedido = Pedidos::where('session',session_id())->where('EstatusPago','Pendiente')->first();
            $pedido->EstatusPago = 'Pagado';
            $pedido->Metodo ='PayPal';
            $pedido->save();
            $promociones = Promociones::where('Cupon',$request->cupon)->first();
            if($promociones != null){
                $promociones->Limite = $promociones->Limite - 1 ;
            }
            
            $carritos = Carrito::where('session_estatus',session_id())->get();
            

            foreach($carritos as $carrito){
                
                if($carrito->books_id != null){
                    
                    $pivot = new BookPedido();
                    $pivot->books_id = $carrito->books_id;
                    $pivot->pedidos_id = $pedido->id;
                    $pivot->Cantidad =$carrito->Cantidad;
                    $pivot->save();
                    $carrito->delete();
                }elseif($carrito->eventos_id != null){
                    $carrito->delete();
                }
            }

            Mail::to('nataliaglezcervantes@gmail.com')->send(new ConfirmacionDePago($pedido));
          
            session_destroy();
            return view('checkout.confirmacioPago');
        }else{
            return $result->state;
            $status = 'Hubo un problema con la transacción, inténtalo más tarde por favor ';
            return redirect('error_page')->with(['status'=>$status]);
        }
    }

    public function deposito(Request $request){
        session_start();
        $validatedData = $request->validate([
            'Nombre' => 'required',
            'Apellido' => 'required',
            'Domicilio' => 'required',
            'Colonia' => 'required',
            'Ciudad' => 'required',
            'Estado' => 'required',
            'Pais' => 'required',
            'Cp' => 'required',
            'Telefono' => 'required',
            'InfoExtra' => 'required',
            'Total' => 'required',
            'Metodo' => 'required',
            'Envio' => 'required',
            'Email' =>'required|email',
        ]);
        
        $pedido = new Pedidos();
        $pedidos = Pedidos::latest('Folio')->first();
        if($pedidos != null){
            $pedido->Folio = $pedidos->Folio + 1;
        }else{
            $pedido->Folio = 000000;
        }
        $pedido->session = session_id();
        $pedido->EstatusPago = 'Pendiente';
        $pedido->EstatusEnvio = 'Pendiente';
        $pedido->Nombre = $request->nombre;
        $pedido->Apellido = $request->apellido;
        $pedido->Domicilio = $request->domicilio;
        $pedido->Colonia = $request->colonia;
        $pedido->Ciudad = $request->ciudad;
        $pedido->Estado = $request->estado;
        $pedido->Pais = $request->pais;
        $pedido->CP = $request->cp;
        $pedido->Email = $request->email;
        $pedido->Telefono = $request->telefono;
        $pedido->InfoExtra = $request->infoextra;
        $pedido->Total = $request->total;
        $pedido->Envio = $request->envio;
        $pedido->Metodo = 'Depósito';
        // dd($pedido);
        $pedido->save();
        $promociones = Promociones::where('Cupon',$request->cupon)->first();
        $promociones->Limite = $promociones->Limite - 1 ;
        Mail::to('nataliaglezcervantes@gmail.com')->send(new ConfirmacionDePedido($pedido));
        $carritos = Carrito::where('session_estatus',session_id())->get();

        foreach($carritos as $carrito){
            if($carrito->books_id != null){
                // dD($carrito);
                $pivot = new BookPedido();
                $pivot->books_id = $carrito->books_id;
                $pivot->pedidos_id = $pedido->id;
                $pivot->Cantidad =$carrito->Cantidad;
                $pivot->save();
                // dd($pivot);
                $carrito->delete();
            }elseif($carrito->eventos_id != null){
                $carrito->delete();
            }
        }
        session_destroy();
        return view('checkout.confirmacionPedido');
    }

    public function exito(){
        return view('checkout.confirmacioPago');
    }

    public function exitoPedido(){
        return view('checkout.confirmacionPedido');
    }
    // public function mercadoPagoPay(Request $request){
    //         // dd($request->all());
    //     SDK::setAccessToken("TEST-3058401090775798-070215-8a6d29999039e59d425eade729b3d680-594533699");
            // MercadoPago\SDK::setAccessToken('PROD_ACCESS_TOKEN');
            // $preference = new MercadoPago\Preference();

            // // Crea un ítem en la preferencia
            // $item = new MercadoPago\Item();
            // $item->title = 'Mi producto';
            // $item->quantity = 1;
            // $item->unit_price = 75.56;
            // $preference->items = array($item);
            // $preference->save();
            
    //         $payment = new Payment();
    //         $payment->transaction_amount = (float)$request->transactionAmount;
    //         $payment->token = $request->token;
    //         $payment->description = $request->description;
    //         $payment->installments = (int)$request->installments;
    //         $payment->issuer_id = (int)$request->issuer;
    //         $payment->payment_method_id = $request->paymentMethodId;

    //         $payer = new Payer();
    //         $payer->email = $request->email;
    //         $payment->payer = $payer;
    //         $payment->save();
    //         // dd($payment);
    //         $response = array(
    //             'status' => $payment->status,
    //             'status_detail' => $payment->status_detail,
    //             'id' => $payment->id
    //         );
    //         // dd($response['status']);

    //         if($response['status'] == "approved"){
    //             // dd('alv');
    //             $validator = Validator::make($request->all(),['idDomicilio' => 'required',
    //             'idTipoPago' => 'required']);
    //             // dd($validator);
    //             if($validator->fails()){
    //                 return Redirect::back()->with('status', 'Es necesario que ingreses un domicilio!');
    //             }else{
    //                     // return $request->idDomicilio;
    //                 $cfdi = DatosFiscales::find($request->idFacturacion);
    //                 $pedido = Pedidos::find($request->idPedido);

    //               

    //                 // dd($respuesta);
    //                         // return response(json_encode($respuesta->status),200);

    //                 if($respuesta->status == 'ok'){
    //                     // dd($respuesta->status);
    //                     $pedido->id_pedidoBonance = $respuesta->id;
    //                     $pedido->Total = $request->total;
    //                     $pedido->save();

    //                     foreach($productos as $prod){
    //                         $prod->delete();
    //                     }

    //                     if($request->idTipoPago == 'Pp' ){
    //                         return response(json_encode($respuesta->status),200);
    //                     }else{
    //                         return view('flujo-compra.orderCompleta');
    //                     }
    //                 }elseif($respuesta->status == 'error'){
    //                     dd($respuesta->status);
    //                 }
    //             }
    //         }
    // }

    public function metodosPago(){
        SDK::setAccessToken("APP_USR-3058401090775798-070215-0b5afad6fe073548164a7daa5e0d870a-594533699");
        $payment_methods = SDK::get("/v1/payment_methods");
        // dd($payment_methods);
        return response($payment_methods['body']);
    }

    // public function pagoEfectivo(Request $request){
    //     // dd($request->all());
    //     SDK::setAccessToken("APP_USR-3058401090775798-070215-0b5afad6fe073548164a7daa5e0d870a-594533699");

    //     $payment = new Payment();
    //     $payment->transaction_amount = (float)$request->transactionAmount;
    //     $payment->description = "Multiverso";
    //     // $payment->token = $request->token;
    //     $payment->payment_method_id = $request->paymentMethodId;

    //     $payer = new Payer();
    //     $payer->email = $request->email;
    //     $payment->payer = $payer;
    //     $payment->save();

    //     // dd($payment);
    //     $response = array(
    //         'status' => $payment->status,
    //         'status_detail' => $payment->status_detail,
    //         'id' => $payment->id
    //     );

    //     if($response['status'] == "pending"){
    //             // dd('alv');
    //         $validator = Validator::make($request->all(),['idDomicilioE' => 'required',
    //             'idTipoPagoE' => 'required']);
    //         // dd($validator);
    //         if($validator->fails()){
    //             return Redirect::back()->with('status', 'Es necesario que ingreses un domicilio!');
    //         }else{
    //                 // return $request->idDomicilio;
    //             $cfdi = DatosFiscales::find($request->idFacturacion);
    //             $pedido = Pedidos::find($request->idPedido);

    //             if($request->facturacion == null){
    //                 $usoCFDI = "P01";
    //             }elseif($request->facturacion == 'si'){
    //                 $usoCFDI = $cfdi->CFDI;
    //             }

    //             if($request->idTipoPagoE == 'Pp' ){
    //                 $tipoPago = 7;
    //                 $estatus = 2;
    //             }else{
    //                 $tipoPago = $request->idTipoPagoE;
    //                 $estatus = 1;
    //             }

    //             $user = User::find(Auth::user()->id);
    //             $id = $user->idBonance;

    //             $productos = Carrito::where('pedido_id',$request->idPedido)->get();

    //             // dd($productos);
    //             $data['form_params'] = [
    //                 'idUsuario' => $id,
    //                 'Folio' => $request->folio,
    //                 'Fecha' => Carbon::now()->format('Y-m-d'),
    //                 'TipoDePago' => $request->idTipoPagoE,
    //                 'TipoDeCambio' => $request->tipoCambio,
    //                 'CuentaDePago' => '',
    //                 'idDomicilio' => $request->idDomicilioE,
    //                 'UsoCFDI' => $usoCFDI,
    //                 'Estatus' => $estatus,
    //                 'Partidas' => [],
    //             ];

    //             foreach($productos as $product){
    //                 // dd($product);
    //                 $row=[];
    //                 $row['idProducto'] = $product->Producto;
    //                 $row['Cantidad'] = $product->Cantidad;
    //                 $row['PrecioUnitario'] = $product->Precio;
    //                 $row['CodigoCliente'] = $product->id_usuario;
    //                 $data['form_params']['Partidas'][] = $row;
    //             }
    //                 // dd($data);
    //             $client = new Client([
    //                 'base_uri' => 'http://asserver.ddns.net/grupobonance/api/',
    //                 'timeout' => 30.0,
    //             ]);

    //             $response = $client->request('POST', 'pedido', $data);

    //             $respuesta  = json_decode($response->getBody());

    //             // dd($respuesta);
    //                     // return response(json_encode($respuesta->status),200);

    //             if($respuesta->status == 'ok'){
    //                 // dd($respuesta->status);
    //                 $pedido->id_pedidoBonance = $respuesta->id;
    //                 $pedido->Total = $request->total;
    //                 $pedido->save();

    //                 foreach($productos as $prod){
    //                     $prod->delete();
    //                 }

    //                 if($request->idTipoPago == 'Pp' ){
    //                     return response(json_encode($respuesta->status),200);
    //                 }else{

    //                     return view('flujo-compra.orderCompleta');
    //                 }
    //             }elseif($respuesta->status == 'error'){
    //                 dd($respuesta->status);
    //             }
    //         }
    //     }
    // }
}
