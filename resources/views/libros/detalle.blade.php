@extends('files.template')

@section('content')
<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
		<div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                <div class="product-image">
                    <div class="product_img_box">
                        <img id="product_img" src='{!! url('https://admin.multiversolibreria.com/img/Portadas/'.$libro->Portada) !!}' data-zoom-image="assets/images/product_zoom_img1.jpg" alt="product_img1" />
                        <a href="{!! asset('images/depositofaltantes.mp4') !!}" class="product_img_zoom" title="Zoom">
                            <span class="linearicons-zoom-in"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 " style="padding: 5% 0">
                <div class="pr_detail" style="padding: 10% 0; margin:30px">
                    <h4 class="product_title"><a href="{!! url('detalle/'.$libro->id) !!}">{{$libro->Titulo}}</a></h4>
                    <div class="product_description" >
                        <div class="product_price" style="float: left">
                            <span class="price">$ {{number_format($libro->Precio,2)}}</span>
                        </div>
                        <div class="rating_wrap" style="float: inline-end">
                            <div class="rating">
                                <div class="product_rate" style="width:{{ (100/5)*round($promedio) }}%">
                                </div>
                            </div>
                            <span class="rating_num">({{count($comentarios)}})</span>
                        </div>
                    </div><br><br>
                    <div class="pr_desc"><p>{{$libro->Descripcion}}</p></div>
                    <hr />
                    <div class="cart_extra" style="display: flex">
                        <div class="cart-product-quantity">
                            <div class="quantity">
                                <input type="button" value="-" class="minus " id="menos">
                                <input type="text" name="quantity" id='cantidad' value="1" title="Qty" class="qty" size="4">
                                <input type="button" value="+" id="mas" class="plus ">
                            </div>
                        </div>
                        <div class="cart_btn">
                                <a  class="btn btn-fill-out btn-addtocart d-none d-sm-none d-md-block" onclick="agregar({{$libro->id}});" style="color:aliceblue" id="productoId" value="{{$libro->id}}">
                                <i class="icon-basket-loaded"></i>Agregar al carrito</a>
                                <a  class="btn btn-fill-out btn-addtocart d-block d-sm-none d-md-none" onclick="agregar({{$libro->id}});" style="color:aliceblue" id="productoId" value="{{$libro->id}}">
                                <i class="icon-basket-loaded"></i>Comprar</a>
                        </div>
                    </div>
                    <hr />
                    <div class="product_share">
                        <ul class="social_icons">
                            <li>
                                {{-- %2Fcatalogo --}}
                                <iframe src="https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Fmultiversolibreria.com&layout=button&size=large&appId=1635210993323859&width=103&height=28" width="103" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="large_divider clearfix"></div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="tab-style3">
					<ul class="nav nav-tabs" role="tablist">
						{{-- <li class="nav-item">
							<a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Descripción</a>
                      	</li> --}}
                      	{{-- <li class="nav-item">
                        	<a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Additional info</a>
                      	</li> --}}
                      	<li class="nav-item">
                        	<a class="nav-link active" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Comentarios</a>
                      	</li>
                    </ul>
                	<div class="tab-content shop_info_tab ">
                      	{{-- <div class="tab-pane fade show active d-none d-sm-none d-md-block" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                        	<p>{{$libro->Descripcion}}</p>
                      	</div> --}}
                      	<div class="tab-pane fade show active" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                        	<div class="comments">
                            	<h5 class="product_tab_title"> Comentarios para <span>{{$libro->Titulo}}</span></h5>
                                <ul class="list_none comment_list mt-4">
                                    @foreach ($comentarios as $comments)
                                    <li>
                                        <div class="comment_img">
                                            <img src="{{ asset('assets/images/user1.jpg') }}" />
                                        </div>
                                        <div class="comment_block">
                                            <div class="rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width:{{ (100/5)*$comments->Star_rating }}%"></div>
                                                </div>
                                            </div>
                                            <p class="customer_meta">
                                                <span class="review_author">{{ $comments->Nombre }}</span>
                                                <span class="comment-date">{{ $comments->created_at }}</span>
                                            </p>
                                            <div class="description">
                                                <p>{{ $comments->Comentario }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            {{-- Form para agregar comentarios --}}
                            <div class="review_form field_form">
                                <h5>Agregar Comentario</h5>
                                {!! Form::open(['url'=>'agregarComentario','class'=>'row mt-3']) !!}
                                    <div class="form-group col-12">
                                        <input type="hidden" id="Star_rating" name="Star_rating"value="">
                                        <div class="star_rating">
                                            <span data-value="1" ><i class="far fa-star"></i></span>
                                            <span data-value="2" ><i class="far fa-star"></i></span>
                                            <span data-value="3" ><i class="far fa-star"></i></span>
                                            <span data-value="4" ><i class="far fa-star"></i></span>
                                            <span data-value="5" ><i class="far fa-star"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <textarea required="required" placeholder="Tu comentario *" style="resize: none" class="form-control" name="Comentario" rows="4"></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input required="required" placeholder="Ingresa tu nombre *" class="form-control" name="Nombre" type="text">
                                     </div>
                                    <div class="form-group col-md-6">
                                        <input required="required" placeholder="Ingresa tu email *" class="form-control" name="email" type="email">
                                    </div>
                                    <div class="form-group col-12">
                                        <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Agregar Comentario</button>
                                    </div>
                                    <input type="hidden" name="books_id" id="books_id" value="{{$libro->id}}">
                                {!! Form::close() !!}
                            </div>
                      	</div>
                	</div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="small_divider"></div>
            	<div class="divider"></div>
                <div class="medium_divider"></div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->
@endsection

@section('scripts')
    <script>   
        function agregar(id){
            var cantidad = $('#cantidad').val();
            // alert(cantidad)
            $.ajax({
                async:true,
                url: "{{url('agregarCarrito') }}",
                method: 'GET',
                data: {
                    cantidad: cantidad,
                    id: id,
                }
            }).done(function(result){
                alert(result)
                if(result == 'Hecho'){
                //    $('#headerNew').html(result);
                //    window.location.reload(true);
                //    window.location.href = window.location.href;
                    $("#headerNew").load(" #headerNew");
                }
            });
        }

        $(document).on("ready", function(){
            $('.star_rating span').on('click', function(){
                    var onStar = parseFloat($(this).data('value'), 10);
                    $('#Star_rating').val(onStar);
                    var stars = $(this).parent().children('.star_rating span');
                    for (var i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }
                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }
                    var si = $('#Star_rating').val();
                    // alert(si)
            });
        });

        // <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v8.0&appId=1635210993323859&autoLogAppEvents=1" nonce="sjuzPH7k"></
    </script>
@endsection