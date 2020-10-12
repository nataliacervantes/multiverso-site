@extends('files.template')

@section('content')
<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
		<div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
              <div class="product-image">
                    <div class="product_img_box">
                        <img id="product_img" src='{!! url('http://127.0.0.1:8001/img/Portadas/'.$libro->Imagenes) !!}' data-zoom-image="assets/images/product_zoom_img1.jpg" alt="product_img1" />
                        <a href="{!! url('http://127.0.0.1:8001/img/Portadas/'.$libro->Imagenes) !!}" class="product_img_zoom" title="Zoom">
                            <span class="linearicons-zoom-in"></span>
                        </a>
                    </div>
                    {{-- <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                        <div class="item">
                            <a href="#" class="product_gallery_item active" data-image="assets/images/product_img1.jpg" data-zoom-image="assets/images/product_zoom_img1.jpg">
                                <img src="assets/images/product_small_img1.jpg" alt="product_small_img1" />
                            </a>
                        </div>
                        <div class="item">
                            <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-2.jpg" data-zoom-image="assets/images/product_zoom_img2.jpg">
                                <img src="assets/images/product_small_img2.jpg" alt="product_small_img2" />
                            </a>
                        </div>
                        <div class="item">
                            <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-3.jpg" data-zoom-image="assets/images/product_zoom_img3.jpg">
                                <img src="assets/images/product_small_img3.jpg" alt="product_small_img3" />
                            </a>
                        </div>
                        <div class="item">
                            <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-4.jpg" data-zoom-image="assets/images/product_zoom_img4.jpg">
                                <img src="assets/images/product_small_img4.jpg" alt="product_small_img4" />
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <h4 class="product_title"><a href="{!! url('detalle/'.$libro->id) !!}">{{$libro->Titulo}}</a></h4>
                            <div class="product_price">
                                <span class="price">$ {{number_format($libro->Precio,2)}}</span>
                            </div>
                            <div class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:{{ (100/5)*round($promedio) }}%"></div>
                                </div>
                                <span class="rating_num">({{count($comentarios)}})</span>
                            </div>
                            <div class="pr_desc">
                                <p>{{$libro->Descripcion}}</p>
                            </div>
                    </div>
                    <hr />
                    <div class="cart_extra">
                        <div class="cart-product-quantity">
                            <div class="quantity">
                                <input type="button" value="-" class="minus" id="menos">
                                <input type="text" name="quantity" id="cantidad" value="1" title="Qty" class="qty" size="4">
                                <input type="button" value="+" id="mas" class="plus">
                            </div>
                        </div>
                        <div class="cart_btn">
                                <a  class="btn btn-fill-out btn-addtocart" onclick="agregar({{$libro->id}});" style="color:aliceblue" id="productoId" value="{{$libro->id}}">
                                <i class="icon-basket-loaded"></i>Agregar al carrito</a>
                            {{-- <a class="add_compare" href="#"><i class="icon-shuffle"></i></a> --}}
                            <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                        </div>
                    </div>
                    <hr />
                    {{-- <ul class="product-meta">
                        <li>SKU: <a href="#">BE45VGRT</a></li>
                        <li>Category: <a href="#">Clothing</a></li>
                        <li>Tags: <a href="#" rel="tag">Cloth</a>, <a href="#" rel="tag">printed</a> </li>
                    </ul> --}}
                    <div class="product_share">
                        <span>Compartir:</span>
                        <ul class="social_icons">
                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
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
						<li class="nav-item">
							<a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Descripción</a>
                      	</li>
                      	{{-- <li class="nav-item">
                        	<a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Additional info</a>
                      	</li> --}}
                      	<li class="nav-item">
                        	<a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Comentarios</a>
                      	</li>
                    </ul>
                	<div class="tab-content shop_info_tab">
                      	<div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                        	<p>{{$libro->Descripcion}}</p>
                      	</div>
                      	{{-- <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                        	<table class="table table-bordered">
                            	<tr>
                                	<td>Capacity</td>
                                	<td>5 Kg</td>
                            	</tr>
                                <tr>
                                    <td>Color</td>
                                    <td>Black, Brown, Red,</td>
                                </tr>
                                <tr>
                                    <td>Water Resistant</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>Material</td>
                                    <td>Artificial Leather</td>
                                </tr>
                        	</table>
                      	</div> --}}
                      	<div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                        	<div class="comments">
                            	<h5 class="product_tab_title">X Comentarios para <span>{{$libro->Titulo}}</span></h5>
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
                                        <textarea required="required" placeholder="Tu comentario *" resize="none" class="form-control" name="Comentario" rows="4"></textarea>
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
        {{-- <div class="row">
        	<div class="col-12">
            	<div class="heading_s1">
                	<h3>Releted Products</h3>
                </div>
            	<div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                	<div class="item">
                        <div class="product">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="assets/images/product_img1.jpg" alt="product_img1">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                        <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="//bestwebcreator.com/shopping-zone/demo/shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">Blue Dress For Woman</a></h6>
                                <div class="product_price">
                                    <span class="price">$45.00</span>
                                    <del>$55.25</del>
                                    <div class="on_sale">
                                        <span>35% Off</span>
                                    </div>
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
                                <div class="pr_switch_wrap">
                                    <div class="product_color_switch">
                                        <span class="active" data-color="#87554B"></span>
                                        <span data-color="#333333"></span>
                                        <span data-color="#DA323F"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="assets/images/product_img2.jpg" alt="product_img2">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                        <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="//bestwebcreator.com/shopping-zone/demo/shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">Lether Gray Tuxedo</a></h6>
                                <div class="product_price">
                                    <span class="price">$55.00</span>
                                    <del>$95.00</del>
                                    <div class="on_sale">
                                        <span>25% Off</span>
                                    </div>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:68%"></div>
                                    </div>
                                    <span class="rating_num">(15)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="pr_switch_wrap">
                                    <div class="product_color_switch">
                                        <span class="active" data-color="#847764"></span>
                                        <span data-color="#0393B5"></span>
                                        <span data-color="#DA323F"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product">
                            <span class="pr_flash">New</span>
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="assets/images/product_img3.jpg" alt="product_img3">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                        <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="//bestwebcreator.com/shopping-zone/demo/shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">woman full sliv dress</a></h6>
                                <div class="product_price">
                                    <span class="price">$68.00</span>
                                    <del>$99.00</del>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:87%"></div>
                                    </div>
                                    <span class="rating_num">(25)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="pr_switch_wrap">
                                    <div class="product_color_switch">
                                        <span class="active" data-color="#333333"></span>
                                        <span data-color="#7C502F"></span>
                                        <span data-color="#2F366C"></span>
                                        <span data-color="#874A3D"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="assets/images/product_img4.jpg" alt="product_img4">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                        <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="//bestwebcreator.com/shopping-zone/demo/shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">light blue Shirt</a></h6>
                                <div class="product_price">
                                    <span class="price">$69.00</span>
                                    <del>$89.00</del>
                                    <div class="on_sale">
                                        <span>20% Off</span>
                                    </div>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:70%"></div>
                                    </div>
                                    <span class="rating_num">(22)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="pr_switch_wrap">
                                    <div class="product_color_switch">
                                        <span class="active" data-color="#333333"></span>
                                        <span data-color="#A92534"></span>
                                        <span data-color="#B9C2DF"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="assets/images/product_img5.jpg" alt="product_img5">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                        <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="//bestwebcreator.com/shopping-zone/demo/shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">blue dress for woman</a></h6>
                                <div class="product_price">
                                    <span class="price">$45.00</span>
                                    <del>$55.25</del>
                                    <div class="on_sale">
                                        <span>35% Off</span>
                                    </div>
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
                                <div class="pr_switch_wrap">
                                    <div class="product_color_switch">
                                        <span class="active" data-color="#87554B"></span>
                                        <span data-color="#333333"></span>
                                        <span data-color="#5FB7D4"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<!-- END SECTION SHOP -->
@endsection

@section('scripts')
    <script>   

        function agregar(id){
            var cantidad =  $('#cantidad').val();

            $.ajax({
                url: "{{url('agregarCarrito') }}",
                method: 'GET',
                data: {
                    cantidad: cantidad,
                    id: id,
                }
            }).done(function(result){
                if(result == 'Hecho'){
                   
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
    </script>
@endsection