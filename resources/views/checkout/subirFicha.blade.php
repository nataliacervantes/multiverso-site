@extends('files.template')

@section('content')
<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
        {{-- Sección inferior (form y pago) --}}
        @if(session('status'))
            <div class="alert alert-success" id="msgAlert" style="width: 1000px;" id="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row" style="display:block; margin:auto;">
            {{-- formulario de envío --}}
        	<div class="col-md-6 col-md-offset-8">
            	<div class="heading_s1">
            		<h4>Datos de Envío</h4>
                </div>
                {!! Form::open(['url'=>'subirFichaPago','files'=>'true']) !!}
                    <div class="form-group">
                        <input type="text" required class="form-control" name="folio" id="folio"  placeholder="Ingresa el folio de tu pedido *">
                    </div>
                    {!! Form::file('FichaPago', ['class'=>'form-control']) !!}
                    <br><br>
                    <button  class="btn btn-fill-out" type="submit">Subir</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

@endsection

@section('scripts')
    <script>
        $('document').ready(function(){
            $('#msgAlert').fadeIn();
            setTimeout(function() {
                $("#msgAlert").fadeOut();
            },2500);
        })
    </script>
@endsection