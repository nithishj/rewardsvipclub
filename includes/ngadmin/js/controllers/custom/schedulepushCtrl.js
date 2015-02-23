app.controller('schedulepushCtrl',['$scope', '$modal', 'SchedulePushFactory', function($scope ,$modal ,SchedulePushFactory)
{

SchedulePushFactory.getpush()
		.success(function(data){
		$scope.schp=data;
		});

}]);