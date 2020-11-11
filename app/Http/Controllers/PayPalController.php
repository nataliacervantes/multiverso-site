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
use PayPal\Api\ShippingAddress;
use App\Carrito;
use App\Pedidos;
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
                'AZqhIzlG5wszF6K-p7mpPKHi_TNsKD27ALvL-KXowrGCafQ6Pcorec0XBxN1oQ6Uy7YQXzjLoYcHW83I',     // ClientID
                'EAaPukpHpqFn9aKqG0vWpAsoFT6n_fXfDbp46b2i6QIOABinOcuIzs6qUfrdmmsA8zNerZEwYuR0WoDH'    // ClientSecret
            )
        );
        // dd($request->all());
    
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $payerInfo = new PayerInfo();
        $payerInfo->setEmail($request->Email);
        $payerInfo->setFirstName($request->Nombre);
        $payerInfo->setLastName($request->Apellido);
        $payerInfo->setPhone($request->Telefono);

        $addressShipping = new ShippingAddress();
        $addressShipping->setLine1($request->Domicilio);
        $addressShipping->setLine2($request->Colonia);
        $addressShipping->setCity($request->Ciudad);
        $addressShipping->setState($request->Estado);
        $addressShipping->setPostalCode($request->CP);
        $addressShipping->setCountryCode($request->Pais);

        $payerInfo->setShippingAddress($addressShipping);
        // dd($payerInfo);
        $amount = new Amount();
        $amount->setTotal($request->Total);
        $amount->setCurrency('MXN');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        // $transaction->setDescription($request->all());

        $callBackUrl = url("paypal/status");
        // $callBackExito = url('pagoExitoso');
        // $callBackCancel = url('fail');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callBackUrl)
        ->setCancelUrl($callBackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);

        // dd($transaction);
        // dd($payment);
        try {
            $payment->create($apiContext);
            // echo 'well done';
            // dd($this->apiContext);
                return redirect()->away($payment->getApprovalLink());
        }
        catch (PayPalConnectionException $ex) {
            $status = $ex->getData();
             echo 'nel, vete a dormir';
            // return redirect('error_page')->with(['status'=>$status]);
        }
    }

    public function paypalStatus(Request $request){
        session_start();
        $apiContext = new \PayPal\Rest\ApiContext(
            new OAuthTokenCredential(
                'AZqhIzlG5wszF6K-p7mpPKHi_TNsKD27ALvL-KXowrGCafQ6Pcorec0XBxN1oQ6Uy7YQXzjLoYcHW83I',     // ClientID
                'EAaPukpHpqFn9aKqG0vWpAsoFT6n_fXfDbp46b2i6QIOABinOcuIzs6qUfrdmmsA8zNerZEwYuR0WoDH'    // ClientSecret
            )
        );
        // dd($request->all());
        $paymentId = $request->input('paymentId');
        $payerId = $request->PayerID;
        $token = $request->token;

        if(!$paymentId || !$payerId || !$token){
            $status = 'Hubo un problema con la transacción, inténtalo más tarde por favor';
        }

        $payment = Payment::get($paymentId, $apiContext);
        // dd($paymentId);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $apiContext);
        // dd($result->state);
        if($result->getState() === 'approved'){
            $pedido = Pedidos::where('session',session_id())->where('EstatusPago','Pendiente')->first();
            // dd($pedido);
            $pedido->EstatusPago = 'Pagado';
            $pedido->Metodo ='PayPal';
            $pedido->save();
            $carritos = Carrito::where('session_estatus',session_id())->get();

            foreach($carritos as $carrito){
                $carrito->delete();
            }
            Mail::to('nataliaglezcervantes@gmail.com')->send(new ConfirmacionDePago);
            // dd($pedido);
            return back();
        }else{
            return $result->state;
            $status = 'Hubo un problema con la transacción, inténtalo más tarde por favor ';
            return redirect('error_page')->with(['status'=>$status]);
        }
    }

    public function deposito(Request $request){
        session_start();
        // dd($request->all());
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
        $carritos = Carrito::where('session_estatus',session_id())->get();

        foreach($carritos as $carrito){
            $carrito->delete();
        }
        
        return back();
    }

    // public function mercadoPagoPay(Request $request){
    //         // dd($request->all());
    //     SDK::setAccessToken("TEST-3058401090775798-070215-8a6d29999039e59d425eade729b3d680-594533699");

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

    //                 if($request->facturacion == null){
    //                     $usoCFDI = "P01";
    //                 }elseif($request->facturacion == 'si'){
    //                     $usoCFDI = $cfdi->CFDI;
    //                 }

    //                 if($request->idTipoPago == 'Pp' ){
    //                     $tipoPago = 7;
    //                     $estatus = 2;
    //                 }else{
    //                     $tipoPago = $request->idTipoPago;
    //                     $estatus = 1;
    //                 }

    //                 $user = User::find(Auth::user()->id);
    //                 $id = $user->idBonance;

    //                 $productos = Carrito::where('pedido_id',$request->idPedido)->get();

    //                 // dd($productos);
    //                 $data['form_params'] = [
    //                     'idUsuario' => $id,
    //                     'Folio' => $request->folio,
    //                     'Fecha' => Carbon::now()->format('Y-m-d'),
    //                     'TipoDePago' => $request->idTipoPago,
    //                     'TipoDeCambio' => $request->tipoCambio,
    //                     'CuentaDePago' => '',
    //                     'idDomicilio' => $request->idDomicilio,
    //                     'UsoCFDI' => $usoCFDI,
    //                     'Estatus' => $estatus,
    //                     'Partidas' => [],
    //                 ];

    //                 foreach($productos as $product){
    //                     // dd($product);
    //                     $row=[];
    //                     $row['idProducto'] = $product->Producto;
    //                     $row['Cantidad'] = $product->Cantidad;
    //                     $row['PrecioUnitario'] = $product->Precio;
    //                     $row['CodigoCliente'] = $product->id_usuario;
    //                     $data['form_params']['Partidas'][] = $row;
    //                 }
    //                     // dd($data);
    //                 $client = new Client([
    //                     'base_uri' => 'http://asserver.ddns.net/grupobonance/api/',
    //                     'timeout' => 30.0,
    //                 ]);

    //                 $response = $client->request('POST', 'pedido', $data);

    //                 $respuesta  = json_decode($response->getBody());

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

    // public function metodosPago(){
    //     SDK::setAccessToken("APP_USR-3058401090775798-070215-0b5afad6fe073548164a7daa5e0d870a-594533699");
    //     $payment_methods = SDK::get("/v1/payment_methods");
    //     // dd($payment_methods);
    //     return response($payment_methods['body']);
    // }

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
