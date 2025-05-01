@extends("layouts.appmain")



@section('content')

 <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom: 1%;">
                 <a href="{{url('/System/MemberAccount/Create')}}" class="btn btn-info">Add New Member</a>

                  <a href="{{url('/System/MemberAccount/Index')}}" class="btn btn-success">List of Members</a>

                <a href="{{url('/System/MemberAccount/Import')}}" class="btn btn-danger"><span class="fa fa-import"></span>Import Members</a>
                
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Add New Member Details</h4>
                  </div>
                  <div class="card-body">
                  	 <form role="form" action="{{$url}}" method="post"  enctype="multipart/form-data">
                                                            <?=csrf_field()?>
                                          <div class="row">
                                         <div class="col-md-6">
                                           <legend>Import Instuructions</legend>
                                           <ol>
                                            <li>Ensure You are using MS Office</li>
                                             <li>Only Excel/CSV Files are allowed</li>
                                              <li>A Maximum of 3000 record per sheet are allowed</li>

                                              <li>Stick To Provided Template</li>
                                              <li>Download  Import Template 
                                                <a href="{{url('memberTemplate.xlsx')}}">Download Link</a></li>
                                           </ol>
                                          
                                        </div>
                                         <div class="col-md-6">

                                       <div class="row">
                                       
                                                <div class="form-group col-md-12">
                                        <label>VCO Name</label>
                                        <select name="org_id" class="form-control" required>
                                          <option value="">---Select Organization--</option>
                                           <?php foreach($orgs as $org):?>
                                            <option value="{{$org->id}}">{{$org->org_name}}</option>

                                           <?php endforeach;?>
                                          
                                        </select>
                                                        
                                                       
                                                                   
                                                               
                                                            </div>

                                                   
                                      </div>
                                       <div class="row">
                                                <div class="form-group col-md-12">
                                                                <label>Select File</label>
                                                        
                                                       <input type="file"
                                                                   class="form-control" name="file_name" placeholder="Ward"  required >
                                                                   
                                                               
                                                            </div>


                                                    
                                      </div>


                                       <div class="row">
                                                <div class="form-group col-md-6">
                                                    <button class="btn btn-info">Import</button>
                                                </div>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   <script>
    $("#dateRegistered").datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear:true,
          MaxDate:0,
          numberOfMonths: 1,
          yearRange: "-100:+0"
        });
  
  </script>
@endpush