app.controller('surveyparticipantsCtrl',['$scope', '$modal', 'loggedUserFactory', 'SurveyFactory', '$location', '$stateParams', function($scope ,$modal , loggedUserFactory, SurveyFactory, $location, $stateParams)
{ 
$scope.nopa=false;
			 SurveyFactory.getparticipants($stateParams.surveyid)
                .success(function(data) {
				   //alert(JSON.stringify(data));
				   if(data.length==0)
				   $scope.nopa=true;
				   else
				   $scope.participants=data;
             });
			 
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

$scope.openrecord=function(userid)		
{
   $location.path('/admin/participantanswers/'+userid+'/'+$stateParams.surveyid);
}
}])
.controller('participantanswersCtrl',['$scope', '$modal', 'loggedUserFactory', 'SurveyFactory', '$location', '$stateParams', function($scope ,$modal , loggedUserFactory, SurveyFactory, $location, $stateParams)
{ 


			 SurveyFactory.getmyanswers($stateParams.surveyid,$stateParams.userid)
                .success(function(data) {
				    //alert(JSON.stringify(data));
					$scope.surveydata=data;
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