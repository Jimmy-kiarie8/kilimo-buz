<?php
    Route::prefix('System')->group(function() {
    Route::get('/Counties/Index', 'CountyController@index');
    Route::any('/Counties/fetchList','CountyController@fetchList');
    Route::any('/County/Create','CountyController@Create');
    Route::any("County/EditDetails/{id}","CountyController@EditDetails");

      Route::any('/User/EditCounty/{id}','UserController@EditCountyDetails');

      
    Route::any('Department/Index','DepartmentController@Index');
    Route::any('/Departments/fetchList','DepartmentController@fetchList');
    Route::any('/Departments/Create','DepartmentController@Create');
    Route::any('/Department/EditDetails/{id}','DepartmentController@EditDetails');
    Route::any('Ethnicity/Index','EthinicityController@Index');
    Route::any('/Ethinicity/Create','EthinicityController@Create');
    Route::any('/Ethinicity/fetchList','EthinicityController@fetchList');
    Route::any('/Ethinicity/EditDetails/{id}','EthinicityController@EditDetails');
    Route::any('/ProductNames/Index','ProductNameController@Index');
    Route::any('/ProductNames/fetchList','ProductNameController@fetchList');
    Route::any('/Entities/EditValue/{id}','OrgainizationController@EditValueChain');
    Route::any('/TransportNode/Create','TransporterController@Create');
    Route::any('/TransportNode/Index','TransporterController@Index');
    Route::any('/Entities/EditNode/{id}','OrgainizationController@EditNode');
    Route::any('/Users/fetchCountyList','UserController@fetchCountyList');
    Route::any('/ProductNames/EditPrice/{id}','ProductNameController@EditPrice');
    Route::any('/ProductNames/EditValueChain/{id}','ProductNameController@EditValueChain');
    Route::any('/ProductNames/getMyMeta/{id}','ProductNameController@getMyMeta');
    Route::any('/ProductNames/EditMeta/{id}','ProductNameController@EditMeta');
    Route::any('/ProductNames/Create','ProductNameController@Create');
    Route::any('/ProductNames/MetaData/{id}','ProductNameController@MetaData');
    Route::any('/Product/getUoM/{id}','ProductNameController@getMeta');
    Route::any('/ProductNames/EditDetails/{id}','ProductNameController@EditDetails');
    Route::any('/MemberAccount/Import','MemberController@ImportMembersByVCO');
    Route::any('JobGroups/Index','JobGroupController@Index');
    Route::any('/JobGroups/Create','JobGroupController@Create');
    Route::any('/VCOMembers/Create','MemberController@CountyCreate');
    Route::any('/JobGroups/fetchList','JobGroupController@fetchList');
    Route::any('/JobGroups/EditDetails/{id}','JobGroupController@EditDetails');
    Route::any('/Ministries/Index','MinistryController@Index');
    Route::any('/Ministries/Create','MinistryController@Create');
    Route::any('/Ministries/fetchList','MinistryController@fetchList');
    Route::any('/Ministries/EditDetails/{id}','MinistryController@EditDetails');
    Route::any('/Product/GetMostRecentPosts','MemberController@GetMostRecentPosts');

    Route::any('/VCODashboard/GetMainData','MemberController@VCODashboard');
    Route::any('/Qualifications/Index','QualificationController@Index');
    Route::any('/Qualifications/Create','QualificationController@Create');
    Route::any('/Qualifications/fetchList','QualificationController@fetchList');
    Route::any('/Qualifications/EditDetails/{id}','QualificationController@EditDetails');
    Route::any('/UserTitles/Index','UserTitleController@Index');
    Route::any('/UserTitles/Create','UserTitleController@Create');
    Route::any('/UserTitles/fetchList','UserTitleController@fetchList');
    Route::any('/UserTitles/EditDetails/{id}','UserTitleController@EditDetails');
    Route::any('/Religions/Index','ReligionController@Index');
    Route::any('/Religions/Create','ReligionController@Create');


    Route::any('/Religions/fetchList','ReligionController@fetchList');
    Route::any('/Religions/EditDetails/{id}','ReligionController@EditDetails');
    Route::any('Designitions/Index','DesignitionController@Index');
    Route::any('/Designitions/Create','DesignitionController@Create');
    Route::any('/Designitions/fetchList','DesignitionController@fetchList');
    Route::any('/Designitions/EditDetails/{id}','DesignitionController@EditDetails');
    Route::any('/SubCounties/Index','SubCountyController@Index');
    Route::any('/SubCounties/Create','SubCountyController@Create');
    Route::any('/SubCounties/fetchList','SubCountyController@fetchList');
    Route::any('/SubCounties/EditDetails/{id}','SubCountyController@EditDetails');
    Route::any('/SubCounty/GetMySubCounties/{id}','SubCountyController@GetMySubCounties');
    Route::get('/Roles/Index', 'UsermanagementController@index');
    Route::any("/Roles/fetchList","UsermanagementController@fetchList");
    Route::any("/Roles/Create","UsermanagementController@Create");
    Route::any("/Role/ViewPermission/{id}","UsermanagementController@ViewPermission");
    Route::any("/Role/ViewRoleUser/{id}","UsermanagementController@ViewRoleUser");
    Route::any("/Role/Delete/{id}","UsermanagementController@Delete");
    Route::any("/Role/EditDetails/{id}","UsermanagementController@EditDetails");
    Route::any("/Permissions/Index","UsermanagementController@Permissions");
    Route::any("/Permissions/fetchList","UsermanagementController@fetchPemissions");
    Route::any("/Users/CreateAccount","UserController@create");
    Route::any('/Users/Index',"UserController@Index");
    Route::any("/Users/fetchList","UserController@fetchUsers");
    Route::any("/Users/ResetPassword/{id}","UserController@PasswordReset");
    Route::any("/Users/ViewPermission/{id}","UserController@ViewPermission");
    Route::any("/Users/ViewRoleUser/{id}","UserController@ViewRoleUser");
    Route::any("Users/Create","UserController@create");
    Route::any('/SystemAudit/Index','AuditController@Index');
    Route::any('/Audit/fetchList','AuditController@fetchList');
    Route::any('/Users/GetOtherDetails','UserController@GetOtherDetails');
    Route::any('/ValueChain/Index','ValueChainController@Index');
    Route::any('/ValueChain/fetchList','ValueChainController@fetchList');
    Route::any('/ValueChain/Create','ValueChainController@Create');
    Route::any('/ValueChain/EditDetails/{id}','ValueChainController@EditDetails');
    Route::any('/NodeTypes/Index','NodeTypeController@Index');
    Route::any('/Node/fetchList','NodeTypeController@fetchList');
    Route::any('/NodeTypes/Create','NodeTypeController@Create');
    Route::any('/NodeTypes/EditDetails/{id}','NodeTypeController@EditDetails');
    Route::any('//Entities/Create','OrgainizationController@Create');
    Route::any('/Entities/GetSubCounties/{id}','OrgainizationController@GetSubCounties');
    Route::any('ValueChain/CountyIndex','ValueChainController@getCounties');
    Route::any('/CountyValueChain/fetchList','ValueChainController@CountyValueChain');
    Route::any('/CountValueChain/Create','ValueChainController@CreateCounty');
    Route::any('/CountyValueChain/EditDetails/{id}','ValueChainController@EditValueDetails');
    Route::any('/Entities/GetValueChains/{id}','ValueChainController@GetCountyValues');
    Route::any('/Entities/Index','OrgainizationController@Index');
    Route::any('/Entities/fetchList','OrgainizationController@fetchList');

    Route::any('/Entities/EditDetails/{id}','OrgainizationController@EditDetails');
    Route::any('/Dashboard/MainData','DashboardController@MainData');
    Route::any('/Dashboard/ValueChains','DashboardController@ValueChainsSt');
    Route::any('/Survey/Dashboard','DashboardController@MDashboard');
    Route::any('/Dashboard/GetSurvey','DashboardController@GetSurveyGData');
    Route::any('/Dashboard/GetSubCountyB','DashboardController@GetSubCountyB');
    Route::any('/Entities/Import','OrgainizationController@Import');
    Route::any('/UnitOfMeasure/Index','UnitOfMeasureController@Index');
    Route::any('/UnitOfMeasure/Create','UnitOfMeasureController@Create');
    Route::any('/UOM/fetchList','UnitOfMeasureController@fetchList');
    Route::any('/UnitOfMeasur/EditDetails/{id}','UnitOfMeasureController@EditDetails');
    Route::any('/Profile/BasicDetails','OrgainizationController@Profile');
    Route::any('/MemberAccount/Create','MemberController@Create');
    Route::any('/MemberAccount/Index','MemberController@Index');
    Route::any('/Members/fetchList','MemberController@fetchOrgList');
    Route::any('/Reports/VCAByCounty','MemberController@VCAByCounty');
    Route::any('/Reports/CountyVCAS','MemberController@FetchVCAByCounty');
    Route::any('/Reports/VCAByVCO','MemberController@VCAByVCO');
    Route::any('/Reports/OrgVCAS','MemberController@fetchOrgVCAS');

    Route::any('/Member/Remove/{id}','MemberController@Remove');
    Route::any('/Member/EditDetails/{id}','MemberController@EditDetails');
    Route::any('/Member/EditMemberDetails/{id}','MemberController@EditMemberDetails');
    Route::any('/VCOMembers/ImportMembers','MemberController@ImportMembers');
    Route::any('/ValueAnalysis/Countystatistics','DashboardController@MapData');
    Route::any('/VCOMembers/Index','MemberController@getAdminList');
    Route::any('/Member/fetchAdminList','MemberController@fetchAdminList');
    Route::any('/Member/ViewDetails/{id}','MemberController@ViewDetails');
    Route::any('/MemberAccount/AddProduct','MemberController@addProduct');
    Route::any('VCOMembers/GetCountyList/{id}','OrgainizationController@GetCountyList');
    Route::any('/MemberAccount/getMemberDetails/{id}','MemberController@getMemberDetails');
    Route::any('/MemberProducts/Index','MemberController@getMemberProducts');
    Route::any('/MemberProducts/fetchAdminList','MemberController@fetchAdminProductList');
    Route::any('/ValueChain/getUoM/{id}','ValueChainController@getUoM');
    Route::any('/MemberAccount/ProductList','MemberController@ProductList');
    Route::any('/MemberProducts/fetchList','MemberController@FetchMemberProducts');
    Route::any('/Member/EditProduct/{id}','MemberController@EditProduct');
    Route::any('/Security/ChangePassword','SecurityController@ChangePassword');
    Route::any('/Dashboard/getToptenProductByValue','DashboardController@getToptenProductByValue');
    Route::any('/Node/GetGenStats','DashboardController@GetGenStats');
    Route::any('/Dashboard/CountValueQty','DashboardController@CountValueQty');
    Route::any('/Dashboard/getTopValuePerformance','DashboardController@getTopValuePerformance');
    Route::any('/Dashboard/GetMonthStats','DashboardController@GetMonthStats');
    Route::any('/Reports/CountyVsVCOs','ValueChainController@CountyVsVCOs');
    Route::any('/Reports/CountyVCOS','ValueChainController@fetchCountyVCOS');
    Route::any('/Reports/General','ValueChainController@General');
    Route::any('/Reports/FetchGeneral','ValueChainController@FetchGeneral');
    Route::any('/Reports/ValueVCO','ValueChainController@getValueVCO');
    Route::any('/Reports/ValueNameVCOS','ValueChainController@ValueNameVCOS');
    Route::any('/Reports/NodeVCO','ValueChainController@getNodeVCO');
    Route::any('/Reports/NodeVCOS','ValueChainController@FetchNodeNum');



    Route::any('/TrainingModule/Create','TrainingController@Create');
    Route::any('/TrainingModule/Index','TrainingController@Index');
    Route::any('/TrainingModule/Admin','TrainingController@Admin');
   Route::any('/TrainingModule/fetchAdminList','TrainingController@fetchAdminList');
    Route::any('/TrainingModule/fetchList','TrainingController@fetchList');
    Route::any('/TrainingModule/AddAttendance/{id}','TrainingController@AddAttendance');
    Route::any('/TrainingModule/getMyAttendance/{id}','TrainingController@getMyAttendance');
    Route::any('/TrainingModule/ViewGallery/{id}','TrainingController@ViewGallery');

    Route::any('/TrainingModule/TrainedActors','TrainingController@TrainedActors');
    Route::any('/TrainingModule/Trainees','TrainingController@Trainees');
    Route::any('/TrainingModule/fetchAdminAttendances','TrainingController@fetchTRainees');
    Route::any('/TrainingAttendance/ViewDetails/{id}','TrainingController@ViewDetails');
    Route::any('/TrainingModule/fetchAttendances','TrainingController@fetchAttendances');
    Route::any('/TrainingAttendance/EditDetails/{id}','TrainingController@EditAttendance');
    Route::any('/TrainingModule/ImportAttendance','TrainingController@ImportAttendance');
    Route::any('/TrainingModule/ViewEvidence/{id}','TrainingController@ViewEvidence');


    Route::any('/AdminOrders/Index','OrderController@Index');
    Route::any('/Orders/fetchList','OrderController@fetchList');
    Route::any('/Orders/Pending','OrderController@Pending');
    Route::any('/Orders/fetchVCOList','OrderController@fetchVCOList');
    Route::any('/Order/MarkComplete/{id}','OrderController@MarkComplete');
    Route::any('/Orders/Completed','OrderController@Completed');
    Route::any('/Orders/fetchVCOCList','OrderController@fetchVCOCList');

    Route::any('/MemberToVCOByID/Index','MemberController@MemberToVCOByID');
    Route::any('/VCOMembers/GetMemberList/{id}','MemberController@GetMemberList');
    Route::any('/VCOMembers/GetMemberDetails/{id}','MemberController@GetMemberDetail');
    Route::any('/VCOMemberOTP/Index','MemberController@VCOMemberOTP');
    Route::any('/VCOMemberOTP/GetOTP','MemberController@GetMobileOTP');
    Route::any('/Product/EditValueChain/{id}','MemberController@EditProductValueChain');
    Route::any('/Product/EditProductQuanity/{id}','MemberController@EditProductQuanity');
    Route::any('/Product/DeleteProduct/{id}','MemberController@DeleteProduct');
    

});
