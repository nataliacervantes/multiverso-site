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
                        {{-- <div class="d-none d-sm-none d-md-block">Este texto solo visible para escritorio</div>
                        <div class="d-block d-sm-block d-md-none">Este texto solo visible para smartphone</div> --}}
                        <div style="display: flex; background-color: white; flex-wrap: wrap">
                        <div style="display: flex; flex-direction: column; flex: 4 1 200px">
                        <input type="text" name="Estado" required="" class="form-control rounded-0" placeholder="Estado" style="border: 0px">
                        <input type="email" name="Email" required="" class="form-control rounded-0" placeholder="Ingresa tu correo electrónico" style="border: 0px">
                        </div>
                        <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit" style="flex: 1 1; margin: 5px;">Suscríbete</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
