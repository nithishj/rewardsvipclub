app.controller('myanswersCtrl',['$scope', '$modal', 'loggedUserFactory', 'SurveyFactory', '$location', '$stateParams', function($scope ,$modal , loggedUserFactory, SurveyFactory, $location, $stateParams)
{ 

 loggedUserFactory.userdata()
	  .success(function(data){
	     $scope.userid=data.ssdata.user_id;
			 SurveyFactory.getmyanswers($stateParams.surveyid,$scope.userid)
                .success(function(data) {
				   //alert(JSON.stringify(data));
					$scope.surveydata=data;
             });
	  });


			 
$scope.openvid=function(size,vidurl)
		{
		$scope.imgurl="";
		$scope.vidurl=vidurl;
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/pushmsgmodal.html',
		controller: 'PushModalCtrl',
		size: size,
		scope:$scope
		});
		};
		
$scope.openimg = function (size,imgurl) 
		{
		$scope.vidurl="";
		$scope.imgurl=imgurl;
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/pushmsgmodal.html',
		controller: 'PushModalCtrl',
		size: size,
		scope:$scope
		});
		};

}]);