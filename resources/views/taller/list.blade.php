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
                    @foreach ($talleres as $taller)
                    <div class="single_post">
                        <h2 class="blog_title">{{$taller->NombreTaller}}</h2>
                        <ul class="list_none blog_meta">
                            <li><a href="#"><i class="ti-calendar"></i>{{$taller->Inicio}}</a></li>
                            <li><a href="#"><i class="ti-time"></i>{{$taller->Hora}}</a></li>
                            <li><a href="#"><i class="ti-money"></i>{{$taller->Precio}}</a></li>
                        </ul>
                        <div class="blog_img">
                            <img src="{!! url('https://admin.multiversolibreria.com/img/Taller/'.$taller->Imagen) !!}" alt="blog_img1">
                        </div>
                        <div class="blog_content">
                            <div class="blog_text">
                                {{-- <blockquote class="blockquote_style3"> --}}
                                    {{-- <p>{{$taller->Descripción}}</p> --}}
                                {{-- </blockquote> --}}
                                {{-- <div class="row">
                                    <div class="col-sm-6">
                                        <div class="single_img">
                                            <img class="w-100 mb-4" src="assets/images/blog_single_img1.jpg" alt="blog_single_img1">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="single_img">
                                            <img class="w-100 mb-4" src="assets/images/blog_single_img2.jpg" alt="blog_single_img2">
                                        </div>
                                    </div>
                                </div> --}}
                                <p>{{$taller->Descripción}}</p>
                                
                                <div class="blog_post_footer">
                                    <div class="row justify-content-between align-items-center">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-xl-3 mt-4 pt-2 mt-xl-0 pt-xl-0">
                    <div class="sidebar">
                        <div class="widget">
                            <div class="search_form">
                               
                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget_title">Registrarme</h5>
                            <ul class="widget_recent_post">
                                <li>
                                    <div class="post_footer">
                                        {{-- {!! Form::open(['url'=>'comprarTaller']) !!}
                                            <button class="btn btn-warning">Comprar</button>
                                        {!! Form::close() !!} --}}
                                    </div>
                                </li>
                            </ul>
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
                url: "{{url('agregartaller') }}",
                method: 'GET',
                data: {
                    cantidad: cantidad,
                    id: id,
                }
            }).done(function(result){
                // alert(result)
                $("#headerNew").load(" #headerNew");
                swal("taller agregado", {
                    buttons: false,
                    timer: 3000,
                });
            });
        }        
    </script>
@endsection