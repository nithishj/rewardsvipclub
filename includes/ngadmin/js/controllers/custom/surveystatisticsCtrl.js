app.controller('surveystatisticsCtrl',['$scope', '$modal', 'loggedUserFactory', 'SurveyFactory', '$location', '$stateParams', function($scope ,$modal , loggedUserFactory, SurveyFactory, $location, $stateParams)
{ 
SurveyFactory.getsurveystatistics($stateParams.surveyid)
                .success(function(data) {
				   // alert(JSON.stringify(data));
					$scope.surveystat=data;
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