@extends('front.main')

<?php 
use Modules\Usermanagement\Entities\County;

$counties=County::orderBy('county_name')->get();
  
?>

@section('content')

<!-- BEGIN search-results -->


        <div id="search-results" class="section-container bg-silver">

          
               
            <!-- BEGIN container -->
            <div class="container">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 offset-md-2">
                       <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card"  >
                            <div class="card-header">

                                <h4 style="text-align: center;">Create A Buyer Account</h4></div>

                            <div class="card-body">
                                <form method="POST" action="{{ url('register') }}">
                                    @csrf




       @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                                    <div class="row">

                                          <div class="form-group col-md-6">

                                        <label for="uname" class="col-md-12 col-form-label text-md-right">Email Address</label>

                                        <div class="col-md-12 form-group">
                                           <input type="email" id="email" type="email" class="form-control" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="Enter Email Address">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>


                                     <div class="form-group col-md-6">

                                        <label for="name" class="col-md-12 col-form-label text-md-right">Names</label>

                                        <div class="col-md-12 form-group">
                                           
                                            <input type="text"  type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus placeholder="Enter Full Names">

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                        

                                    </div>




                                    <div class="row">

                                          <div class="form-group col-md-6">

                                        <label for="uname" class="col-md-12 col-form-label text-md-right">Telephone</label>

                                        <div class="col-md-12 form-group">
                                           <input type="text" id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  autocomplete="phone" autofocus placeholder="Mobile Number">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>


                                     <div class="form-group col-md-6">

                                        <label for="name" class="col-md-12 col-form-label text-md-right">County of Residence</label>

                                        <div class="col-md-12 form-group">
                                            <select class="form-control"  name="county_id"  required>
                                                <option value="">---Select County----</option>  
                                                   <?php foreach($counties as $county):?>
                                                    <option value="{{$county->id}}">{{$county->county_name}}</option>


                                                  <?php endforeach;?>
                                                
                                            </select>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                        

                                    </div>

                                      <div class="row">

                                          <div class="form-group col-md-6">

                                        <label for="uname" class="col-md-12 col-form-label text-md-right">Password</label>

                                        <div class="col-md-12 form-group">
                                         <input  id="password" type="password" class="form-control" @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" placeholder="Password">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>


                                     <div class="form-group col-md-6">

                                        <label for="name" class="col-md-12 col-form-label text-md-right">Confirm Password</label>

                                        <div class="col-md-12 form-group">

                                              <input id="password-confirm" type="password" class="form-control"   @error('confirm_password') is-invalid @enderror"    name="password_confirmation" = autocomplete="new-password" placeholder="Confirm Password" autofocus>


                                       

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                        

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                              <div class="col-md-12">
                                            <input type="checkbox" name="confirmation" required>I have Read and I agree with terms and conditions of Use.
                                        </div>

                                        </div>
                                        <div class="col-md-12">
                                              <div class="col-md-6">
                                            <button type="submit" class="btn btn-success "  >
                                                {{ __('Create Account') }}
                                            </button>
                                        </div>
                                            
                                        </div>

                                       



                                    </div>



                                  
                                    

                                  


                                 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                        
                    </div>
                    

                </div>



              


                
          
            
            </div>
            <!-- END container -->
        </div>
        <!-- END search-results -->
@endsection