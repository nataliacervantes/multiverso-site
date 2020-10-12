@php
use Carbon\Carbon;
@endphp
@extends('files.template')

@section('content')
    <!-- START SECTION BLOG -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row blog_thumbs">
                        @foreach ($eventos as $evento)
                        <div class="col-12">
                            <div class="blog_post blog_style2">
                                <div class="blog_img">
                                    <a href="blog-single.html">
                                        <img src="assets/images/blog_small_img1.jpg" alt="blog_small_img1">
                                    </a>
                                </div>
                                <div class="blog_content bg-white">
                                    <div class="blog_text">
                                    
                                    <h6 class="blog_title"><a href="blog-single.html">{{$evento->Evento}}</a></h6>
                                        <ul class="list_none blog_meta">
                                            @php
                                                $fecha = Carbon::create($evento->Fecha);
                                            @endphp
                                            <li><a href="#"><i class="ti-calendar"></i>{{$fecha->format('d-m-Y')}}</a></li>
                                            <li><a href="#"><i class="ti-location-pin"></i>{{$evento->Lugar}}</a></li>
                                        </ul>
                                        <ul class="list_none blog_meta">
                                            <li><a href="#"><i class="ti-map-alt"></i>{{$evento->Domicilio}}</a></li>
                                            <li><a href="#"><i class="ti-money"></i>{{$evento->Costo}}</a></li>
                                        </ul>
                                        <p>Ven y conoce mi último libro</p>
                                        <ul class="list_none blog_meta" data-title="Quantity">
                                            <li><div class="quantity">
                                                <input type="button" value="-" class="minus">
                                            <input type="text" id='cantidad-{{$evento->id}}' name="quantity" value="2" title="Qty" class="qty" size="2">
                                                <input type="button" value="+" class="plus">
                                            </div></li>
                                            <li><a onclick="comprar({{$evento->id}})" style="font-size: 15px; margin-top: 5px" class="btn btn-fill-line border-1 btn-xs rounded-0">Comprar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                       @endforeach                      
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2 mt-md-4">
                            {{-- <ul class="pagination pagination_style1 justify-content-center">
                                <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"><i class="linearicons-arrow-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="linearicons-arrow-right"></i></a></li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                    <div class="sidebar">
                        <div class="widget">
                            <div class="search_form">
                                <form> 
                                    <input required="" class="form-control" placeholder="Search..." type="text">
                                    <button type="submit" title="Subscribe" class="btn icon_search" name="submit" value="Submit">
                                        <i class="ion-ios-search-strong"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget_title">Fechas</h5>
                            <ul class="widget_archive">
                                @php

                                @endphp
                                <li><a href="#"><span class="archive_year">June 2019</span><span class="archive_num">(12)</span></a></li>
                            </ul>
                        </div>
                        {{-- <div class="widget">
                            <div class="shop_banner">
                                <div class="banner_img overlay_bg_20">
                                    <img src="assets/images/sidebar_banner_img.jpg" alt="sidebar_banner_img">
                                </div> 
                                <div class="shop_bn_content2 text_white">
                                    <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                    <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                    <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget_title">tags</h5>
                            <div class="tags">
                                <a href="#">General</a>
                                <a href="#">Design</a>
                                <a href="#">jQuery</a>
                                <a href="#">Branding</a>
                                <a href="#">Modern</a>
                                <a href="#">Blog</a>
                                <a href="#">Quotes</a>
                                <a href="#">Advertisement</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BLOG -->
@endsection

@section('scripts')
    <script>
        function comprar(id){
            var cantidad = $('#cantidad-'+id).val();
            
            $.ajax({
                url: "{{url('agregarEvento') }}",
                method: 'GET',
                data: {
                    cantidad: cantidad,
                    id: id,
                }
            }).done(function(result){
                if(result == 'Hecho'){
                   alert(result)
                }
            });
        }
    </script>
@endsection