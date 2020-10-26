@extends('files.template')

@section('content')
<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive shop_cart_table">
                	<table class="table">
                    	<thead>
                        	<tr>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Descripción</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Hora</th>                                
                                <th class="product-price">Precio</th>
                                {{-- <th class="product-quantity">Cantidad</th>
                                <th class="product-subtotal">Total</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eventos as $evento)
                                <tr>
                                    <td class="product-thumbnail"><a href="#"><img src="{{asset('assets/images/calendario.png')}}" alt=""></a></td>
                                    <td class="product-name" data-title="Product"><a href="#">{{$evento->Evento}} <br> Lugar: {{$evento->Lugar}}
                                    <br> Domicilio: {{$evento->Domicilio}}</a></td>
                                    <td>{{$evento->Estado}}</td>
                                    <td class="product-price" data-title="Price">{{$evento->Fecha}}</td>
                                    <td>{{$evento->Hora}}</td>
                                    <td>${{number_format($evento->Costo,2)}}</td>
                                    {{-- <td class="product-quantity" data-title="Quantity"><div class="quantity">
                                    <input type="button" value="-" class="minus">
                                    <input type="text" name="quantity" value="2" title="Qty" class="qty" size="4">
                                    <input type="button" value="+" class="plus">
                                </div></td>
                                    <td class="product-subtotal"  id="totalEvento" data-title="Total"></td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      
    </div>
</div>
<!-- END SECTION SHOP -->

@endsection

@section('scripts')
    <script>

    </script>
@endsection