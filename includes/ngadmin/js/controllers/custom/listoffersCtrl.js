app.controller('listoffersCtrl',['$scope', '$location', 'loggedUserFactory', 'OfferFactory', '$modal', function($scope, $location, loggedUserFactory, OfferFactory, $modal)
{
 $scope.AddOfferid=[];
 $scope.disdel=true;
 
OfferFactory.getoffers()
		.success(function(data){
		$scope.offers=data;
		});
		
$scope.pushofferid=function(offerid)
		{
	
		 // alert(broadcastid);
			if ($scope.AddOfferid.indexOf(offerid) == -1) {
			$scope.AddOfferid.push(offerid);
			}
			else
			{
			var index = $.inArray(offerid, $scope.AddOfferid);
			$scope.AddOfferid.splice(index, 1);
			//$scope.storeidAdd.push(StoreId);
			}
			
			if ($scope.AddOfferid.length == 0) 
			 $scope.disdel=true;
			 else
			 $scope.disdel=false;
			alert($scope.AddOfferid);
		};		
		
		
$scope.opendelete=function(size , id)
{
$scope.delid=id
$scope.delname="offer";
$scope.deltype="singular";
var modalInstance = $modal.open({
	templateUrl: 'includes/ngadmin/tpl/delmodal.html',
	controller: 'offerModalCtrl',
	size: size,
	scope:$scope
});

};	

$scope.opendeleteall=function(size)
{
$scope.deltype="multi";
var modalInstance = $modal.open({
	templateUrl: 'includes/ngadmin/tpl/delmodal.html',
	controller: 'offerModalCtrl',
	size: size,
	scope:$scope
});
};

	
}])
.controller('offerModalCtrl', ['$scope' ,'$modalInstance', function($scope ,$modalInstance){


$scope.confirmdel=function()
	{
  
	 alert($scope.deltype);
	 if($scope.deltype=="singular")
	 {
	 
	 }
	 ListUserFactory.deleteuser($scope.delid)
	  .success(function(data){
	          
			alert('user deleted successfully');
			$('#Vip'+$scope.delid).hide();
		});
	  $modalInstance.close();
	};


$scope.cancel=function()
	{
	$modalInstance.close();

	};

}]);
