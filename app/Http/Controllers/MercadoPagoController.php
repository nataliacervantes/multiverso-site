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
use App\Mail\EnviarBoleto;
use Illuminate\Support\Facades\Mail;
use Response;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{

    public function mercadoPagoPay(Request $request){

            SDK::setAccessToken("APP_USR-991604415903884-103004-415ee28ce26d977237de7495940c923e-62670496");

            //se crea un pedido nuevo y se obtiene el último folio dado de alta en la db
            $pedido = new Pedidos();
            $pedidos = Pedidos::latest('Folio')->first();
            
            //si el folio no existe es porque no se ha dado de alta ningún pedido anteriormente  de lo contrario
            //se incrementa el folio y se guarda en el registro nuevo
            if($pedidos != null){
                $pedido->Folio = $pedidos->Folio + 1;
            }else{
                $pedido->Folio = 000000;
            }

            //address es para saber qué campos deben ser obligatorios si es 1 el domicilio debe estar completo
            if($request->address ==1){
                //se validan los campos obligatorios
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
                    //si la validación detecta errores retorna a la vista y envía el arreglo con la información
                if($validator->fails()){
                    $preference = array('errors'=> $validator->getMessageBag()->toarray(),'id'=>1);
                    return $preference;
                }else{
                    //si la validación pasa se completa el pedido con la información del request
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
            //si el request no necesita el domicilio  entra a la siguiente validación
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

                     //se guarda el pedido
                    $pedido->save();
                }
            }
            //se guarda el pedido
            $pedido->save();
           
            session_start();
            //se inicia el proceso para crear la preferencia en mercado pago
            $preference = new Preference();
            //Se buscan los productos en  el carrito
            $carrito = Carrito::where('session_estatus',session_id())->get();

            //si el carrito no está vacío crea una preferencia
            if($carrito->count() > 0){
                $datos = array();
                if($request->envio != null){
                    $item = new Item();
                    $item->title = 'Envio';
                    $item->id = 1;
                        // $item->category_id = "Evento";
                    $item->description = 'Costo de envío';
                        // $item->currency_id = "MXN";
                    $item->quantity = 1;
                    $item->unit_price = $request->envio;  
                    $datos[] = $item;
                }
                foreach ($carrito as $car) {
                    //se crea un nuevo item por cada producto en el carrito 
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
            $pedido->save();

            session_start();
            $carritos = Carrito::where('session_estatus',session_id())->get();
            // dd($carritos);
            foreach($carritos as $carrito){
                if($carrito->books_id != null){
                    
                    $pivot = new BookPedido();
                    $pivot->books_id = $carrito->books_id;
                    $pivot->pedidos_id = $pedido->id;
                    $pivot->Cantidad =$carrito->Cantidad;
                    $pivot->save();
                    Mail::to($pedido->Email)->send(new ConfirmacionDePago($pedido));
                    $carrito->delete();
                }elseif($carrito->eventos_id != null){
                    $pivot = new EventPedido();
                    $pivot->events_id = $carrito->eventos_id;
                    $pivot->pedidos_id = $pedido->id;
                    $pivot->Cantidad =$carrito->Cantidad;
                    $pivot->save();
                    Mail::to($pedido->Email)->send(new EnviarBoleto($pedido));
                    $carrito->delete();
                }
            }
            session_destroy();
            return view('checkout.confirmacioPago');
        }else{
            return $result->state;
            $status = 'Hubo un problema con la transacción, inténtalo más tarde por favor ';
            return redirect('error_page')->with(['status'=>$status]);
        }
    }
}
