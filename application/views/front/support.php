
                  <!-- Banner/Slider -->
                  <div class="page-head section row-vm light">
                        <div class="imagebg">
                              <img src="<?=base_url();?>web/images/page-inside-bg.jpg" alt="page-head">
                        </div>
                        <div class="container">
                              <div class="row text-center">
                                    <div class="col-md-12">
                                          <h2><?=ucwords(strtolower($page_title));?></h2>
                                          <div class="page-breadcrumb">
                                                <ul class="breadcrumb">
                                                      <li><a href="index.html">Home</a></li>
                                                      <li class="active"><span><?=ucwords(strtolower($page_title));?></span></li>
                                                </ul>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                 
      
            <!-- Section -->
            <div class="section section-pad">
                  <div class="container">
                        <div class="row">
                              <div class="col-md-8 res-m-bttm">
                                    <div class="contact-information">
                                          <h4>Contact Information</h4>
                                          <div class="row">
                                                <div class="col-sm-4 res-m-bttm">
                                                      <div class="contact-entry">
                                                            <h6>Crypto<span>Coin</span></h6>
                                                            <p><?=settings('address');?></p>
                                                      </div>
                                                </div>
                                                <div class="col-sm-4 res-m-bttm">
                                                      <div class="contact-entry">
                                                            <h6>contact number</h6>
                                                            <p>phone:  <?=settings('phone');?></p>
                                                      </div>
                                                </div>
                                                <div class="col-sm-4 res-m-bttm">
                                                      <div class="contact-entry">
                                                            <h6>office hours</h6>
                                                            <p>Monday - Friday<br/>8:30am - 6:00pm</p>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="contact-form">
                                          <p>Complete and submit the form below</p>
                                          <form id="contact-form" class="form-message" action="form/contact.php" method="post">
                                                <div class="form-results"></div>
                                                <div class="form-group row">
                                                      <div class="form-field col-sm-6 form-m-bttm">
                                                            <input name="contact-name" type="text" placeholder="Full Name *" class="form-control required">
                                                      </div>
                                                      <div class="form-field col-sm-6">
                                                            <input name="contact-email" type="email" placeholder="Email *" class="form-control required email">
                                                      </div>
                                                </div>
                                                <div class="form-group row">
                                                      <div class="form-field col-sm-6 form-m-bttm">
                                                            <input name="contact-phone" type="text" placeholder="Phone Number *" class="form-control required">
                                                      </div>
                                                      <div class="form-field col-sm-6">
                                                            <input name="contact-subject" type="text" placeholder="Subject *" class="form-control required">
                                                      </div>
                                                </div>
                                                <div class="form-group row">
                                                      <div class="form-field col-md-12">
                                                            <textarea name="contact-message" placeholder="Messages *" class="txtarea form-control required"></textarea>
                                                      </div>
                                                </div>
                                                <input type="text" class="hidden" name="form-anti-honeypot" value="">
                                                <button type="submit" class="btn btn-alt">Submit</button>
                                          </form>
                                    </div>
                              </div><!-- .col  -->
                              <div class="col-md-4">
                                    <div id="gMap" class="google-map"></div>
                                    <a href="#" class="map-link">View on google map <span class="fa fa-caret-right"></span></a>
                              </div><!-- .col  -->
                        </div>
                  </div>      
            </div>
            <!-- End Section -->
            
        
