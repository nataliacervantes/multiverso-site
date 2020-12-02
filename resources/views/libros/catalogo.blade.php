@php
use App\Comentarios;
@endphp
@extends('files.template')

@section('popup')
    @include('files.modal_news')
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
                                    <div class="product">
                                        <div class="product_img fader" style="height: 400px;">
                                            <a href="{!! url('detalle/'.$libro->id) !!}">
                                                <img src="{!! url('https://admin.multiversolibreria.com/img/Portadas/'.$libro->Portada) !!}" width="100px"
                                                onmouseover="src='https://www.youtube.com/embed/U-Ooxpz0Eqk';" onmouseout="src='https://admin.multiversolibreria.com/img/Portadas/'.$libro->Portada;">
                                                <img src="{!! url('https://admin.multiversolibreria.com/img/Portadas/'.$libro->Contraportada) !!}" width="100px">
                                                <!-- <img src="images/{{$libro->Titulo}}" width="100px"> -->
                                            </a>
                                            <div class="product_action_box">
                                                <ul class="list_none pr_action_btn">
                                                    <li class="add-to-cart"><a onclick="agregar({{$libro->id}});" id="productoId" value="{{$libro->id}}"><i class="icon-basket-loaded"></i> Agregar al carrito</a></li>
                                                    <li><a href="{{ asset('images/depositofaltantes.mp4')}}" data-toggle="modal" data-target="#exampleModal" type="button"><i class="icon-magnifier-add"></i></a></li>
                                                    <!-- <li><a href="#"><i class="icon-heart"></i></a></li> -->
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
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Título</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/OTdPL8Gvtp4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/U-Ooxpz0Eqk"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  {{-- <button type="button" class="btn btn-primary">S</button> --}}
                </div>
              </div>
            </div>
          </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection

@section('scripts')
    
    <script>
     
        // $('.fader').hover(function() {
        //     $(this).find("img").fadeToggle();
        // });
        // $('.alert').alert()
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
        }
    </script>
@endsection