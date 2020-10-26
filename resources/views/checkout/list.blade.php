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
                                <th>Cantidad</th>
                                <th class="product-price">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carrito as $cart)
                                <tr>
                                    @if($cart->books_id != null )
                                    <input type="hidden" value="{{$cart->books_id}}" id="idLibro">
                                        <td class="product-thumbnail"><a href="#"><img src="{!! url('http://127.0.0.1:8001/img/Portadas/'.$cart->books->Portada) !!}" alt="cart_thumb1"></a></td>
                                        <td >{{$cart->books->Titulo}}</td>
                                        <td class="product-quantity" data-title="Quantity"><div class="quantity">
                                            <input type="button" value="-" class="minus" onclick="restaLibro({{$cart->books->id}})">
                                            <input type="text" id='cantidadLibro-{{$cart->books->id}}' name="quantity" value="{{$cart->Cantidad}}" readonly title="Qty" class="qty" size="4">
                                            <input type="button" value="+" class="plus" onclick="sumaLibro({{$cart->books->id}});">
                                            </div></td>
                                            <input type="hidden" id="precio-{{$cart->books->id}}" value="{{$cart->books->Precio}}">
                                        <td class="product-price"  data-title="Price"><input type="text" value="{{$cart->Subtotal}}" id="precioLibro-{{$cart->books->id}}" readonly style="border: 0; text-align: center; font-weight: 600"></td>
                                    @elseif($cart->eventos_id != null )
                                        <input type="hidden" value="{{$cart->books_id}}" id="idEvento">
                                        <td class="product-thumbnail">
                                            <a href="{!! url('detalle/'.$cart->eventos->id) !!}"><img src="{!! asset('assets/images/calendario.png') !!}" alt="cart_thumb1"></a>
                                        </td>
                                        <td >{{$cart->eventos->Evento}}</td>
                                        <td class="product-quantity" data-title="Quantity"><div class="quantity">
                                            <input type="button" value="-" class="minus" onclick="restaEvento({{$cart->eventos->id}})">
                                            <input type="text" id='cantidadEvento-{{$cart->eventos->id}}' name="quantity" value="{{$cart->Cantidad}}" readonly title="Qty" class="qty" size="4">
                                            <input type="button" value="+" class="plus" onclick="sumaEvento({{$cart->eventos->id}})">
                                            </div></td>
                                            <input type="hidden" id="costo-{{$cart->eventos->id}}" value="{{$cart->eventos->Costo}}">
                                        <td class="product-price" data-title="Price"><input value="{{$cart->Subtotal}}" type="text" id="precioEvento-{{$cart->eventos->id}}" readonly style="border: 0; text-align: center; font-weight: 600"></td>
                                        {{-- {{ number_format($cart->Subtotal * $cart->Cantidad)}} --}}
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
            {{-- formulario de envío --}}
        	<div class="col-md-6">
            	<div class="heading_s1">
            		<h4>Datos de Envío</h4>
                </div>
                {!! Form::open(['url'=>'formEnvio']) !!}
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Nombre"  placeholder="Nombre *">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Apellido" placeholder="Apellido *">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="Domicilio" required="" placeholder="Domicilio (Calle & Número) *">
                    </div>
                    <div class="form-group">
                        <input type="text" required class="form-control" name="Colonia" placeholder="Colonia *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Ciudad" placeholder="Ciudad *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Estado" placeholder="Estado *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Pais" id="pais" placeholder="País *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="CP" placeholder="Código Postal *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Telefono" placeholder="Teléfono/Celular *">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" name="Email" placeholder="Email *">
                    </div>
                    <div class="heading_s1">
                        <h4>Información Adicional</h4>
                    </div>
                    <div class="form-group mb-0">
                        <textarea rows="5" class="form-control" name="InfoExtra" style="resize: none" placeholder="Dedica el libro!"></textarea>
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
                                    <td class="cart_total_amount"><strong><input id="total" type="text" name="Total" style="border: 0; text-align: center; font-weight: 600" readonly></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-fill-out">Pagar</button>
                </div>
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

@endsection

@section('scripts')
    <script>
        function sumaLibro(id){
            var cantidad = $('#cantidadLibro-'+id).val();
            // alert(cantidad)
            var sum = Number(cantidad) + 1;
            var price = $('#precio-'+id).val();
            var sub = sum * Number(price);
          
            $('#precioLibro-'+id).val(Number(sub));
            
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
            $('#precioEvento-'+id).val(sub);

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
            $('#precioLibro-'+id).val(sub);

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
            $('#precioEvento-'+id).val(sub);
            var subtotal = $('#subtotal').val();
            var sumarSubtotal = parseInt(subtotal) - parseInt(price);
            // alert(sumarSubtotal)
            $('#subtotal').val(sumarSubtotal);
        }

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
                // $("#headerNew").load(" #headerNew");
            });
        })

    </script>
@endsection