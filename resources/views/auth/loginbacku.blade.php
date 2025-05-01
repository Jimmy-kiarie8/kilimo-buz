@extends('layouts.master')

@section('main')
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Login</li>
                    </ol>
                </div>

            </div>
        </section>
        <!-- End Breadcrumbs -->

        <section id="login" class="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">

                                <h4 style="text-align: center;">Portal Login</h4></div>

                            <div class="card-body">
                                <form method="POST" action="{{ url('login') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="uname" class="col-md-4 col-form-label text-md-right">Email/Username</label>

                                        <div class="col-md-8">
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

                                        <div class="col-md-8">
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
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-success form-control " >
                                                {{ __('Login') }}
                                            </button>


                                           
                                        </div>
                                    </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <style> footer{ position: absolute !important; } </style>


@endsection


