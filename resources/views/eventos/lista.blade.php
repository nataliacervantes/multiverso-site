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
                        {{-- <tfoot>
                        	<tr>
                            	<td colspan="6" class="px-0">
                                	<div class="row no-gutters align-items-center">

                                    	<div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                            <div class="coupon field_form input-group">
                                                <input type="text" value="" class="form-control form-control-sm" placeholder="Enter Coupon Code..">
                                                <div class="input-group-append">
                                                	<button class="btn btn-fill-out btn-sm" type="submit">Aplicar Cupón</button>
                                                </div>
                                            </div>
                                    	</div>
                                        <div class="col-lg-8 col-md-6 text-left text-md-right">
                                            <button class="btn btn-line-fill btn-sm" type="submit">Actualizar Carrito</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-12">
            	<div class="medium_divider"></div>
            	<div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
            	<div class="medium_divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            	<div class="border p-3 p-md-4">
                    <div class="heading_s1 mb-3">
                        <h6>Total de Carrito</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">Subtotal</td>
                                    <td class="cart_total_amount">$349.00</td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Shipping</td>
                                    <td class="cart_total_amount">Free Shipping</td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount"><strong>$349.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn btn-fill-out">Ir a pagar</a>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<!-- END SECTION SHOP -->

@endsection

@section('scripts')
    <script>

    </script>
@endsection