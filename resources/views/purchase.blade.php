@extends('layouts.app') 

@section('content')
<section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Forms Wizard
                          </header>
                          <div class="panel-body">
                              <div class="stepy-tab">
                                  <ul id="default-titles" class="stepy-titles clearfix">
                                      <li id="default-title-0" class="current-step">
                                          <div>Step 1</div>
                                      </li>
                                      <li id="default-title-1" class="">
                                          <div>Step 2</div>
                                      </li>
                                      <li id="default-title-2" class="">
                                          <div>Step 3</div>
                                      </li>
                                  </ul>
                              </div>
                              <form class="form-horizontal" id="default">
                                  <fieldset title="Step1" class="step" id="default-step-0">
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Full Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Full Name">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Email Address</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Email Address">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">User Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Username">
                                          </div>
                                      </div>

                                  </fieldset>
                                  <fieldset title="Step 2" class="step" id="default-step-1" >
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Phone</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Phone">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Mobile</label>
                                          <div class="col-lg-10">
                                              <input type="text" class="form-control" placeholder="Mobile">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Address</label>
                                          <div class="col-lg-10">
                                              <textarea class="form-control" cols="60" rows="5"></textarea>
                                          </div>
                                      </div>

                                  </fieldset>
                                  <fieldset title="Step 3" class="step" id="default-step-2" >
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Full Name</label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static">Tawseef Ahmed</p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Email Address</label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static">tawseef@vectorlab.com</p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">User Name</label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static">tawseef</p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Phone</label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static">01234567</p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Mobile</label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static">01234567</p>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Address</label>
                                          <div class="col-lg-10">
                                              <p class="form-control-static">
                                                  Dreamland Ave, Suite 73
                                                  AU, PC 1361
                                                  P: (123) 456-7891 </p>
                                          </div>
                                      </div>
                                  </fieldset>
                                  <input type="submit" class="finish btn btn-danger" value="Finish"/>
                              </form>
                          </div>
                      </section>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <!--progress bar start-->
                      <section class="panel">
                          <header class="panel-heading">
                              Wizard with Validation
                          </header>
                          <div class="panel-body">
                              <form id="wizard-validation-form" action="#">
                                  <div>
                                      <h3>Step 1</h3>
                                      <section>
                                          <div class="form-group clearfix">
                                              <label class="col-lg-2 control-label " for="userName">User name </label>
                                              <div class="col-lg-10">
                                                  <input class="form-control" id="userName" name="userName" type="text" class="required">

                                              </div>
                                          </div>
                                          <div class="form-group clearfix">
                                              <label class="col-lg-2 control-label " for="password"> Password *</label>
                                              <div class="col-lg-10">
                                                  <input id="password" name="password" type="text" class="required form-control">

                                              </div>
                                          </div>

                                          <div class="form-group clearfix">
                                              <label class="col-lg-2 control-label " for="confirm">Confirm Password *</label>
                                              <div class="col-lg-10">
                                                  <input id="confirm" name="confirm" type="text" class="required form-control">
                                              </div>
                                          </div>
                                          <div class="form-group clearfix">
                                              <label class="col-lg-12 control-label ">(*) Mandatory</label>
                                          </div>
                                      </section>
                                      <h3>Step 2</h3>
                                      <section>

                                          <div class="form-group clearfix">
                                              <label class="col-lg-2 control-label" for="name"> First name *</label>
                                              <div class="col-lg-10">
                                                  <input id="name" name="name" type="text" class="required form-control">
                                              </div>
                                          </div>
                                          <div class="form-group clearfix">
                                              <label class="col-lg-2 control-label " for="surname"> Last name *</label>
                                              <div class="col-lg-10">
                                                  <input id="surname" name="surname" type="text" class="required form-control">

                                              </div>
                                          </div>

                                          <div class="form-group clearfix">
                                              <label class="col-lg-2 control-label " for="email">Email *</label>
                                              <div class="col-lg-10">
                                                  <input id="email" name="email" type="text" class="required email form-control">
                                              </div>
                                          </div>

                                          <div class="form-group clearfix">
                                              <label class="col-lg-2 control-label " for="address">Address </label>
                                              <div class="col-lg-10">
                                                  <input id="address" name="address" type="text" class="form-control">
                                              </div>
                                          </div>

                                          <div class="form-group clearfix">
                                              <label class="col-lg-12 control-label ">(*) Mandatory</label>
                                          </div>

                                      </section>
                                      <h3>Step 3</h3>
                                      <section>
                                          <div class="form-group clearfix">
                                              <div class="col-lg-12">
                                                  <ul class="list-unstyled w-list">
                                                      <li>First Name : Mosaddek </li>
                                                      <li>Last Name : Hossain </li>
                                                      <li>Emial: dkmosa@gmail.com</li>
                                                      <li>Address: 123 Dream City, Dreamland. </li>
                                                  </ul>
                                              </div>
                                          </div>
                                      </section>
                                      <h3>Step Final</h3>
                                      <section>
                                          <div class="form-group clearfix">
                                              <div class="col-lg-12">
                                                  <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required">
                                                  <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                                              </div>
                                          </div>

                                      </section>
                                  </div>
                              </form>
                          </div>
                      </section>


                  </div>


              </div>
              <!-- page end-->
          </section>
      </section>
@endsection 

@section('script')

<script src="{{ asset('js/jquery.steps.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.stepy.js')}}"></script>
<script>

      //step wizard

      $(function() {
          $('#default').stepy({
              backLabel: 'Previous',
              block: true,
              nextLabel: 'Next',
              titleClick: true,
              titleTarget: '.stepy-tab'
          });
      });
  </script>

  <script type="text/javascript">
      $(document).ready(function () {
          var form = $("#wizard-validation-form");
          form.validate({
              errorPlacement: function errorPlacement(error, element) {
                  element.after(error);
              }
          });
          form.children("div").steps({
              headerTag: "h3",
              bodyTag: "section",
              transitionEffect: "slideLeft",
              onStepChanging: function (event, currentIndex, newIndex) {
                  form.validate().settings.ignore = ":disabled,:hidden";
                  return form.valid();
              },
              onFinishing: function (event, currentIndex) {
                  form.validate().settings.ignore = ":disabled";
                  return form.valid();
              },
              onFinished: function (event, currentIndex) {
                  alert("Submitted!");
              }
          });


      });
  </script>
@endsection