<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Editorial 100% mexicana creada por José de la Serna.">
    <meta name="keywords" content="libros, libros, José de la Serna, José, Serna, Jose de la Serna, editorial">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@500&display=swap" rel="stylesheet"> 
   
    <!-- SITE TITLE -->
    <title>Multiverso Films</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/logo-multi.png">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">	
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <!-- Google Font -->
    <link href="{{asset('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap')}}" rel="stylesheet"> 
    <link href="{{asset('https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap')}}" rel="stylesheet"> 
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/linearicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/simple-line-icons.css')}}">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{asset('assets/owlcarousel/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/owlcarousel/css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{asset('assets/owlcarousel/css/owl.theme.default.min.css')}}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- jquery-ui CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/slick-theme.css')}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    {{-- <style>
        body {
          font-family: Arial, Helvetica, sans-serif;
        }
        
        .flip-card {
          background-color: transparent;
          width: 300px;
          height: 300px;
          perspective: 1000px;
        }
        
        .flip-card-inner {
          position: relative;
          width: 200px;
          height: 450px;
          text-align: center;
          transition: transform 0.6s;
          transform-style: preserve-3d;
          box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        
        .flip-card:hover .flip-card-inner {
          transform: rotateY(180deg);
        }
        
        .flip-card-front, .flip-card-back {
          position: absolute;
          width: 100%;
          height: 100%;
          -webkit-backface-visibility: hidden;
          backface-visibility: hidden;
        }
        
        .flip-card-front {
          background-color: black;
          color: black;
        }
        
        .flip-card-back {
          background-color: #2980b9;
          color: white;
          transform: rotateY(180deg);
        }
        </style> --}}
</head>
{{-- <div  id="card-{{$libro->id}}"style="height: 400px;">
    <div class="front"> 
        <a >
            <img src="{!! url('https://admin.multiversolibreria.com/img/Portadas/'.$libro->Portada) !!}" width="100px">
            {{-- <img src="{!! url('https://admin.multiversolibreria.com/img/Portadas/'.$libro->Contraportada) !!}" width="100px"> --}}
        {{-- </a>
    </div> 
    <div class="back">
        Back content
    </div>                                             
    <div class="product_action_box">
        <ul class="list_none pr_action_btn">
            <li class="add-to-cart"><a onclick="agregar({{$libro->id}});" id="productoId" value="{{$libro->id}}"><i class="icon-basket-loaded"></i> Agregar al carrito</a></li>
            {{-- <li><a href="{{ asset('images/depositofaltantes.mp4')}}" data-toggle="modal" data-target="#exampleModal" type="button"><i class="icon-magnifier-add"></i></a></li> --}}
            <!-- <li><a href="#"><i class="icon-heart"></i></a></li> -->
            {{-- <li><a type="button" onclick="flip({{$libro->id}});"><i class="icon-magnifier-add"></i></a></li>
        </ul>
    </div>
</div>
function flip(id){
    $('#card-'+id).flip({
        axis: 'y'
    })
} --}} 