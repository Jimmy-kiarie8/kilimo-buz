@extends("layouts.appmain")



@section('content')

 <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>VCO Basic Details</h4>
                  </div>
                  <div class="card-body">
                  	<form action="{{$url}}" method="post">
                       <?=csrf_field()?>
                    <div class="row">

                  

                       	<div class="form-group col-md-4">
                      <label>VCO Name</label>
                      <input type="text" name="org_name" required="required" value="{{$model->org_name}}" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Email Address</label>
                      <input type="email" name="org_email" required value="{{$model->org_email}}" class="form-control">
                    </div>


                    <div class="form-group col-md-4">
                      <label>VCO Number</label>
                      <input type="text" name="org_number" class="form-control" value="{{$model->org_number}}" readonly>
                    </div>
                 </div>

                  <div class="row">
                        <div class="form-group col-md-4">
                      <label>Date Registered</label>
                      <input type="text" name="date_registered" required="required" value="{{$model->date_registered}}" class="form-control" id="dateRegistered">
                    </div>

                   
                     


                    <div class="form-group col-md-4">
                      <label>Postal address</label>
                      <input type="text" name="box_address" class="form-control" value="{{$model->box_address}}" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Postal Code</label>
                      <input type="text" name="postal_address" class="form-control" value="{{$model->postal_address}}" required>
                    </div>
                 </div>

                  <div class="row">
                   

                    <div class="form-group col-md-4">
                              

                                <label>County</label>
                                {{ Form::select('county_id',([null=>'--Select County--'] + $counties), $model->county_id, ['class'=>'form-control','required'=>'required','id'=>'county','style'=>'width:100%']) }}
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sub County</label>
                                {{ Form::select('sub_county_id',([null=>'--Select Sub County--'] +$subcounties), $model->sub_county_id, ['class'=>'form-control','required'=>'required','id'=>'subCounty','style'=>'width:100%']) }}
                                
                            </div>

                            <div class="form-group col-md-4">
                                <label>Ward</label>
                                <input type="text" class="form-control"  value="{{$model->ward_name}}" name="ward_name" required>
                                
                            </div>
                             <div class="form-group col-md-4">
                                <label>Contact Name</label>
                                <input type="text" class="form-control"  value="{{$model->contact_name}}" name="contact_name" required>
                                
                            </div>
                         
                             <div class="form-group col-md-4">
                                <label>Telephone</label>
                                <input type="text" class="form-control"  value="{{$model->org_tephone}}" name="org_tephone" required>
                                
                            </div>
                           

                             <div class="form-group col-md-4">
                                <label>Alt Telephone</label>
                                <input type="text" class="form-control"  value="{{$model->alt_telephone}}" name="alt_telephone" required>
                                
                            </div>

                             <div class="form-group col-md-6">
                                <label>Villege/Physical Address</label>
                                <input type="text" class="form-control"  value="{{$model->physical_address}}" name="physical_address" required>
                                
                            </div>


                            <div class="form-group col-md-6">
                                <label>Nearest Landmark(e.g School,Market,Heaith Facility,Church)</label>
                                <input type="text" class="form-control"  value="{{$model->landmark}}" name="landmark" required>
                                
                            </div>
                         </div>
                  		
                    
                  <div class="card-footer text-right">
                    <button class="btn btn-success mr-1" type="submit">Submit</button>
                   
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
          numberOfMonths: 1
        });
  
  </script>
@endpush