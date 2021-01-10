@php
    use App\Comentarios;
    // dd(session('key'));
@endphp
@extends('files.template')

@section('popup')
    @if(session('key') == null)
        @include('files.modal_news')
    @endif
@endsection

@section('content')
    <!-- START SECTION SHOP -->
 
    <div class="section">
        <div class="container">
            @foreach ($autores as $autor)
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="heading_s1 text-center">
                        <h2>{{$autor->Nombre}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1" data-loop="true" data-dots="false" data-nav="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                            @foreach ($autor->Libros as $libro)
                                <div class="item" >
                                    <div class="product" id="vrg-{{$libro->id}}">
                                        <div class="product_img" style="height: 400px;">
                                            <a href="{!! url('detalle/'.$libro->id) !!}">
                                                <img id="img-{{$libro->id}}" src="{!! url('https://admin.multiversolibreria.com/img/Portadas/'.$libro->Portada) !!}" width="100px">
                                            </a>
                                            <div class="product_action_box">
                                                <ul class="list_none pr_action_btn">
                                                    <li class="add-to-cart"><a onclick="agregar({{$libro->id}});" id="productoId" value="{{$libro->id}}"><i class="icon-basket-loaded"></i> Agregar al carrito</a></li>
                                                    <li><a type="button" data-toggle="modal" data-target="#exampleModal" data-verga="{{$libro->id}}"><i class="icon-magnifier-add"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product_info">
                                            <h6 class="product_title"><a href="{!! url('detalle/'.$libro->id) !!}">{{ $libro->Titulo }}</a></h6>
                                            <div class="product_price">
                                                <a href="{!! url('detalle/'.$libro->id) !!}"><span class="price">$ {{ $libro->Precio }}</span></a>
                                            </div>
                                            @php
                                                $suma=0;
                                                $comentarios = Comentarios::where('books_id',$libro->id)->get();
                                                    // dd($comentarios);
                                                    if($comentarios->count() > 0){
                                                        foreach($comentarios as $comments){
                                                            $suma = $suma+$comments->Star_rating;
                                                        }
                                                        $promedio=$suma/ count($comentarios);
                                                        // dd($promedio);
                                                    }else{
                                                        $promedio=0;
                                                    }
                                            @endphp
                                            <div class="rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width:{{ (100/5)*round($promedio) }}%"></div>
                                                </div>
                                                <span class="rating_num">({{count($comentarios)}})</span>
                                            </div>
                                            <div class="pr_desc">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <div  class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="iframe" class="modal-body" style="position: relative;
                        overflow: hidden;
                        padding-top: 56.25%;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection

@section('scripts')
    <script>
        function agregar(id){
            $.ajax({
                async:true,
                url: "{{url('agregarCarrito') }}",
                method: 'GET',
                data: {
                    cantidad: 1,
                    id: id,

                }
            }).done(function(result){
                // alert(result)
                if(result == 'Hecho'){
                //    $('#headerNew').html(result);
                //    window.location.reload(true);
                //    window.location.href = window.location.href;
                    $("#headerNew").load(" #headerNew");
                    swal("Libro agregado", {
                        buttons: false,
                        timer: 3000,
                    });
                }else if(result == 'Fail'){
                    swal (  "Hubo un error, intenta más tarde por favor!" ,{
                        buttons: false,
                        timer: 3000,
                    })
                }
            });
        };
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('verga') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            // var modal = $(this)
            // $('#exampleModalLabel').text(recipient)
            // modal.find('.modal-title').text(recipient)
            // modal.find('.modal-body input').val(recipient)

            $.get('{{ url("iframe")}}/'+recipient, function(data){
                
                document.getElementById('iframe').innerHTML = data;
                // document.getElementById('iframe').style.position =  'absolute';
                // document.getElementById('iframe').style.top = 0;
                // document.getElementById('iframe').style.left = 0;
                // document.getElementById('iframe').style.bottom = 0;
                // document.getElementById('iframe').style.right = 0;
                // document.getElementById('iframe').style.width = '100%';
                // document.getElementById('iframe').style.height = '100%';
                // document.getElementById('iframe').style.border = 'none';

            })
        })

    </script>
@endsection
