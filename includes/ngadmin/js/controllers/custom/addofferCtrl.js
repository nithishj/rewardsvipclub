app.controller('addofferCtrl',['$scope','$location','FileUploadFactory','OfferFactory','loggedUserFactory', function($scope, $location,FileUploadFactory,OfferFactory,loggedUserFactory)

{
  
	$scope.errmsg="";

	
	 $scope.onFileSelect = function($files,type) {
		$scope.showemsg=false;
		 FileUploadFactory.uploadFile($scope,$files,type);
		
	}
	
	
	$scope.cancel=function()
	{

        $location.path('/admin/listoffers');
	};

	$scope.submit=function()
	{
        loggedUserFactory.userdata().success(function(data){

            OfferFactory.addOffer(data.ssdata.user_id,$scope.offer_name,$scope.offer_d,$scope.offer_points,$scope.myimg)
                .success(function(data){
                    alert(JSON.stringify(data));
                    if(data.code==200)
                    {
                        alert('Offer Added Successfully');
                        //$location.path('/listoffers');
                    }
                    else
                    {
                        $scope.errmsg=data.message;
                    }

                });

        });


	};

}]);