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
                                        @if(!empty($evento->Video))
                                            @php
                                                echo $evento->Video; 
                                            @endphp
                                        @endif
                                        {{-- <iframe width="394" height="266" src="https://www.youtube.com/watch?v=2I1ZU5g1QNo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                                        {{-- <img src="assets/images/blog_small_img1.jpg" alt="blog_small_img1"> --}}
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
                                            <li><a href="{{ $evento->Fanpage}}"  target="_blank"><i class="ti-location-pin"></i>{{$evento->Lugar}}</a></li>
                                        </ul>
                                        <ul class="list_none blog_meta">
                                        <li><a href="{{ $evento->Maps}}" target="_blank"><i class="ti-map-alt"></i>{{$evento->Domicilio}}</a></li>
                                            <li style="color: #FF324D; font-size: 20px; margin-top: -7px"><i class="ti-money"></i>{{$evento->Costo}}</li>
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
                                {!! Form::open(['url'=>'buscarEvento', 'method'=>'GET']) !!}
                                    <input required="" class="form-control" placeholder="Buscar Evento..." type="text" name="buscar">
                                    <button type="submit" title="Subscribe" class="btn icon_search" name="submit" value="Submit">
                                        <i class="ion-ios-search-strong"></i>
                                    </button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget_title">Fechas</h5>
                            {{-- <ul class="widget_archive">
                                <li><a href="#"><span class="archive_year">Junio</span><span class="archive_num">(12)</span></a>
                                    <ul>
                                        <li>
                                            prueba
                                        </li>
                                    </ul>
                                </li>
                            </ul> --}}
                            <div class="ui styled accordion">
                                <div class="title">
                                  <i class="dropdown icon"></i>
                                  What is a dog?
                                </div>
                                <div class="content">
                                  <p class="transition hidden">A dog is a type of domesticated animal. Known for its loyalty and faithfulness, it can be found as a welcome guest in many households across the world.</p>
                                </div>
                                <div class="title">
                                  <i class="dropdown icon"></i>
                                  What kinds of dogs are there?
                                </div>
                                <div class="content">
                                  <p class="transition hidden">There are many breeds of dogs. Each breed varies in size and temperament. Owners often select a breed of dog that they find to be compatible with their own lifestyle and desires from a companion.</p>
                                </div>
                                <div class="title active">
                                  <i class="dropdown icon"></i>
                                  How do you acquire a dog?
                                </div>
                                <div class="content active">
                                  <p class="transition visible">Three common ways for a prospective owner to acquire a dog is from pet shops, private owners, or shelters.</p>
                                  <p class="transition visible">A pet shop may be the most convenient way to buy a dog. Buying a dog from a private owner allows you to assess the pedigree and upbringing of your dog before choosing to take it home. Lastly, finding your dog from a shelter, helps give a good home to a dog who may not find one so readily.</p>
                                </div>
                              </div>
                        </div>
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
                // alert(result)
                $("#headerNew").load(" #headerNew");
            });
        }
    </script>
@endsection