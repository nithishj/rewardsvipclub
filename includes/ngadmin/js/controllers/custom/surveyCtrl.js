app.controller('surveyCtrl',['$scope', '$modal', 'loggedUserFactory', 'SurveyFactory', '$location', function($scope ,$modal , loggedUserFactory, SurveyFactory,$location)
{ 
    
	$scope.AddSurveyd=[];
	$scope.disdel=true;
	
    //to get surveys
    
	
	 loggedUserFactory.userdata()
	  .success(function(data){
	     $scope.userid=data.ssdata.user_id;
			  SurveyFactory.getsurvey($scope.userid)
					.success(function(data) {
						$scope.allsurvey=data;
						//alert(JSON.stringify(data));
				 });
	  });
	  
	  $scope.participate=function(surveyid)
	  {
	    $location.path('/admin/participate/'+surveyid);
	  }
		
      $scope.participants=function(surveyid)
	  {
	    $location.path('/admin/surveyparticipants/'+surveyid);
	  }		
	  
	  $scope.myanswers=function(surveyid)
	  {
	    $location.path('/admin/myanswers/'+surveyid);
	  }
	  
	 $scope.pushsurveyid=function(surveyid)
		{
		 // alert(broadcastid);
			if ($scope.AddSurveyd.indexOf(surveyid) == -1) {
			$scope.AddSurveyd.push(surveyid);
			}
			else
			{
			var index = $.inArray(surveyid, $scope.AddSurveyd);
			$scope.AddSurveyd.splice(index, 1);
			//$scope.storeidAdd.push(StoreId);
			}
			
			if ($scope.AddSurveyd.length == 0) 
			 $scope.disdel=true;
			 else
			 $scope.disdel=false;
			//alert($scope.AddSurveyd);
		};
		
		
		//go to survey statistics page
		$scope.statistics=function(surveyid)
		{
		   $location.path('/admin/surveystatistics/'+surveyid);
		}
		
		$scope.opendelete=function(size , id, type)
		{
			if(type=="singular") {
				$scope.delid = id;
				$scope.delname="Survey";
			}
			else    // type=="multi"
			{
				$scope.delname = "Selected Surveys";
			}

		$scope.deltype=type;

		var modalInstance = $modal.open({
			templateUrl: 'includes/ngadmin/tpl/delmodal.html',
			controller: 'surveyModalCtrl',
			size: size,
			scope:$scope
		});

		};

}])
.controller('surveyModalCtrl', ['$scope' ,'$modalInstance' ,'SurveyFactory', function($scope ,$modalInstance ,SurveyFactory){


$scope.confirmdel=function()
	{
	 if($scope.deltype=="singular")
	 {

         SurveyFactory.deletesurvey($scope.delid)
             .success(function(data){
                 alert('Survey deleted successfully');
                 $('#Vip'+$scope.delid).hide();
             });
	 }
     else if($scope.deltype=="multi")
     {
        SurveyFactory.deletesurvey($scope.AddSurveyd.toString())
             .success(function(data){
                 //alert(JSON.stringify(data));
                 alert('Survey deleted successfully');
                 angular.forEach($scope.AddSurveyd, function(value, key) {
                     $('#Vip'+value).hide();
                 });
             });

     }

	  $modalInstance.close();
	};


	$scope.cancel=function()
	{
		$modalInstance.close();

	};

}]);