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
                    <div class="d-none d-sm-none d-md-block">Este texto solo visible para escritorio</div>
                    <div class="d-block d-sm-block d-md-none">Este texto solo visible para smartphone</div>
                    {{-- <input type="text" name="Estado" required="" class="form-control rounded-0" placeholder="Estado">
                    <input type="email" name="Email" required="" class="form-control rounded-0" placeholder="Ingresa tu correo electrónico"> --}}
                    <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Subscribe</button>
                    {!! Form::close() !!}
                </div>
            </div>
           
        </div>
    </div>
</div>