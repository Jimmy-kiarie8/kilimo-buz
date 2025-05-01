@extends("layouts.appmain")



@section('content')


 


               

@endsection
@push('scripts')
<script type="text/javascript">
  var url="<?=url('/applicant/Dashboard/GetMostRecentPosts')?>";
       $.get(url,function(data){
         $("#MyData").html(data);
       });

   var url="<?=url('/applicant/Dashboard/GetMainData')?>";

       $.get(url,function(data){
        $("#TotalAdverts").html(data.Total);
         $("#TotalApplications").html(data.MyTotal);
          $("#PendingApproval").html(data.PendingApproval);
            $("#Rejected").html(data.Rejected);


       });


        $("body").on("input","#seachTable",function(e){
          
    var value = this.value.toLowerCase().trim();

    $("table tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            var id = $(this).text().toLowerCase().trim();
            var not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            return not_found;
        });
    });


  });
</script>


@endpush