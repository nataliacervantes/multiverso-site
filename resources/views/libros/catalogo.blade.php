@extends('files.template')

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
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                    <a href="{!! url('detalle/'.$libro->id) !!}">
                                            <img src="{!! url('http://127.0.0.1:8001/img/Portadas/'.$libro->Imagenes) !!}" width="100px">
                                            {{-- <img src="images/{{$libro->Titulo}}" width="100px"> --}}
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                            <li class="add-to-cart"><a onclick="agregar({{$libro->id}});" id="productoId" value="{{$libro->id}}"><i class="icon-basket-loaded"></i> Agregar al carrito</a></li>
                                                {{-- <li><a href="//bestwebcreator.com/shopwise/demo/shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li> --}}
                                                <li><a href="{!! url('http://127.0.0.1:8001/img/Portadas/'.$libro->Imagenes) !!}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="{!! url('detalle/'.$libro->id) !!}">{{ $libro->Titulo }}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ {{ $libro->Precio }}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                        {{-- <div class="pr_switch_wrap">
                                            <div class="product_color_switch">
                                                <span class="active" data-color="#87554B"></span>
                                                <span data-color="#333333"></span>
                                                <span data-color="#DA323F"></span>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection
@section('scripts')
    <script>
        function agregar(id){
            $.ajax({
                url: "{{url('agregarCarrito') }}",
                method: 'GET',
                data: {
                    cantidad: 1,
                    id: id,
                }
            }).done(function(result){
                if(result == 'Hecho'){
                   
                }
            });
        }
    </script>
@endsection