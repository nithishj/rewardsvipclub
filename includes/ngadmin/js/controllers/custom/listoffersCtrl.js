app.controller('listoffersCtrl',['$scope', '$location', 'loggedUserFactory', 'OfferFactory', '$modal', function($scope, $location, loggedUserFactory, OfferFactory, $modal)
{
 $scope.AddOfferid=[];
 $scope.disdel=true;
 
OfferFactory.getoffers('')
		.success(function(data){
		$scope.offers=data;
        //alert(JSON.stringify($scope.offers));
		});

    //navigate to edit offer screen
    $scope.edit=function(offerid)
    {
     $location.path('/admin/editoffer/'+offerid);
    };
		
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
		//alert($scope.AddOfferid);
	};


    $scope.openimg = function (size,imgurl)
    {
       // alert(imgurl);
        $scope.vidurl="";
        $scope.imgurl=imgurl;
        var modalInstance = $modal.open({
            templateUrl: 'includes/ngadmin/tpl/pushmsgmodal.html',
            controller: 'offerModalCtrl',
            size: size,
            scope:$scope
        });
    };
		
$scope.opendelete=function(size , id, type)
{
    if(type=="singular") {
        $scope.delid = id;
        $scope.delname="offer";
    }
    else    // type=="multi"
    {
        $scope.delname = "Selected Offers";
    }

$scope.deltype=type;

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
.controller('offerModalCtrl', ['$scope' ,'$modalInstance','OfferFactory', function($scope ,$modalInstance ,OfferFactory){


$scope.confirmdel=function()
	{
  
	 //alert($scope.deltype);
	 if($scope.deltype=="singular")
	 {

         OfferFactory.deleteoffer($scope.delid)
             .success(function(data){
                 alert('Offer deleted successfully');
                 $('#Vip'+$scope.delid).hide();
             });
	 }
     else if($scope.deltype=="multi")
     {
         OfferFactory.deleteoffer($scope.AddOfferid.toString())
             .success(function(data){
                 //alert(JSON.stringify(data));
                 alert('Offers deleted successfully');
                 angular.forEach($scope.AddOfferid, function(value, key) {
                     $('#Vip'+value).hide();
                 });
             });

     }

	  $modalInstance.close();
	};


        $scope.cancel=function()
        {
            $scope.vidurl="";
            $scope.imgurl="";
            $modalInstance.close();

        };

}]);
