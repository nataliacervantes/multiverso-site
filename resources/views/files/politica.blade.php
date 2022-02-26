@extends('files.template')

@section('content')
    <!-- STAT SECTION FAQ --> 
<div class="section">
	<div class="container">
    	<div class="row">
        	<div class="col-12">
            	<div class="term_conditions">                    
                    <h6>POLÍTICAS DE COMPRA</h6>
                    <ul>
                        <li>Los precios, promociones y la disponibilidad de los productos están sujetos a cambio sin previo aviso, y sólo aplican para ventas en línea. Todos los precios están expresados en pesos mexicanos.</li>
                        <li>Por seguridad ofrecemos como formas de pago los módulos proporcionados por Mercado Pago, PayPal, por lo que no guardamos en nuestro servidor datos de tarjetas de crédito, debito o datos bancarios del cliente. De la misma manera nunca solicitamos que nos envíe los datos de sus tarjetas por correo electrónico.</li>
                        <li>Los pagos realizados en Mercado Pago offline o en efectivo tiene una acreditación de 24 a 48 hrs. y los pedidos son liberados hasta recibir la acreditación del pago.</li>
                    {{-- </ul> --}}
                    <hr>
                    <h6>DEVOLUCIONES</h6>
                    <p>Devoluciones dentro de los 30 días siguientes a la fecha de compra, únicamente en los siguientes casos:</p>
                    <ol>
                    	<li>Libros defectuosos.</li>
                        <li>Libros surtidos erróneamente.</li>
                    </ol>
                    <p>Una vez acreditada su devolución puede enviarla a:</p>
                        <ul>Librerías Gonvill, S,A, de C.V.

                            Sucursal Virtual
      
                            8 de Julio # 825
      
                            C.P. 44190
      
                            Guadalajara, Jal. México.
                        </ul>
                    <hr>
                    {{-- <ol> --}}
                    	<li>En el caso de libros defectuosos, al recibir su devolución le enviaremos la reposición del mismo libro sin costo de flete.</li>
                        <li>Libros surtidos erróneamente.</li>
                        <li>Garantizamos la confidencialidad/privacidad de la información personal que voluntariamente proporcione en nuestro sitio, así como la de sus pedidos.</li>
                        <li>Una vez acreditado su pago el pedido pasa a surtirse y  en la brevedad se despacha por el servicio de paquetería seleccionado.</li>
                        <li>Multiverso Libreria se esfuerza para presentar la información precisa de todo el material ofrecido dentro del sitio web no obstante nos reservamos el derecho a cancelar, parcial o totalmente algún pedido por razones como limitaciones en cantidades disponibles, imprecisiones y errores en la información del producto o precio, así como problemas identificados por nuestro departamento de crédito y prevención de fraudes. Si su pedido es cancelado después de generado su cargo, le será notificado y se procederá con el reembolso del mismo.</li>
                        <li>Multiverso Libreria podrá ejecutar modificaciones en cualquier momento o cuando lo considere conveniente, para realizar mejoras, correcciones o actividades de mantenimiento en la presentación, contenido, información o servicios. Siempre en relación a ofrecerle un mejor servicio.</li>
                        <li>Al usar nuestro sitio web y los servicios ofrecidos dentro del mismo significa que ha leído, entendido y se encuentra de acuerdo con los puntos y términos antes aquí descritos. En caso contrario deberá abstenerse de proporcionar información alguna y acceder o utilizar cualquier servicio ofrecido dentro de nuestro sitio.</li>
                        <li> Para cualquier duda, favor de contactarnos en: contacto@multiversolibreria.com  o Tel: +52 444 308 3549</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION FAQ --> 
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endsection
