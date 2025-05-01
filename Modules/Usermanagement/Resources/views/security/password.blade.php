@extends("layouts.appmain")



@section('content')

 <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Change Account Login Password</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{$url}}" method="post">
                       <?=csrf_field()?>
                       <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6 form-group">
                            <label>Names</label>
                            <input type="text" name="name" class="form-control" readonly  value="{{$user->name}}">
                          </div>
                          <div class="col-md-6 form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" readonly  value="{{$user->username}}">
                          </div>
                          <div class="col-md-6 form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" readonly  value="{{$user->email}}">
                          </div>
                           <div class="col-md-6 form-group">
                            <label>Current Password</label>
                            <input type="text" name="current_password" class="form-control" required  >
                          </div>
                          <div class="col-md-6 form-group">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control"  required  >
                          </div>

                          <div class="col-md-6 form-group">
                            <label>Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required  >
                          </div>
                          
                         
                          <div class="col-md-12 form-group">
                           <button class="btn btn-primary btn-md">Complete</button>
                          </div>
                          
                        </div>
                         
                       </div>
                      

                    </form>
                   
                    
                    


                   
                  	
                    

                </div>
                
                
               


                
              </div>




            </div>
          </div>
        </section>


               

@endsection
@push('scripts')
     <script>
        
          
      
    </script>
    
@endpush