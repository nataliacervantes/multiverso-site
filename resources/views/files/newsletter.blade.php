<!-- START SECTION SUBSCRIBE NEWSLETTER -->
<div class="section bg_default small_pt small_pb">
	<div class="container">	
    	<div class="row align-items-center">	
            <div class="col-md-6">
                <div class="heading_s1 mb-md-0 heading_light">
                    <h3>Suscríbete al boletín</h3>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="newsletter_form">
                    {!! Form::open(['url'=>'suscribirse']) !!}
                        <input type="email" name="Email" required="" class="form-control rounded-0" placeholder="Ingresa tu correo electrónico">
                        <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Suscribir</button>
                    {!! Form::close() !!}
                </div>
            </div>
           
        </div>
    </div>
</div>
<!-- START SECTION SUBSCRIBE NEWSLETTER -->
