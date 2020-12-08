@extends('files.template')

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
                                        <td class="product-quantity" data-title="Quantity"><div class="quantity">
                                            <input type="button" value="-" class="minus" onclick="restaEvento({{$cart->eventos->id}})">
                                            <input type="text" id='cantidadEvento-{{$cart->eventos->id}}' name="quantity" value="{{$cart->Cantidad}}" readonly title="Qty" class="qty" size="4">
                                            <input type="button" value="+" class="plus" onclick="sumaEvento({{$cart->eventos->id}})">
                                            </div></td>
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
                {!! Form::open(['url'=>'payWithPaypal']) !!}
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Nombre" id="Nombre"  placeholder="Nombre *">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Apellido" id="Apellido" placeholder="Apellido *">
                    </div>
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
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Telefono" id="Telefono" placeholder="Teléfono/Celular *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Email"  id="Email" placeholder="Email *">
                    </div>
                    <div class="heading_s1">
                        <h4>Información Adicional</h4>
                    </div>
                    <div class="form-group mb-0">
                        <textarea rows="5" class="form-control" name="InfoExtra" id="InfoExtra" style="resize: none" placeholder="Dedica el libro!"></textarea>
                    </div>
            </div>
            {{-- Cálculo de total --}}
            <div class="col-md-6">
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
                                    <td class="cart_total_label">Costo de Envío</td>
                                    <td class="cart_total_amount"><input id="envio" name="Envio" type="text" style="border: 0; text-align: center; font-weight: 600" readonly></td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount"><strong><input id="total" type="text" name="Total" val="" style="border: 0; text-align: center; font-weight: 600" readonly></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-fill-out" type="submit">PayPal</button>
                    {!! Form::close() !!}
                    <button  class="btn btn-fill-out" type="button" id="modal" data-target="#modal-deposito" data-toggle="modal">Depósito</button>
                    <button  class="btn btn-fill-out" type="button" id="modal" data-target="#modalMP" data-toggle="modal">Mercadopago</button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        
                <!-- Modal -->
                <div class="modal fade" id="modalMP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pagar con Tarjeta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="mercado-pago-pagar" method="post" id="paymentForm">
                                <div class="modal-body" style="margin: 20px">
                                    <div class="container_payment" id='container_payment'>
                                        <div class="form-payment">
                                            <div class="payment-details">
                                                @csrf
                                                <div class="row">
                                                    <label for="email">E-Mail</label>
                                                    <input id="email" name="email" type="text" class="form-control">
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="form-group col-sm-8">
                                                        <label for="cardholderName">Nombre que aparece en la tarjeta</label>
                                                        <input id="cardholderName" data-checkout="cardholderName" type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group col-sm-3" style="margin-left: 15px">
                                                        <label for="">Fecha de Expiración</label>
                                                        <div class="input-group expiration-date">
                                                            <input type="text" class="form-control" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth"
                                                                onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off>
                                                            <input type="text" class="form-control" placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear"
                                                                onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-8">
                                                        <label for="cardNumber">Número de la tarjeta</label>
                                                        <input type="text" class="form-control input-background" id="cardNumber" data-checkout="cardNumber"
                                                            onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off>
                                                    </div>
                                                    <div class="form-group col-sm-3" style="margin-left: 15px">
                                                        <label for="securityCode">CVV</label>
                                                        <input id="securityCode" data-checkout="securityCode" type="text" class="form-control"
                                                            onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off>
                                                    </div>
                                                    <div id="issuerInput" class="form-group col-sm-12 hidden">
                                                        <label for="issuer">Banco</label>
                                                        <select id="issuer" name="issuer" data-checkout="issuer" class="form-control"></select>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label for="installments">Pagos</label>
                                                        <select type="text" id="installments" name="installments" class="form-control"></select>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        {{-- <input type="hidden" name="idPedido" id="idPedido"  value="{{ $pedido->id}}">
                                                        <input type="hidden" name="idDomicilio" id="modalDomicilio" value="">
                                                        <input type="hidden"  name="idTipoPago" id="modalTipoPago" value="" >
                                                        <input type="hidden" name="folio" id="folio" value="{{ $pedido->Folio }}">
                                                        <input type="hidden" value="{{ $tc }}" id="tc" name="tipoCambio">
                                                        <input type="hidden" name="facturacion" id="facturacion" value="">
                                                        <input type="hidden" name="idFacturacion" id="idFacturacion" value="">
                                                        <input type="hidden" name="transactionAmount" id="amount" value="{{ $total }}" />
                                                        <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
                                                        <input type="hidden" name="description" id="description" value="TecnoAbastos"/> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ">Pagar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
</div>
<!-- END SECTION SHOP -->

@endsection

@section('scripts')
    <script>
        // function sumaLibro(id){
        //     var cantidad = $('#cantidadLibro-'+id).val();
        //     // alert(cantidad)
        //     var sum = Number(cantidad) + 1;
        //     var price = $('#precio-'+id).val();
        //     var sub = sum * Number(price);
          
        //     $('#precioLibro-'+id).val(Number(sub));
            
        //     var subtotal = $('#subtotal').val();
        //     var sumarSubtotal = parseInt(price) + parseInt(subtotal);
        //     // alert(sumarSubtotal)
        //     $('#subtotal').val(sumarSubtotal);
        // }

        // function sumaEvento(id){
        //     var cantidad = $('#cantidadEvento-'+id).val();
        //     var sum = parseInt(cantidad) + 1;
        //     var price = $('#costo-'+id).val();
        //     var sub = sum * price;
        //     // alert(sub)
        //     $('#precioEvento-'+id).val(sub);

        //     var subtotal = $('#subtotal').val();
        //     var sumarSubtotal = parseInt(price) + parseInt(subtotal);
        //     // alert(sumarSubtotal)
        //     $('#subtotal').val(sumarSubtotal);
        // }

        // function restaLibro(id){
        //     var cantidad = $('#cantidadLibro-'+id).val();
        //     var resta = parseInt(cantidad) - 1;
        //     var price = $('#precio-'+id).val();
        //     var sub = resta * price;
        //     // alert(sub)
        //     $('#precioLibro-'+id).val(sub);

        //     var subtotal = $('#subtotal').val();
        //     var sumarSubtotal = parseInt(subtotal) - parseInt(price) ;
        //     // alert(sumarSubtotal)
        //     $('#subtotal').val(sumarSubtotal);
        // }

        // function restaEvento(id){
        //     var cantidad = $('#cantidadEvento-'+id).val();
        //     var resta = parseInt(cantidad) - 1;
        //     var price = $('#costo-'+id).val();
        //     var sub = resta * price;
        //     // alert(sub)
        //     $('#precioEvento-'+id).val(sub);
        //     var subtotal = $('#subtotal').val();
        //     var sumarSubtotal = parseInt(subtotal) - parseInt(price);
        //     // alert(sumarSubtotal)
        //     $('#subtotal').val(sumarSubtotal);
        // }

        // $(document).ready(function(){
        //     $('#subtotal').val(parseInt($('#totalHeader').val()));
        // })

        // $('#pais').on('change',function(){
        //     var pais = $('#pais').val();
        //     // alert(pais)
        //     $.ajax({
        //         url: "{{url('calcularEnvio') }}",
        //         method: 'GET',
        //         data: {
        //             pais: pais,
        //         }
        //     }).done(function(result){
        //         // alert(result)
        //         $('#envio').val(result);
        //         var subtotal = $('#subtotal').val();
        //         var envio = $('#envio').val();
        //         var total = parseInt(subtotal) + parseInt(envio);
        //         // alert(total)
        //         $('#total').val(total);
        //         // $("#headerNew").load(" #headerNew");
        //     });
        // })
    </script>
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
        }
        function restaLibro(id){
            var cantidad = $('#cantidadLibro-'+id).val();
            var resta = parseInt(cantidad) - 1;
            var price = $('#precio-'+id).val();
            var sub = resta * price;
            // alert(sub)
            $('#precioLibro-'+id).val('$'+Number(sub));

            var subtotal = $('#subtotal').val();
            var sumarSubtotal = parseInt(subtotal) - parseInt(price) ;
            // alert(sumarSubtotal)
            $('#subtotal').val(sumarSubtotal);
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
        $('#MetodosPago').on('change',function(){
            var val = $('#MetodosPago').val();
            if(val == 'visa'|| val == 'master' || val == 'debvisa' || val == 'debmaster' || val == 'amex'){
                $('#container_payment').show();

            }else if( val == 'bancomer' || val == 'oxxo' | val == 'serfin' | val == 'banamex'){
                $('#container_payment').hide();
            }
        })
        $('#modalMP').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var idDomicilio = $('#Dire').val();
            var idTipoPago = $("input[name='payment_option']:checked").val();

            $('#modalDomicilio').val(idDomicilio);
            $('#modalTipoPago').val(idTipoPago);
            // $.get('{{ url("metodosPago") }}',function(val){
            //     for(var i=0; i<val.length; i++){
            //         if(val[i].id != 'mercadopagocard' && val[i].id != 'clabe' )
            //             $("#MetodosPago").append('<option value="'+val[i].id+'">'+val[i].name+'</option>');
            //     }
            // })
        })
        $(document).ready(function(){
            $('#subtotal').val(parseInt($('#totalHeader').val()));
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
        
                // paypal.Button.render({
                //     env: 'sandbox',
                //     client: {
                //         sandbox: 'AZqhIzlG5wszF6K-p7mpPKHi_TNsKD27ALvL-KXowrGCafQ6Pcorec0XBxN1oQ6Uy7YQXzjLoYcHW83I',
                //         production: 'AbBav_7FEP9RIE_aTYraX-McSAtmQOZUK-QRfNCO7BuxOm6zkaIEaR-nO_NFYnhQLEI4IJTvukChkZfV'
                //     },
                //     // Customize button (optional)
                //     // TEST-991604415903884-103004-9d5d54072d80dfba880a0b906e9fe537-62670496
                //     // TEST-477887df-5218-4745-97bc-ba9c55a2c73d Public key
                //         locale: 'en_MX',
                //         style: {
                //             size: 'small',
                //             color: 'black',
                //             shape: 'pill',
                //             label: 'paypal'
                //         },
                //     commit: true,
                //     payment: function(data, actions) {
                //     return actions.payment.create({
                //         transactions: [{
                //             amount: {
                //                 total: total,
                //                 currency: 'MXN'
                //             }
                //         }]
                //     });
                //     },
                //     // Execute the payment
                //     onAuthorize: function(data, actions) {
                //         return actions.payment.execute().then(function() {

                //             window.alert('Gracias por tu compra!');

                //             $.ajax({
                //                 url: 'realizarPedido',
                //                 method: 'POST',
                //                 data: {
                //                     '_token':'{{ csrf_token() }}',
                //                     total:total,
                //                     nombre:nombre,
                //                     domicilio:domicilio,
                //                     apellido:apellido,
                //                     colonia:colonia,
                //                     ciudad:ciudad,
                //                     estado:Estado,
                //                     pais:pais,
                //                     cp:cp,
                //                     telefono:telefono,
                //                     email:email,
                //                     infoExtra:infoExtra,
                //                     envio:envio,
                //                 }
                //             }).done(function(result){
                //                     // alert(result)
                //                 if(result == 'ok'){
                //                     window.location.href = 'orden-completa';
                //                 }else if(result == 'error'){
                //                     alert('Ingresa un domicilio')
                //                 }
                //             });
                //         });
                //     }
                // }, '#paypal-button');
        })
        $('#modal').on('click',function(){
            // e.preventDefault();
            var total = $('#total').val();
            // alert(total)
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
            // var total = $('#Total').val();

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
        })
    </script>
@endsection