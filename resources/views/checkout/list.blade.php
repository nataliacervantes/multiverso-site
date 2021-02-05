@extends('files.template')
@php
    use MercadoPago\SDK;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
    use MercadoPago\Payment;
    use MercadoPago\Payer;
    use MercadoPago\Item;
    use MercadoPago\Preference;
    use App\Carrito;
    use App\Libros;
    use App\Eventos;
    use Illuminate\Http\Request;

    // SDK::setAccessToken("APP_USR-991604415903884-103004-415ee28ce26d977237de7495940c923e-62670496");

    // $preference = new Preference();
    // session_start();
    // $carrito = Carrito::where('session_estatus',session_id())->get();
    // session_destroy();
    // if($carrito->count() > 0){

    //     $datos = array();
    //     foreach ($carrito as $car) {
    //         $item = new Item();

    //         $book = Libros::find($car->books_id);
    //         $event = Eventos::find($car->eventos_id);
    //         // dd($event);
    //         if($book){
    //             $item->title = $book->Titulo;
    //             $item->id = $book->id;
    //             // $item->category_id = "Libro";
    //             $item->description = $book->Descripcion;
    //             // $item->currency_id = "MXN";
    //             $item->quantity = $car->Cantidad;;
    //             $item->unit_price = $book->Precio;
    //             $datos[] = $item;
    //         }else if ($event){
    //             $item->title = $event->Evento;
    //             $item->id = $event->id;
    //             // $item->category_id = "Evento";
    //             $item->description = $event->Lugar;
    //             // $item->currency_id = "MXN";
    //             $item->quantity = $car->Cantidad;;
    //             $item->unit_price = $event->Costo;
    //             $datos[] = $item;
    //         }
    //     }
    //         // dd($datos);
    //         $preference->items = $datos;

    //         $preference->payment_methods = array(
    //             "excluded_payment_methods" => array(
    //                 array("id" => "nativa"),
    //                 array("id" => "naranja"),
    //                 array("id" => "diners"),
    //                 array("id" => "shopping"),
    //                 array("id" => "cencosud"),
    //                 array("id" => "cmr_master"),
    //                 array("id" => "cordial"),
    //                 array("id" => "cordobesa"),
    //                 array("id" => "cabal"),
    //                 array("id" => "maestro"),
    //                 array("id" => "debcabal"),
    //             ),
    //             "excluded_payment_types" => array(
    //                 array("id" => "ticket"),
    //                 array("id" => "atm")
    //             ),
    //             // "installments" => 12
    //         );
    //         $preference->back_urls = array(
    //             "success" => "http://127.0.0.1:8000/mercadoPagoPay",
    //             "failure" => "https:/multiversolibreria/fail",
    //             "pending" => "https://multiversolibreria/fail"
    //         );
    //         // $preference->auto_return = "approved";

    //         $preference->save();
    //         // dd($preference->id);
    // }
    // curl -X POST -H "Content-Type: application/json" 'Authorization: APP_USR-991604415903884-103004-415ee28ce26d977237de7495940c923e-62670496' "https://api.mercadopago.com/users/test_user" -d '{"site_id":"MLM"}'
    // curl -X POST -H "Content-Type: application/json"  'Authorization: Bearer TEST-991604415903884-103004-9d5d54072d80dfba880a0b906e9fe537-62670496' "https://api.mercadopago.com/users/test_user" -d '{"site_id":"MLM"}'
    // curl -X GET  'https://api.mercadopago.com/v1/payment_methods'  -H 'Authorization: Bearer TEST-991604415903884-103004-9d5d54072d80dfba880a0b906e9fe537-62670496'
    // curl -X POST -H "Content-Type: application/json" "https://api.mercadopago.com/users/test_user?acces_token=TEST-991604415903884-103004-9d5d54072d80dfba880a0b906e9fe537-62670496" -d '{"site_id":"MLM"}'
@endphp
@section('content')
<!-- START SECTION SHOP -->

<div class="section">
	<div class="container">
        {{-- REsumen de compra --}}
        <div class="row">
            <div class="col-12">
                <div class="table-responsive shop_cart_table">
                	<table class="table">
                    	<thead>
                        	<tr>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Producto</th>
                                <th> Precio Unitario</th>
                                <th>Cantidad</th>
                                <th class="product-price">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carrito as $cart)
                                <tr>
                                    @if($cart->books_id != null )
                                    <input type="hidden" value="{{$cart->books_id}}" id="idLibro">
                                        <td class="product-thumbnail"><a href="#"><img src="{!! url('https://admin.multiversolibreria.com/img/Portadas/'.$cart->books->Portada) !!}" ></a></td>
                                        <td class="product-name" data-title="Producto">{{$cart->books->Titulo}}</td>
                                        <td class="product-price" data-title="Precio U.">$ {{$cart->books->Precio}}</td>
                                        <td class="product-quantity" data-title="Cantidad"><div class="quantity">
                                            <input type="button" value="-" class="minus" onclick="restaLibro({{$cart->books->id}})">
                                            <input type="text" id='cantidadLibro-{{$cart->books->id}}' name="quantity" value="{{$cart->Cantidad}}" readonly title="Qty" class="qty" size="4">
                                            <input type="button" value="+" class="plus" onclick="sumaLibro({{$cart->books->id}});">
                                            </div></td>
                                            <input type="hidden" id="precio-{{$cart->books->id}}" value="{{$cart->books->Precio}}">
                                        <td class="product-price"  data-title="Precio"><input type="text" value="$ {{$cart->Subtotal}}" id="precioLibro-{{$cart->books->id}}" readonly style="border: 0; text-align: center; font-weight: 600"></td>
                                    @elseif($cart->eventos_id != null )
                                        <input type="hidden" value="{{$cart->books_id}}" id="idEvento">
                                        <td class="product-thumbnail">
                                            <a href="{!! url('detalle/'.$cart->eventos->id) !!}"><img src="{!! asset('assets/images/calendario.png') !!}" alt="cart_thumb1"></a>
                                        </td>
                                        <td class="product-name" data-title="Producto">{{$cart->eventos->Evento}}</td>
                                        <td class="product-price" data-title="Precio U.">$ {{$cart->eventos->Costo}}</td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <input type="button" value="-" class="minus" onclick="restaEvento({{$cart->eventos->id}})">
                                                <input type="text" id='cantidadEvento-{{$cart->eventos->id}}' name="quantity" value="{{$cart->Cantidad}}" readonly title="Qty" class="qty" size="4">
                                                <input type="button" value="+" class="plus" onclick="sumaEvento({{$cart->eventos->id}})">
                                            </div>
                                        </td>
                                            <input type="hidden" id="costo-{{$cart->eventos->id}}" value="{{$cart->eventos->Costo}}">
                                        <td class="product-price" data-title="Price"><input value="$ {{$cart->Subtotal}}" type="text" id="precioEvento-{{$cart->eventos->id}}" readonly style="border: 0; text-align: center; font-weight: 600"></td>
                                    @endif
                                </div></td>
                                    <td class="product-subtotal"  id="totalEvento" data-title="Total"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Linea de separación --}}
        <div class="row">
            <div class="col-12">
            	<div class="medium_divider"></div>
            	<div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
            	<div class="medium_divider"></div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success" id="msgAlert" style="width: 500px; margin-left: 350px" id="alert">
                {{ session('status') }}
            </div>
        @endif
        {{-- Sección inferior (form y pago) --}}
        <div class="row">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{-- formulario de envío --}}
        	<div class="col-md-6">
            	<div class="heading_s1">
            		<h4>Datos de Envío</h4>
                </div>
                {!! Form::open(['url'=>'payWithPaypal','id' => 'form-multipayment']) !!}
                    @if(isset($direccionCompleta))
                        <input type="hidden" name="addressM" value="{{$direccionCompleta}}">
                    @endif
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Nombre" id="Nombre"  placeholder="Nombre *">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Apellido" id="Apellido" placeholder="Apellido *">
                    </div>
                    <div class="form-group">
                        <div class="alert-message" id="errorTel"></div>
                        <input class="form-control" required type="text" name="Telefono" id="Telefono" placeholder="Teléfono/Celular *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Email"  id="Email" placeholder="Email *">
                    </div>
                    @if(isset($direccionCompleta) && $direccionCompleta == 1)
                        <input type="hidden" name="address" id="address" value="{{$direccionCompleta}}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="Domicilio" name="Domicilio" required="" placeholder="Domicilio (Calle & Número) *">
                        </div>
                        <div class="form-group">
                            <input type="text" required class="form-control" name="Colonia" id="Colonia" placeholder="Colonia *">
                        </div>
                        <div class="form-group">
                            <input class="form-control" required type="text" id="Ciudad" name="Ciudad" placeholder="Ciudad *">
                        </div>
                        <div class="form-group">
                            <input class="form-control" required type="text" name="Estado" id="Estado" placeholder="Estado *">
                        </div>
                        <div class="form-group">
                            <input class="form-control" required type="text" name="Pais" id="pais" placeholder="País *">
                        </div>
                        <div class="form-group">
                            <input class="form-control" required type="text" name="CP" id="CP" placeholder="Código Postal *">
                        </div>
                        <div class="heading_s1">
                            <h4>Información Adicional</h4>
                        </div>
                        <div class="form-group mb-0">
                            <textarea rows="5" class="form-control" name="InfoExtra" id="InfoExtra" style="resize: none" placeholder="Dedica el libro!"></textarea>
                        </div>
                    @endif
            </div>
            {{-- Cálculo de total --}}
            <div class="col-md-6" >
                <br><br>
            	<div class="border p-3 p-md-4">
                    <div class="heading_s1 mb-3">
                        <h6>Carrito</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">Subtotal</td>
                                    <td class="cart_total_amount"><input id="subtotal" type="text" readonly style="border: 0; font-weight: 600; text-align: center"></td>
                                </tr>
                                <tr>
                                    @if(isset($direccionCompleta) && $direccionCompleta == 1)
                                        <input type="hidden" name="address" id="address" value="{{$direccionCompleta}}">
                                        <td class="cart_total_label">Costo de Envío</td>
                                        <td class="cart_total_amount"><input id="envio" name="Envio" type="text" style="border: 0; text-align: center; font-weight: 600" readonly></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount"><strong><input id="total" type="text" name="Total" val="" style="border: 0; text-align: center; font-weight: 600" readonly></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex-container">
                        <button class="btn btn-fill-out flex-item" type="submit">PayPal</button>
                {!! Form::close() !!}
                        <button  class="btn btn-fill-out flex-item" type="button" id="modal" data-target="#modal-deposito" data-toggle="modal">Depósito</button>
                        <button class="btn btn-fill-out flex-item" src="" id="button-checkout" {{--onclick="pagarMP()" --}}>MercadoPago</button>
                    </div>
                </div>
                <div class="toggle_info">
                    <span><i class="fas fa-tag"></i>¿Tienes un cupón? <a href="#coupon" data-toggle="collapse" class="collapsed" aria-expanded="false">Haz click aquí para ingresarlo</a></span>
                </div>
                <div class="panel-collapse collapse coupon_form" id="coupon">
                    <div class="panel-body">
                        {{-- {!! Form::open(['url'=>'aplicarCupon','method'=>'GET']) !!} --}}
                        <div class="coupon field_form input-group">
                            <input type="text"  id="cupon" name="cupon" class="form-control" placeholder="Ingresa tu código..">
                            <div class="input-group-append">
                                <button onclick="aplicarCupon()" class="btn btn-fill-out btn-sm" type="submit">Aplicar cupón</button>
                                {{--  --}}
                            </div>
                        </div>
                        {{-- {!! Form::close() !!} --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-deposito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Datos para realizar tu depósito</h5>
                    </div>
                    <div class="modal-body">
                        Deposita el costo del libro(s).

                        BBVA 4152 3133 8175 4725
                        <br>
                        Tu libro llega entre uno y dos días hábiles.
                        <br>
                        Al continuar con este método de pago, se levantará un pedido y te enviaremos un correo electrónico con los datos necesarios
                        para realizar tu pago con depósito bancario o desde un oxxo.
                    </div>
                    {!! Form::open(['url'=>'depositoBancario']) !!}
                    <div class="modal-footer">
                        {!! Form::hidden('nombre', '', ['id'=>'nombre']) !!}
                        {!! Form::hidden('apellido', '', ['id'=>'apellido']) !!}
                        {!! Form::hidden('total', '', ['id'=>'Total']) !!}
                        {!! Form::hidden('domicilio', '', ['id'=>'domicilio']) !!}
                        {!! Form::hidden('colonia', '', ['id'=>'colonia']) !!}
                        {!! Form::hidden('ciudad', '', ['id'=>'ciudad']) !!}
                        {!! Form::hidden('estado', '', ['id'=>'estado']) !!}
                        {!! Form::hidden('pais', '', ['id'=>'Pais']) !!}
                        {!! Form::hidden('infoextra', '', ['id'=>'infoextra']) !!}
                        {!! Form::hidden('email', '', ['id'=>'email']) !!}
                        {!! Form::hidden('telefono', '', ['id'=>'telefono']) !!}
                        {!! Form::hidden('envio', '', ['id'=>'Envio']) !!}
                        {!! Form::hidden('cp', '', ['id'=>'cp']) !!}
                        {{-- {!! Form::hidden('addressM','{{$direccionCompleta}}', ['id'=>'AddressM']) !!}
                         --}}
                         @if (isset($direccionCompleta))
                            <input type="hidden" name="addressM" value="{{$direccionCompleta}}">
                         @endif
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <style>
    .mercadopago-button{
        background: #423e3f;
        margin-top: 10px;
        font-family: "Inconsolata";
        font-weight: 400;
        /* border-width: 1px; */
        /* padding: 12px; */
    }
</style> --}}
<!-- END SECTION SHOP -->

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
     {{-- Scripts para Paypal --}}
     <script src="https://www.paypalobjects.com/api/checkout.js"></script>
     <script>
        function sumaLibro(id){
            var cantidad = $('#cantidadLibro-'+id).val();
            // alert(cantidad)
            var sum = Number(cantidad) + 1;
            var price = $('#precio-'+id).val();
            var sub = sum * Number(price);

            $('#precioLibro-'+id).val('$'+Number(sub));

            var subtotal = $('#subtotal').val();
            var sumarSubtotal = parseInt(price) + parseInt(subtotal);
            // alert(sumarSubtotal)
            $('#subtotal').val(sumarSubtotal);
            $('#total').val(sumarSubtotal);
        }
        function sumaEvento(id){
            var cantidad = $('#cantidadEvento-'+id).val();
            var sum = parseInt(cantidad) + 1;
            var price = $('#costo-'+id).val();
            var sub = sum * price;
            // alert(sub)
            $('#precioEvento-'+id).val('$'+sub);

            var subtotal = $('#subtotal').val();
            var sumarSubtotal = parseInt(price) + parseInt(subtotal);
            // alert(sumarSubtotal)
            $('#subtotal').val(sumarSubtotal);
            $('#total').val(sumarSubtotal);
        }
        function restaLibro(id){
            var cantidad = $('#cantidadLibro-'+id).val();
            var resta = parseInt(cantidad) - 1;

            if(cantidad == 0){
                alert('simon')
               $.get('eliminarLibro', function(result){

               })
            }
            var price = $('#precio-'+id).val();
            var sub = resta * price;
            // alert(sub)
            $('#precioLibro-'+id).val('$'+Number(sub));

            var subtotal = $('#subtotal').val();
            var sumarSubtotal = parseInt(subtotal) - parseInt(price) ;
            // alert(sumarSubtotal)
            $('#subtotal').val(sumarSubtotal);
            $('#total').val(sumarSubtotal);
        }
        function restaEvento(id){
            var cantidad = $('#cantidadEvento-'+id).val();
            var resta = parseInt(cantidad) - 1;
            var price = $('#costo-'+id).val();
            var sub = resta * price;
            // alert(sub)
            $('#precioEvento-'+id).val('$'+sub);
            var subtotal = $('#subtotal').val();
            var sumarSubtotal = parseInt(subtotal) - parseInt(price);
            // alert(sumarSubtotal)
            $('#subtotal').val(sumarSubtotal);
            $('#total').val(sumarSubtotal);
        }
        function aplicarCupon(){
            var cupon = $('#cupon').val();
            // alert(cupon)
            $.ajax({
                url: "{{url('aplicarCupon') }}",
                method: 'GET',
                data: {
                    cupon: cupon,
                }
            }).done(function(result){
                // alert(result)
                if(result == 'nel'){
                    swal("El cupón que ingresaste no es válido!", {
                        buttons: false,
                        timer: 2000,
                    });
                }
                var tipo = result.charAt(result.length - 1);
                // alert(tipo)var
                var val = result.split('/');

                if(tipo == '3'){
                    $('#envio').val('0');
                    var subtotal = $('#subtotal').val();
                    var envio = $('#envio').val();
                    var total = parseInt(subtotal);
                    $('#total').val(total);
                    swal("Felcidades, se hizo el descuento del cupón ingresado!", {
                        buttons: false,
                        timer: 2000,
                    });
                }else if(tipo == '2'){
                    // alert(val[0])
                    var totalOld = $('#total').val();
                    var total = parseInt(totalOld) - parseInt(val[0]);
                    $('#total').val(total);
                    swal("Felcidades, se hizo el descuento del cupón ingresado!", {
                        buttons: false,
                        timer: 2000,
                    });
                }else if(tipo == '1'){
                    total = $('#total').val();
                    // alert(total)
                    porcentaje = parseInt(val[0])/100;
                    // alert(porcentaje)
                    descuento = porcentaje*parseInt(total);
                    // alert(descuento)

                    $('#total').val(total-descuento);
                        swal("Felcidades, se hizo el descuento del cupón ingresado!", {
                            buttons: false,
                            timer: 2000,
                        });
                }

                // $('#envio').val(result);
                // var subtotal = $('#subtotal').val();
                // var envio = $('#envio').val();
                // var total = parseInt(subtotal) + parseInt(envio);
                // // alert(total)
                // $('#total').val(total);
                // alert($('#total').val())
                // $("#headerNew").load(" #headerNew");
            });
        }
        $(document).ready(function(){
           var sub = $('#subtotal').val(parseInt($('#totalHeader').val()));
            // alert(sub)
            $('#total').val(parseInt($('#totalHeader').val()));

            setTimeout(function() {
                $("#msgAlert").fadeOut();
            },3500);
        })
        $('#pais').on('change',function(){
            var pais = $('#pais').val();
            // alert(pais)
            $.ajax({
                url: "{{url('calcularEnvio') }}",
                method: 'GET',
                data: {
                    pais: pais,
                }
            }).done(function(result){
                // alert(result)
                $('#envio').val(result);
                var subtotal = $('#subtotal').val();
                var envio = $('#envio').val();
                var total = parseInt(subtotal) + parseInt(envio);
                // alert(total)
                $('#total').val(total);
                // alert($('#total').val())
                // $("#headerNew").load(" #headerNew");
            });

            var total = $('#total').val();
            var nombre = $('#Nombre').val();
            var domicilio = $('#Domicilio').val();
            var apellido = $('#Apellido').val();
            var colonia = $('#Colonia').val();
            var ciudad = $('#Ciudad').val();
            var Estado = $('#Estado').val();
            var pais = $('#Pais').val();
            var cp = $('#CP').val();
            var telefono = $('#Telefono').val();
            var email = $('#Email').val();
            var infoExtra = $('#infoExtra').val();
            var envio = $('#envio').val();
        })
        $('#modal').on('click',function(){
            // e.preventDefault();
            var total = $('#total').val();
            var nombre = $('#Nombre').val();
            var domicilio = $('#Domicilio').val();
            var apellido = $('#Apellido').val();
            var colonia = $('#Colonia').val();
            var ciudad = $('#Ciudad').val();
            var estado = $('#Estado').val();
            var pais = $('#pais').val();
            var cp = $('#CP').val();
            var telefono = $('#Telefono').val();
            var email = $('#Email').val();
            var infoExtra = $('#InfoExtra').val();
            var envio = $('#envio').val();
            // var address = $('#address').val();
            // var total = $('#Total').val();
            // alert(address)
            $('#nombre').val(nombre);
            $('#apellido').val(apellido);
            $('#ciudad').val(ciudad);
            $('#domicilio').val(domicilio);
            $('#colonia').val(colonia);
            $('#estado').val(estado);
            $('#Pais').val(pais);
            $('#cp').val(cp);
            $('#email').val(email);
            $('#telefono').val(telefono);
            $('#infoextra').val(infoExtra);
            $('#Total').val(total);
            $('#Envio').val(envio);
            // $('#AddressM').val(address);
        })
        function pagarMP(){
            var total = $('#total').val();
            var token = $('#token').val();
            var nombre = $('#Nombre').val();
            var domicilio = $('#Domicilio').val();
            var apellido = $('#Apellido').val();
            var colonia = $('#Colonia').val();
            var ciudad = $('#Ciudad').val();
            var estado = $('#Estado').val();
            var pais = $('#pais').val();
            var cp = $('#CP').val();
            var telefono = $('#Telefono').val();
            var email = $('#Email').val();
            var infoExtra = $('#InfoExtra').val();
            var envio = $('#envio').val();
            var address = $('#address').val();
            // alert(address);

            $.ajax({
                    url: "{{url('mercadoPagoPay') }}",
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data:{
                        total: total,
                        nombre : nombre,
                        domicilio : domicilio,
                        apellido : apellido,
                        colonia : colonia,
                        ciudad : ciudad,
                        estado : estado,
                        pais : pais,
                        cp : cp,
                        telefono : telefono,
                        email : email,
                        infoExtra : infoExtra,
                        envio : envio,
                        address: address,
                    },
                    success:function(preference){
                        if(preference.id == 1){
                            // alert(preference)
                            $.each(preference.errors, function(key,value) {
                                alert(value);
                                    // $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
                            });
                        }else{
                            var script = document.createElement("script");
                            script.src = "https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js";
                            script.type = "text/javascript";
                            script.dataset.preferenceId = preference;
                            script.setAttribute('defer','');
                            document.querySelector("#button-checkout").appendChild(script);
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function(key,value) {
                                alert(value);
                                // $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
                            });
                        }

                    }
            })
            // .done(function(preference) {
            //     var script = document.createElement("script");
            //     script.src = "https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js";
            //     script.type = "text/javascript";
            //     script.dataset.preferenceId = preference;
            //     document.querySelector("#button-checkout").appendChild(script);
                // document.querySelector("#button-checkout").setAttribute('src',script);
                // document.querySelector('#button-checkout').click();
            // })

        }
    </script>
    <script defer>
        // ## Checkout Mercado Pago por xhr ##
        // Defining consts
        let checkout = document.getElementById('button-checkout');
        const multi_form = document.getElementById('form-multipayment');
        // Add the listener to our button
        checkout.addEventListener('click', setUpPayment);
        // Aux Variable, represents the 'mercadopago-modal'
        let mp = null;
        function setUpPayment() {
            // Check target form validation
            if (multi_form.reportValidity()) {
                // Form input is OK, use the already declared function to insert the 'mercadopago' script
                pagarMP();
                // Remove the listener so further clicks wont insert more scripts
                checkout.removeEventListener('click', setUpPayment);
                // Check if the 'mercadopago' modal is ready every 0.1 seconds
                let waiting4 = setInterval(getMP, 100);
                // Limit the iterations, just in case 'mercadopago' library could't load or something
                let count = 0;
                function getMP() {
                    // The query selector points to the class of the modal parent
                    mp = document.querySelector('.mp-mercadopago-checkout-wrapper');
                    if (mp != null) {
                        // Modal is ready, clear the interval and proceed
                        clearInterval(waiting4);
                        console.log('ready');
                        // Hide the 'pago' button and click it
                        const mp_button = document.querySelector('.mercadopago-button');
                        mp_button.style.display = "none";
                        mp_button.click();
                        // Prepare reset in case of 'cancelar pago'
                        checkout.addEventListener('click', resetPayment);
                    }
                    else {
                        // Modal aint ready yet
                        console.log('waiting')
                        count = count + 1;
                        if ( count > 50 ) {
                            // After 5 seconds of waiting something must be wrong, abort
                            clearInterval(waiting4);
                            alert('Problemas al conectarse con MercadoPago, en breve se recargará la página.') // Change crappy alert for something nice, a span for example
                            setTimeout(function(){ location.reload() }, 5000);
                        }
                    }
                }
            }
            // Else => form input is NOT ok, html will let the user know
        }
        // If the 'pago' is we gotta call the 'mercadopago' script again
        // in case the user changed any inputs on the form
        function resetPayment() {
            // Clone the our button without its children, droping all the
            // 'mercadopago' stuff inside and any events.
            let clone = checkout.cloneNode(false);
            // Fill the clone like its parent and add the listener
            clone.innerHTML = "Mercado Pago";
            // Replace the button with the clean clone
            checkout.replaceWith(clone);
            // Destroy the existing 'mercadopago' wrapper
            mp.remove();
            // Redifine 'mp' and 'checkout', possibly redundant
            mp = null;
            checkout = document.getElementById('button-checkout');
            // setUpPayment again
            setUpPayment();
        }
    </script>
@endsection
