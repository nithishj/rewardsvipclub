app.controller('addofferCtrl',['$scope','$location','FileUploadFactory','OfferFactory','loggedUserFactory','$stateParams', function($scope, $location,FileUploadFactory,OfferFactory,loggedUserFactory,$stateParams)

{
  alert(JSON.stringify($stateParams));
	$scope.errmsg="";
    $scope.imguploaded=false;

	
	 $scope.onFileSelect = function($files,type) {
		$scope.showemsg=false;
		 FileUploadFactory.uploadFile($scope,$files,type);
		
	};
	
	
	$scope.cancel=function()
	{

        $location.path('/admin/listoffers');
	};

	$scope.submit=function()
	{
        loggedUserFactory.userdata().success(function(data){
            if ($scope.myimg)
            {
                OfferFactory.addOffer(data.ssdata.user_id,$scope.offer_name,$scope.offer_d,$scope.offer_points,$scope.myimg)
                    .success(function(data){

                        if(data.code==200)
                        {
                            alert('Offer Added Successfully');
                            $location.path('/admin/listoffers');
                        }
                        else
                        {
                            $scope.errmsg=data.message;
                        }

                    });
            }
            else{
                $scope.errmsg="Please Select Image";
            }


        });


	};

}]);