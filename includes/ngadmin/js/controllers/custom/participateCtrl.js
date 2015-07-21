app.controller('participateCtrl',['$scope', '$modal', 'loggedUserFactory', 'SurveyFactory', '$location', '$stateParams', function($scope ,$modal , loggedUserFactory, SurveyFactory, $location, $stateParams)
{ 

$scope.surveyanswer=[];
 $scope.choice = {};
SurveyFactory.getsurveystatistics($stateParams.surveyid)
                .success(function(data) {
				    //alert(JSON.stringify(data));
					$scope.surveydata=data;
					
					angular.forEach(data, function(value, key) {
					
  $scope.surveyanswer.push({'QuestionId':value.QuestionId,'MyChoice':''});
   
});

             });
			 
$scope.submitsurvey=function()
{
var arr = Object.keys($scope.choice).map(function(k) { return $scope.choice[k] });
 if(arr.length==0)
 alert("Answer atleast 1 question");
 else
 {
   loggedUserFactory.userdata()
	  .success(function(data){
	     $scope.userid=data.ssdata.user_id;
		 var dd={"SurveyId":$stateParams.surveyid,"UserId":$scope.userid,"Answers":$scope.surveyanswer}
			 SurveyFactory.submitsurvey(dd)
                .success(function(data) {
				    alert("survey submitted successfully");
					$location.path('/admin/survey');
             });
	  });
   
 }
  
}
			   
$scope.updatechoi=function(questionid,choiceid)
{
angular.forEach($scope.surveyanswer, function(value, key) {

   if(value.QuestionId==questionid)
   $scope.surveyanswer[key].MyChoice=choiceid;
});

}
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