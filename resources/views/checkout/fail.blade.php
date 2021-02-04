@extends('files.template')

@section('content')
<div class="mt-4 staggered-animation-wrap">
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Orden Completa</h1>
                        {{--  <p>{!!$status!!}</p>  --}}
                    </div>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center order_complete">
                        <i class="fas fa-check-circle"></i>
                        <div class="heading_s1">
                        <h3>¡Upss!</h3>
                        </div>
                        <p>¡Hubo un problemma con tu compra!s.</p>
                        {{-- <a class="btn btn-secondary" href="{{ url('detallePedido/'.$pedido->id_pedidoBonance) }}">Ver</a> --}}
                        <a href="{{ url('/') }}" class="btn btn-fill-out">Continuar Comprando</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
</div>
@endsection