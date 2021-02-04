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
use MercadoPago\MerchantOrder;
use MercadoPago\Shipments;
use MercadoPago\Preference;
use App\Carrito;
use App\Libros;
use App\Eventos;
use App\Pedidos;
use App\BookPedido;
use App\Promociones;
use App\EventPedido;
use App\Mail\ConfirmacionDePago;
use App\Mail\ConfirmacionDePedido;
use Response;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{

    public function mercadoPagoPay(Request $request){

        // $validator = Validator::make($request->all(),[
        //     'nombre' => 'required',
        //     'apellido' => 'required',
        //     'domicilio' => 'required',
        //     'colonia' => 'required',
        //     'ciudad' => 'required',
        //     'estado' => 'required',
        //     'pais' => 'required',
        //     'cp' => 'required',
        //     'telefono' => 'required',
        //     'total' => 'required',
        //     'envio' => 'required',
        //     'email' =>'required|email',
        //     'address' => 'required',
        // ]);
       
        // if($validator->fails()){
        //     $preference = array('errors'=> $validator->getMessageBag()->toarray(),'id'=>1);
        //     return $preference;
        // }
        // else{

            SDK::setAccessToken("TEST-991604415903884-103004-9d5d54072d80dfba880a0b906e9fe537-62670496");

            $preference = new Preference();
            session_start();
            $carrito = Carrito::where('session_estatus',session_id())->get();
            $pedido = new Pedidos();
            $pedidos = Pedidos::latest('Folio')->first();
            
            if($pedidos != null){
                $pedido->Folio = $pedidos->Folio + 1;
            }else{
                $pedido->Folio = 000000;
            }

            if($request->address ==1){
                $validator = Validator::make($request->all(),[
                    'nombre' => 'required',
                    'apellido' => 'required',
                    'domicilio' => 'required',
                    'colonia' => 'required',
                    'ciudad' => 'required',
                    'estado' => 'required',
                    'pais' => 'required',
                    'cp' => 'required',
                    'telefono' => 'required',
                    'total' => 'required',
                    'envio' => 'required',
                    'email' =>'required|email',
                    'address' => 'required',
                ]);
               
                if($validator->fails()){
                    $preference = array('errors'=> $validator->getMessageBag()->toarray(),'id'=>1);
                    return $preference;
                }else{
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
                    $pedido->InfoExtra = $request->infoExtra;
                    $pedido->Total = $request->total;
                    $pedido->Envio = $request->envio;
                    $pedido->Metodo ='MercadoPago';
                }

            }else{

                $validator = Validator::make($request->all(),[
                    'nombre' => 'required',
                    'apellido' => 'required',
                    'telefono' => 'required',
                    'total' => 'required',
                    'email' =>'required|email',
                ]);
               
                if($validator->fails()){
                    $preference = array('errors'=> $validator->getMessageBag()->toarray(),'id'=>1);
                    return $preference;
                }else{
                    $pedido->session = session_id();
                    $pedido->EstatusPago = 'Pendiente';
                    $pedido->EstatusEnvio = 'Pendiente';
                    $pedido->Nombre = $request->nombre;
                    $pedido->Apellido = $request->apellido;
                    $pedido->Domicilio = "NA";
                    $pedido->Colonia = "NA";
                    $pedido->Ciudad = "NA";
                    $pedido->Estado = "NA";
                    $pedido->Pais = "NA";
                    $pedido->CP = 00000;
                    $pedido->Email = $request->email;
                    $pedido->Telefono = $request->telefono;
                    $pedido->InfoExtra = "NA";
                    $pedido->Total = $request->total;
                    $pedido->Envio = 0;
                    $pedido->Metodo ='MercadoPago';
                }
            }

            $pedido->save();
           
            if($carrito->count() > 0){
                $datos = array();
                foreach ($carrito as $car) {
                    $item = new Item();
                    $book = Libros::find($car->books_id);
                    $event = Eventos::find($car->eventos_id);
                    
                    if($book){
                        $item->title = $book->Titulo;
                        $item->id = $book->id;
                        // $item->category_id = "Libro";
                        $item->description = $book->Descripcion;
                        // $item->currency_id = "MXN";
                        $item->quantity = $car->Cantidad;
                        $item->unit_price = $book->Precio;  
                        $datos[] = $item;
                    }else if ($event){
                        $item->title = $event->Evento;
                        $item->id = $event->id;
                        // $item->category_id = "Evento";
                        $item->description = $event->Lugar;
                        // $item->currency_id = "MXN";
                        $item->quantity = $car->Cantidad;
                        $item->unit_price = $event->Costo;  
                        $datos[] = $item;
                    }
                }
                    // dd($datos);
                $preference->items = $datos;
                
                $preference->payment_methods = array(
                    "excluded_payment_methods" => array(
                        array("id" => "nativa"),
                        array("id" => "naranja"),
                        array("id" => "diners"),
                        array("id" => "shopping"),
                        array("id" => "cencosud"),
                        array("id" => "cmr_master"),
                        array("id" => "cordial"),
                        array("id" => "cordobesa"),
                        array("id" => "cabal"),
                        array("id" => "maestro"),
                        array("id" => "debcabal"),
                    ),
                    "excluded_payment_types" => array(
                        array("id" => "ticket"),
                        array("id" => "atm")
                    ),
                    // "installments" => 12
                );
                $preference->back_urls = array(
                    "success" => "http://127.0.0.1:8000/confirmacionPagoMP",
                    "failure" => "https:/multiversolibreria/fail",
                    "pending" => "https://multiversolibreria/fail"
                );
                if($request->envio != null){
                    $envio = new Shipments();
                    $envio->cost = $request->envio;
                    $envio->mode =  "not_specified";
                    

                    // $preference->shipments=  (object) array(
                    //     "cost" => $request->envio,
                    //     "mode" => "not_specified"
                    //     // "pending" => "https://multiversolibreria/fail"
                    // );
                }
               
                $preference->auto_return = "approved";
                $preference->external_reference = $pedido->id;
                // dd($preference);
                $preference->save();
            }
            return $preference->id;
            session_destroy();
        
        //http://127.0.0.1:8000/mercadoPagoPay?
        // collection_id=13204681793&
        // collection_status=approved&
        // payment_id=13204681793&
        // status=approved&
        // external_reference=null&
        // payment_type=account_money&
        // merchant_order_id=2253226117&
        // preference_id=62670496-98b73cee-6621-46d5-9c7a-3a3362c0f819&
        // site_id=MLM&
        // processing_mode=aggregator&
        // merchant_account_id=null        
    }

    public function confirmacionPagoMP(){
        if($_GET['status']== 'approved'){
            $id = $_GET['external_reference'];

            $pedido = Pedidos::find($id);
            $pedido->EstatusPago = 'Pagado';
            // $pedido->Metodo ='PayPal';
            $pedido->save();
         
            $carritos = Carrito::where('session_estatus',session_id())->get();
            
            foreach($carritos as $carrito){
                
                if($carrito->books_id != null){
                    
                    $pivot = new BookPedido();
                    $pivot->books_id = $carrito->books_id;
                    $pivot->pedidos_id = $pedido->id;
                    $pivot->Cantidad =$carrito->Cantidad;
                    $pivot->save();
                    // Mail::to($pedido->Email)->send(new ConfirmacionDePago($pedido));
                    $carrito->delete();
                }elseif($carrito->eventos_id != null){
                    $pivot = new EventPedido();
                    $pivot->events_id = $carrito->eventos_id;
                    $pivot->pedidos_id = $pedido->id;
                    $pivot->Cantidad =$carrito->Cantidad;
                    $pivot->save();
                    // Mail::to($pedido->Email)->send(new EnviarBoleto($pedido));
                    $carrito->delete();
                }
            }

        }
    }
}
