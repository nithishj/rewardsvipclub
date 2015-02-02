app.controller('addUserCtrl',['$scope','$location', 'ListUserFactory', function($scope, $location, ListUserFactory)
{

$scope.errmsg="";
$scope.cancel=function()
{
$location.path('/users');
};

$scope.submit=function()
{
ListUserFactory.addUser($scope.name,$scope.email,$scope.user_role,$scope.gender)
		.success(function(data){
		 //alert(JSON.stringify(data));
		 if(data.code==200)
		 {
		   alert('User Added Successfully');
		   $location.path('/users');		 
		 }
		 else
		 {
		    $scope.errmsg=data.message;
		 }
		 
		});

};

}]);