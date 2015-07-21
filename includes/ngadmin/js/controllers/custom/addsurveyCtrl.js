app.controller('addsurveyCtrl',['$scope', '$modal', '$location', 'ListUserFactory', 'loggedUserFactory', 'SurveyFactory','FileUploadFactory', function($scope ,$modal ,$location , ListUserFactory, loggedUserFactory, SurveyFactory ,FileUploadFactory)
{
  $scope.choi=[{"question":"Question 1","questionvalue":'',"colorid":'',"chosencolor":'',"chosenimg":'',"image":'',"imuploading":false,"imfinish":false,"audio":'',"aduploading":false,"adfinish":false,"video":'',"vduploading":false,"vdfinish":false,"videothumb":'',"vtuploading":false,"vtfinish":false,"choice":[{"name":"Choice 1","choicevalue":''},{"name":"Choice 2","choicevalue":''}]}];

  
  loggedUserFactory.userdata()
	  .success(function(data){
	     $scope.userid=data.ssdata.user_id;
	  });
  
  
  $scope.addchoice=function(key)
  {
     
     var nexchoi =$scope.choi[key].choice.length+1;
	 $scope.choi[key].choice.push({"name":"Choice "+nexchoi})
  
  };
  
  
  $scope.removechoice=function(key)
  {
	if($scope.choi[key].choice.length>2)
	$scope.choi[key].choice.splice(-1,1)
	else
	alert("Need atleast two choice");
  }
  
  $scope.addquestion= function()
  {	
     var nexquest =$scope.choi.length+1;
	 $scope.choi.push({"question":"Question "+nexquest,"questionvalue":'',"colorid":'',"chosencolor":'',"chosenimg":'',"image":'',"imuploading":false,"imfinish":false,"audio":'',"aduploading":false,"adfinish":false,"video":'',"vduploading":false,"vdfinish":false,"videothumb":'',"vtuploading":false,"vtfinish":false,"choice":[{"name":"Choice 1","choicevalue":''},{"name":"Choice 2","choicevalue":''}]});
  }
  
   $scope.removequestion= function()
  {	 
	if($scope.choi.length>1)
	$scope.choi.splice(-1,1)
	else
	alert("Need atleast One Question");
  }
  
  //To get all color codes
  ListUserFactory.getcolorids()
	  .success(function(data){
	  $scope.colorcodes=data;
	 // alert(JSON.stringify(data));
	  });
  
  $scope.setcolor=function(id, key)
  {
	$scope.choi[key].colorid=id;
    ListUserFactory.getcolor(id)
				   .success(function(data)
				   {
					$scope.choi[key].chosencolor=data.rgb;
					$scope.choi[key].chosenimg=data.color_image;
				   });
  };
  
  
    $scope.onFileSelect = function($files,type,key) {
          FileUploadFactory.uploadSurveyFile($scope,$files,type,key);

      }
	  
	$scope.publishsurvey=function()
	{
	 var dd={"surveytitle":$scope.surveytitle,"surveydescription":$scope.surveydescription,"userid":$scope.userid,"allquest":$scope.choi};
	 //alert(JSON.stringify(dd));
	 SurveyFactory.addsurvey(dd).success(function(data)
	 {
	  if(data.message=="success")
	  {
	  alert("survey created successfully");
	  $location.path('/admin/survey');
	  }
	  else
	  alert("An unexpected error has occured.Please contact Database Administrator");
	  
	 });
	  
	}	 
  
}]);