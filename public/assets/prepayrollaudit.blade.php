@extends("usermanagement::layouts.master")
@section('breadcrums')
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title" style="color:white;"><?= @$page_title ?></h4>
        </div>
    </div>
@stop
@section('content')
    <br>
    <div class="col-md-12">
        <div class="card">
            <div id="cardCollpase4" class="collapse show">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-10" style="border-style:double;">
                                <legend style="color:purple;font-size: 22px; font-weight: bold;text-align: center;">Active Work Bench</legend>
                                <div class="row">
                                </div>
                                <div class="col-md-12">
                                    <div class="row" id="WorkBench" >
                                        <div id="DefaultData" >
                                            <h4 style="margin: 10%;margin-left: 40%;font-weight: normal;color:silver;">No Active  Job/Task Available </h4>
                                        </div>
                                        <div id="ServiceCategoryPanel" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Monthly Change Log Analytics/Summary</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="Categories">
                                                        <div class="col-md-6">
                                                            <legend> <h5  style="color:purple;text-align: center;">Staff Register Updates</h5></legend>
                                                            <div class="row" >
                                                                <div class="table-responsive"  id="StaffRegisterSummary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend> <h5  style="color:purple;text-align: center;">Earnings Summary</h5></legend>
                                                            <div class="row">
                                                                <div class="table-responsive" id="IndividualSummary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend> <h5  style="color:purple;text-align: center;">Arrears Summary</h5></legend>
                                                            <div class="row">
                                                                <div class="table-responsive"  id="ArrearsSummary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend> <h5  style="color:purple;text-align: center;">Third Party Summary</h5></legend>
                                                            <div class="row">
                                                                <div class="table-responsive"  id="ThirdParySummary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend> <h5  style="color:purple;text-align: center;">Departmental Deduction Summary</h5></legend>
                                                            <div class="row">
                                                                <div class="table-responsive"  id="DepartmentalSummary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend> <h5  style="color:purple;text-align: center;">Entries and Exits Summary</h5></legend>
                                                            <div class="row">
                                                                <div class="table-responsive"  id="EntryExitSummary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend> <h5  style="color:purple;text-align: center;">Exception and Excemption Summary</h5></legend>
                                                            <div class="row">
                                                                <div class="table-responsive"  id="ExceptionandExcemptionSummary">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!---Statutoy Deductions Pane;l-->
                                        <div id="StatutoyData" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Track Staff Register Changes For The Month of {{date('Ym')}}</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="StatutoryContentContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ThirdPartyData" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Institution Types</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="InstitutionTypeContentContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="EarningsData" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Earnings Changes Log</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="SourceOfFundingContentContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="DepartmentalDeductionsData" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Departmental Deductions Changes</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="DepartmentalDeductionsContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="RegistrationBodies" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Registration Bodies</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="RegistrationBodiesContentContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="RegistrationTypes" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Generate Exceptions and Excemption Change log</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="RegistrationTypesContentContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="TermsOfEngagements" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Generate Arrears Change Log/Pre-Payroll Audits</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="TermsOfEngagementsContentContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="StaffTitles" class="d-none" >
                                            <div class="col-md-12" style="border:double;color:black;">
                                                <legend style="font-size: 18px; font-weight: bold;text-align: center;color:silver">Third Party Deduction Changelogs</legend>
                                                <div class="col-md-12">
                                                    <div class="row" id="StaffTitlesContentContent">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!---User Action--->
                            <div class="col-md-2" style="border:1px dashed gray;">
                                <h4 style="text-align: center;">Actions</h4>
                                <button style="margin-top:2%;"  class="btn btn-xs btn-info workbenchmanager form-control" data-targetclass="ServiceCategories">Dashboard Analytics</button>
                                <button style="margin-top:2%;"  class="btn btn-xs btn-info workbenchmanager form-control" data-targetclass="ServiceSubCategories">Staff Register</button>
                                <button style="margin-top:2%;"  class="btn btn-xs btn-info workbenchmanager form-control" data-targetclass="DepartmentalChangelog">Departmental Changelog</button>
                               
                                <button style="margin-top:2%;"  class="btn btn-xs btn-info workbenchmanager form-control" data-targetclass="SourceOfFunding">Earnings Changelog</button>
                                <button style="margin-top:2%;"  class="btn btn-xs btn-info workbenchmanager form-control" data-targetclass="TermsOfEngagements">Arrears Changelog</button>
                                <button style="margin-top:2%;"  class="btn btn-xs btn-info workbenchmanager form-control" data-targetclass="StaffTitles">Third Parties Changelog</button>


                                 <button style="margin-top:2%;"  class="btn btn-xs btn-info workbenchmanager form-control" data-targetclass="RegistrationType">Exception & Exemption</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end card-->
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $("body").on("click",".workbenchmanager",function(e){
            e.preventDefault();

            var value=$(this).attr("data-targetclass");
            drawShape(value);

        })

        function drawShape(tabname)
        {
            if(tabname==="ServiceCategories")
            {
                $("#ServiceCategoryPanel").removeClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#StaffTitles").addClass("d-none");
                fetchStaffRegisterSummary();
                fetchIndividualSummary();
                fetchArrearsSummary();
                fetchThiryPartySummary();
                fetchDepartmentalSummary();
                fetchEntryExitSummary();
                fetchExceptionandExcemption();
            }
            else if(tabname==="ServiceSubCategories")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#StatutoyData").removeClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#StaffTitles").addClass("d-none");
                fetchSubCategories();
            }
            else if(tabname==="InstitutionTypes")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#ThirdPartyData").removeClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#StaffTitles").addClass("d-none");
                fetchInstitutionTypes();
            }
            else if(tabname==="SourceOfFunding")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#EarningsData").removeClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#StaffTitles").addClass("d-none");
                fetchSourceOfFunding();
            }
            else if(tabname==="RegistrationBodies")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#RegistrationBodies").removeClass("d-none");
                $("#StaffTitles").addClass("d-none");
                fetchRegistrationBodies();
            }
            else if(tabname==="RegistrationType")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#RegistrationTypes").removeClass("d-none");
                $("#StaffTitles").addClass("d-none");
                fetchRegistrationTypes();
            }
            else if(tabname==="TermsOfEngagements")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#TermsOfEngagements").removeClass("d-none");
                $("#StaffTitles").addClass("d-none");
                fetchTermsOfEngagement();
            }
            else if(tabname==="StaffTitles")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#StaffTitles").removeClass("d-none");
                fetchStaffTitles();
            }
            else if(tabname==="DepartmentalChangelog")
            {
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#DefaultData").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#RegistrationTypes").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#StaffTitles").addClass("d-none");
                $("#DepartmentalDeductionsData").removeClass("d-none");
                fetchDepartmentalChanges();
            }
            else
            {
                $("#DefaultData").removeClass("d-none");
                $("#ServiceCategoryPanel").addClass("d-none");
                $("#StatutoyData").addClass("d-none");
                $("#ThirdPartyData").addClass("d-none");
                $("#EarningsData").addClass("d-none");
                $("#DepartmentalDeductionsData").addClass("d-none");
                $("#RegistrationBodies").addClass("d-none");
                $("#TermsOfEngagements").addClass("d-none");
                $("#StaffTitles").addClass("d-none");
            }
        }
    </script>
    <script type="text/javascript">

        function fetchStaffRegisterSummary()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/getStaffRegisterSummary')?>";
            $.get(url,function(data){
                $("#StaffRegisterSummary").html(data);
            });
        }

        function fetchIndividualSummary()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/geEarningsSummary')?>";
            $.get(url,function(data){
                $("#IndividualSummary").html(data);

            });

        }

        function fetchArrearsSummary()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/getArrearsSummary')?>";
            $.get(url,function(data){
                $("#ArrearsSummary").html(data);

            });

        }

        function fetchThiryPartySummary()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/getThirdPartySummary')?>";
            $.get(url,function(data){
                $("#ThirdParySummary").html(data);
            });
        }

        function fetchDepartmentalSummary()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/getDepartmentalSummary')?>";
            $.get(url,function(data){
                $("#DepartmentalSummary").html(data);

            });
        }

        function fetchDepartmentalChanges() {
            var url = "<?= url('/PayrollModule/ProcessPayroll/PrePayrollAudit/getDepartmentalList') ?>";
            $.get(url, function(DepartmentalDeductionsData) {
                $("#DepartmentalDeductionsContent").html(DepartmentalDeductionsData);
            });
        }

        function fetchEntryExitSummary()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/getEntryExitSummary')?>";
            $.get(url,function(data){
                $("#EntryExitSummary").html(data);
            });
        }

        function fetchExceptionandExcemption()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/ExceptionandExcemptionSummary')?>";
            $.get(url,function(data){
                $("#ExceptionandExcemptionSummary").html(data);
            });
        }

        function fetchServiceSubCategories()
        {
            var url="<?=url('/SystemAdmin/ServiceCategories/getList')?>";
            $.get(url,function(data){
                $("#Categories").html(data);
            });
        }

        function fetchSubCategories()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/PrepayrollAuduit/getStaffRegister')?>";
            $.get(url,function(subcategorydata){
                $("#StatutoryContentContent").html(subcategorydata);
            });
        }

        function fetchInstitutionTypes()
        {
            var url="<?=url('/SystemAdmin/Settings/getInstTypedataList')?>";
            $.get(url,function(InstTypedata){
                $("#InstitutionTypeContentContent").html(InstTypedata);
            });
        }

        function fetchSourceOfFunding()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/ChangeLog/GetEarnings')?>";
            $.get(url,function(InstTypedata){
                $("#SourceOfFundingContentContent").html(InstTypedata);
            });
        }

        function fetchRegistrationBodies()
        {
            var url="<?=url('/SystemAdmin/Settings/getRegistrationBodydataList')?>";
            $.get(url,function(RegistrationBodydata){
                $("#RegistrationBodiesContentContent").html(RegistrationBodydata);
            });
        }

        function fetchRegistrationTypes()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/getExceptionsExmpetion')?>";
            $.get(url,function(RegistrationBodydata){
                $("#RegistrationTypesContentContent").html(RegistrationBodydata);
            });
        }

        function fetchTermsOfEngagement()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/getArrearsPrePayrollAudit')?>";
            $.get(url,function(Engagmentermdata){
                $("#TermsOfEngagementsContentContent").html(Engagmentermdata);
            });
        }

        function fetchStaffTitles()
        {
            var url="<?=url('/PayrollModule/ProcessPayroll/getThirdPartyDedPrePayrollAudit')?>";
            $.get(url,function(StaffTitledata){
                $("#StaffTitlesContentContent").html(StaffTitledata);
            });
        }


    </script>
    <script type="text/javascript">
        $("body").on("click","#GenerateEarnings",function(e){
            e.stopPropagation();
            var Code=$("#EarningName").val();
            var EarningUrl="<?=url('/PayrollModule/ProcessPayroll/PrePayrollAudit/getEarningRpt')?>";
            $.get(EarningUrl,{'EDCode':Code},function(data){
                $("#EarningReportView").html(data);
            });
        });

        $("body").on("click","#GenerateArrears",function(e){
            e.stopPropagation();
            var Code=$("#ArrearsName").val();
            var EarningUrl="<?=url('/PayrollModule/ProcessPayroll/PrePayrollAudit/getArrearsRpt')?>";
            $.get(EarningUrl,{'EDCode':Code},function(data){
                $("#ArrearReportView").html(data);
            });
        });

        $("body").on("click","#GenerateDepartmentals",function(e){
            e.stopPropagation();
            var Code=$("#DepartmentalName").val();
            var DepartmentalsUrl="<?=url('/PayrollModule/ProcessPayroll/PrePayrollAudit/getDepartmentalReport')?>";
            $.get(DepartmentalsUrl,{'EDCode':Code},function(data){
                $("#DepartmentReportView").html(data);
            });
        });

        $("body").on("click","#GenerateThirdPary",function(e) {
            e.stopPropagation();
            var Code = $("#ThirdParyName").val();
            var EarningUrl = "<?= url('/PayrollModule/ProcessPayroll/PrePayrollAudit/getThirdParyRpt') ?>";
            $.get(EarningUrl, {'EDCode': Code}, function (data) {
                $("#ThityParyReportView").html(data);
            });
        });

        $("body").on("click","#RegisterGenerateEarnings",function(e){
            e.stopPropagation();
            var Code=$("#RegisterEarningName").val();
            var EarningUrl="<?=url('/PayrollModule/ProcessPayroll/PrePayrollAudit/getRegisterRpt')?>";
            $.get(EarningUrl,{'EDCode':Code},function(data){
                $("#RegisterEarningReportView").html(data);
            });
        });



         $("body").on("click","#GenerateException",function(e){
            e.stopPropagation();

             
            var Code=$("#ExceptionName").val();
            var EarningUrl="<?=url('/PayrollModule/ProcessPayroll/PrePayrollAudit/getExceptionRegisterRpt')?>";
            $.get(EarningUrl,{'EDCode':Code},function(data){
                $("#ExceptionReportView").html(data);
            });
        });


        
    </script>
@endpush
