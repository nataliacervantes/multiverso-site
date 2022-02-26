<!-- START FOOTER -->
<footer class="footer_dark">
    <div class="footer_top">
        <a  id="app-whatsapp" target="_blank" href="https://api.whatsapp.com/send?phone=+5214443083549&text=Hola!%20quiero%20%20alimentarte">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-md-0 text-center text-md-left"  style="color: white">© 2021 Todos los derechos reservados por Multiversolibreria</p>
                </div>
                <div class="col-md-6">
                    <ul class="footer_payment text-center text-lg-right">
                        <li><a href="{{ url('politicas_envio')}}" style="color: white">Política de Envío</a></li>
                        <li><a href="{{ url('terminos_condiciones')}}" style="color: white">Términos de Servicios</a></li>
                        {{-- <li><a href="#"><img src="assets/images/discover.png" alt="discover"></a></li>
                        <li><a href="#"><img src="assets/images/master_card.png" alt="master_card"></a></li>
                        <li><a href="#"><img src="assets/images/paypal.png" alt="paypal"></a></li>
                        <li><a href="#"><img src="assets/images/amarican_express.png" alt="amarican_express"></a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Your Chat Plugin code -->
    {{-- <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-md-0 text-center text-md-left">© 2020 Todos los derechos reservados por Multiverso</p>
                </div>
                <div class="col-md-6">
                    <ul class="footer_payment text-center text-lg-right">
                        <li><a href="#"><img src="assets/images/visa.png" alt="visa"></a></li>
                        <li><a href="#"><img src="assets/images/discover.png" alt="discover"></a></li>
                        <li><a href="#"><img src="assets/images/master_card.png" alt="master_card"></a></li>
                        <li><a href="#"><img src="assets/images/paypal.png" alt="paypal"></a></li>
                        <li><a href="#"><img src="assets/images/amarican_express.png" alt="amarican_express"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
</footer>
<!-- END FOOTER -->
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v9.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-customerchat"
    attribution=setup_tool
    page_id="447165475453303"
    theme_color="#0A7CFF"
    greeting_dialog_display="fade"
    logged_in_greeting="Hola! ¿Cómo puedo ayudarte?"
    logged_out_greeting="Hola! ¿Cómo puedo ayudarte?">
</div>
