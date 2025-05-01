@extends('front.main')



@section('content')

<!-- BEGIN search-results -->


        <div id="search-results" class="section-container bg-silver">

          
               
            <!-- BEGIN container -->
            <div class="container">

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 offset-md-3">
                       <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card"  >
                            <div class="card-header">

                                <h4 style="text-align: center;">Portal Backend Login</h4></div>

                            <div class="card-body">
                                <form method="POST" action="{{ url('login') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="uname" class="col-md-4 col-form-label text-md-right">Email Address</label>

                                        <div class="col-md-12 form-group">
                                            <input id="uname" type="text"
                                                   class="form-control @error('uname') is-invalid @enderror"
                                                   name="email"
                                                   value="{{ old('uname') }}" required autocomplete="uname" autofocus
                                                   onfocusout="checkLocked(id)">

                                            @error('uname')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    

                                    <div class="form-group row">
                                        <label for="password"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-12 form-group">
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group row mb-0">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success form-control  "  style="width: 100%;">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row " style="margin-top:1.5%;">
                                        <div class="col-md-12">
                                              <a href="{{url('/register')}}" class="btn  btn-danger   form-control">Register As A Buyer</a>
                                         
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