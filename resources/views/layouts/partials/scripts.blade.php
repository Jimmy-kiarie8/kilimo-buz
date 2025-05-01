<!--Start of Tawk.to Script-->

<!--End of Tawk.to Script-->

<div class="modal fade" id="county-modal" role="dialog">
                <div class="modal-dialog ">
                  <div class="modal-content">        

                   
                    <div class="modal-header">
                      <h4 class="modal-title" > 
                          &nbsp;&nbsp;<span id="my-header">
                      Give Reason(s)</span></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                      
                    </div>
                   
                    
                    <div class="modal-body" id="load-county-details">
                    
                    </div>               
                   
                     
                  </div>
                </div>
              </div>

<!-- Vendor JS Files -->
<script src="{{ asset('f/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('f/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('f/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>

 <script type="text/javascript" src="{{asset('bootstrapAsset/js/bootstrap.min.js')}}"></script>
  
<script src="{{ asset('f/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('f/assets/vendor/jquery-sticky/jquery.sticky.js') }}"></script>
<script src="{{ asset('f/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('f/assets/vendor/venobox/venobox.min.js') }}"></script>
<script src="{{ asset('f/assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('f/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('f/assets/vendor/aos/aos.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('f/assets/js/main.js') }}"></script>

<!-- Datatables scripts -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

     <script src="{{ asset('AdminAssets/datatables/media/js/jquery.dataTables.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js') }}"></script> 
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js') }}"></script>   
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js') }}"></script>   



    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js') }}"></script>



    <script>


          $(document).on('click','.reject-modal',function(){

           

           var head=$(this).attr('data-title');

                  
               var url=$(this).attr("data-url");
                $("#load-county-details").html("");
                $("#my-header").html(" ");
                $("#my-header").html(head);
                $("#county-modal").modal("show");
                  
            $("#load-county-details").load(url,function(data){
            $("#county-modal").modal("show");
             
          });
       });
  </script>





 @stack('scripts')