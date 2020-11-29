    <!-- Home Popup Section -->
    <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                    </button>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="popup_content">
                                <div class="popup-text">
                                    <div class="heading_s3 text-center">
                                        <h4>Suscríbete!</h4>
                                    </div>
                                    <p>Suscríbete a nuestro boletín para recibir promociones exclusivas y 
                                        actualización de nuestros productos.</p>
                                </div>
                                    {!! Form::open(['url'=>'suscribirse', 'class'=>'rounded_input']) !!}
                                    <div class="form-group">
                                        <input type="text" name="Estado" required class="form-control" placeholder="Ingresa el Estado donde vives">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="Email" required class="form-control" placeholder="Ingresa tu correo electrónico">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-fill-line btn-block text-uppercase btn-radius" title="Subscribe" name="submit" value="Submit">Suscribir</button>
                                    </div>
                                    {!! Form::close() !!}
                                </form>
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="modalOff" value="">
                                        <label class="form-check-label" for="modalOff"><span>No mostrar este mensaje de nuevo!</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Screen Load Popup Section --> 
    <!-- Home Popup Section -->
{{-- <div class="modal fade subscribe_popup" style="flex-wrap: wrap" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row no-gutters">
                    <div class="col-sm-5">
                    	<div class="background_bg h-100" data-img-src="assets/images/popup_img.jpg"></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s4">
                                    <h4>Subscribe and Get 25% Discount!</h4>
                                </div>
                                <p>Subscribe to the newsletter to receive updates about new products.</p>
                            </div>
                            <form method="post">
                            	<div class="form-group">
                                	<input name="email" required type="email" class="form-control rounded-0" placeholder="Enter Your Email">
                                </div>
                                <div class="form-group">
                                	<button class="btn btn-fill-line btn-block text-uppercase rounded-0" title="Subscribe" type="submit">Subscribe</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div> --}}
<!-- End Screen Load Popup Section --> 