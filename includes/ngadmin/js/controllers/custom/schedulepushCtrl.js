app.controller('schedulepushCtrl',['$scope', '$modal', 'SchedulePushFactory', '$location', function($scope ,$modal ,SchedulePushFactory, $location)
{
 $scope.Addpushid=[];
 $scope.disdel=true;


SchedulePushFactory.getpush('')
		.success(function(data){
		$scope.schp=data;
		});
		
$scope.edit=function(id)
{
alert(id);
$location.path('/editschedule/id');
};		
		
$scope.pushpushid=function(pushid)
		{

		 // alert(broadcastid);
			if ($scope.Addpushid.indexOf(pushid) == -1) {
			$scope.Addpushid.push(pushid);
			}
			else
			{
			var index = $.inArray(pushid, $scope.Addpushid);
			$scope.Addpushid.splice(index, 1);
			//$scope.storeidAdd.push(StoreId);
			}
			
			if ($scope.Addpushid.length == 0) 
			 $scope.disdel=true;
			 else
			 $scope.disdel=false;
			alert($scope.Addpushid);
		};		
			
$scope.opendelete=function(size , id, type)
{
    if(type=="singular") {
        $scope.delid = id;
        $scope.delname="Schedule";
    }
    else    
    {
        $scope.delname = "Selected Schedule";
    }

$scope.deltype=type;

var modalInstance = $modal.open({
	templateUrl: 'includes/ngadmin/tpl/delmodal.html',
	controller: 'ScPuModalCtrl',
	size: size,
	scope:$scope
});

};	

$scope.opendeleteall=function(size)
{
$scope.deltype="multi";
var modalInstance = $modal.open({
	templateUrl: 'includes/ngadmin/tpl/delmodal.html',
	controller: 'ScPuModalCtrl',
	size: size,
	scope:$scope
});
};

}])
.controller('ScPuModalCtrl' ,['$scope', '$modalInstance', 'SchedulePushFactory', function($scope, $modalInstance, SchedulePushFactory){


$scope.confirmdel=function()
	{
  
	 //alert($scope.deltype);
	 if($scope.deltype=="singular")
	 {

         SchedulePushFactory.deletepush($scope.delid)
             .success(function(data){
                 alert('Schedule deleted successfully');
                 $('#Vip'+$scope.delid).hide();
             });
	 }
     else if($scope.deltype=="multi")
     {
         SchedulePushFactory.deletepush($scope.Addpushid.toString())
             .success(function(data){
                 //alert(JSON.stringify(data));
                 alert('Schedules deleted successfully');
                 angular.forEach($scope.Addpushid, function(value, key) {
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