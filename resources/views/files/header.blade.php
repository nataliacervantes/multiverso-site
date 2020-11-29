<!-- START HEADER -->
@php
    use App\Carrito;
    use App\Libros;  
    use App\Eventos;   
    session_start(); 
    // echo session_status();
        $carritos = Carrito::where('session_estatus',session_id())->get();
@endphp

<header id="headerNew" class="header_wrap fixed-top header_with_topbar">
	<div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                	<div class="d-flex align-items-center justify-content-center justify-content-md-start">
                       
                        <ul class="contact_detail text-center text-lg-left">
                            <li><i class="ti-mobile"></i><span>+52 444 308 3549</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                	<div class="text-center text-md-right">
                       	<ul class="header_list">
                            <!-- <li><a href="wishlist.html"><i class="ti-heart"></i><span>Wishlist</span></a></li> -->
						</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase">
    	<div class="container">
            <nav class="navbar navbar-expand-lg"> 
            <a class="navbar-brand" href="{{url('/')}}">
                    {{-- <img class="logo_light" src="images/logo-multi.png" alt="logo" /> --}}
                    <img class="logo_dark" src="{{ asset('images/logo-multi.png')}}"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false"> 
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li>
                            <a data-toggle="dropdown" class="nav-link nav_item active" href="#">Home</a>
                        </li>
                        <li >
                            <a class="nav-link nav_item" href="{{ url('catalogo')}}" >Libros</a>
                        </li>
                        <li >
                            <a class="nav-link nav_item" href="{{url('eventos')}}" >Eventos</a>
                        </li>
                        <li >
                            <a class="nav-link nav_item" href="{{url('subirFicha')}}" >Subir Ficha </a>
                        </li>
                        <li><a class="nav-link nav_item" href="contact.html">Contacto</a></li> 
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="javascript:void(0);" class="nav-link search_trigger"><i class="linearicons-magnifier"></i></a>
                        <div class="search_wrap">
                            <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                            <form>
                                <input type="text" placeholder="Search" class="form-control" id="search_input">
                                <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div><div class="search_overlay"></div>
                    </li>
                    <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#" data-toggle="dropdown"><i class="linearicons-cart"></i><span class="cart_count">{{count($carritos)}}</span></a>
                        <div class="cart_box dropdown-menu dropdown-menu-right">
                            <ul class="cart_list">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($carritos as $producto)
                                    @php
                                        $libro = Libros::find($producto->books_id);
                                        $evento = Eventos::find($producto->eventos_id);
                                        $subtotal = $producto->Subtotal;
                                        $total=$total + $subtotal;
                                        // dd($libro);
                                    @endphp
                                    @if($libro != null)
                                        <li>
                                            <a href="{{ url('eliminarLibro/'.$libro->id)}}" class="item_remove"><i class="ion-close"></i></a>
                                            <a href="{!! url('detalle/'.$libro->id) !!}"><img src="{!! url('http://127.0.0.1:8001/img/Portadas/'.$libro->Portada) !!}" alt="cart_thumb1">{{$libro->Titulo}}</a>
                                            <a href="{!! url('detalle/'.$libro->id) !!}"><span class="cart_quantity"> {{$producto->Cantidad}}x <span class="cart_amount"> <span class="price_symbole">$</span></span>{{$subtotal}}</span></a>
                                        </li>
                                    @elseif($evento != null)
                                        <li>
                                            <a href="{{ url('eliminarEvento/'.$evento->id)}}" class="item_remove"><i class="ion-close"></i></a>
                                            <a href="{!! url('detalle/'.$evento->id) !!}"><img src="{!! asset('assets/images/calendario.png') !!}" alt="cart_thumb1">{{$evento->Evento}}</a>
                                            <a href="{!! url('detalle/'.$evento->id) !!}"><span class="cart_quantity"> {{$producto->Cantidad}}x <span class="cart_amount"> <span class="price_symbole">$</span></span>{{$producto->Subtotal}}</span></a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="cart_footer">
                                <input type="hidden" name="totalHeader" id="totalHeader" value="{{$total}}" >
                            <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">$</span></span>{{number_format($total,2)}}</p>
                                <p class="cart_buttons"><a href="{{url('checkout') }}"  class="btn btn-fill-out rounded-0 checkout" style="margin-left: 160px">Ir a pagar</a></p>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- END HEADER -->
