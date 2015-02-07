app.controller('addofferCtrl',['$scope','$location','FileUploadFactory', function($scope, $location,FileUploadFactory)

{
  
	$scope.errmsg="";
	
	 $scope.onFileSelect = function($files,type) {
		$scope.showemsg=false;
		FileUploadFactory.uploadFile($scope,$files,type);
	}
	
	
	$scope.cancel=function()
	{
		$location.path('/listoffers');
	};

	$scope.submit=function()
	{
		alert($scope.offer_name+","+$scope.offer_d+","+$scope.offer_code+","+$scope.offer_points);
		/*ListOffersFactory.addOffer($scope.offer_name,$scope.offer_desc,$scope.offer_code,$scope.offer_points)
		.success(function(data){
		 //alert(JSON.stringify(data));
		 if(data.code==200)
		 {
		   alert('Offer Added Successfully');
		   $location.path('/offers');		 
		 }
		 else
		 {
			$scope.errmsg=data.message;
		 }
		 
		}); */

	};

}]);