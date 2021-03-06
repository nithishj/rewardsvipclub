app.controller('addofferCtrl',['$scope','$location','FileUploadFactory','OfferFactory','loggedUserFactory', '$stateParams',function($scope, $location,FileUploadFactory,OfferFactory,loggedUserFactory,  $stateParams) {
   // alert(JSON.stringify($stateParams.id));
    $scope.errmsg = "";
    $scope.heading="Add";
    $scope.imguploaded = false;

    if($stateParams.id)
    {
        $scope.heading="Edit";
    OfferFactory.getoffers($stateParams.id)
        .success(function (data) {
            //$scope.offers = data;
            $scope.offid=data[0].OfferId;
            $scope.offer_name=data[0].OfferName;
            $scope.offer_d=data[0].Description;
            $scope.offer_points=parseInt(data[0].Points);
            $scope.imguploaded = true;
            $scope.myimg=data[0].Image;
            //alert(JSON.stringify(data));
        });
    }

	 $scope.onFileSelect = function($files,type) {
		$scope.showemsg=false;
        FileUploadFactory.uploadFile($scope,$files,type);
		
	};
	
	
	$scope.cancel=function()
	{

        $location.path('/admin/offers');
	};

	$scope.submit=function()
	{
        loggedUserFactory.userdata().success(function(data){
            if ($scope.myimg)
            {
                if($stateParams.id)
                {
                    OfferFactory.editOffer(data.ssdata.user_id,$scope.offid,$scope.offer_name,$scope.offer_d,$scope.offer_points,$scope.myimg)
                        .success(function(data){

                            if(data.code==200)
                            {
                                alert('Offer Edited Successfully');
                                $location.path('/admin/offers');
                            }
                            else
                            {
                                $scope.errmsg=data.message;
                            }

                        });
                }
                else
                {
                    OfferFactory.addOffer(data.ssdata.user_id,$scope.offer_name,$scope.offer_d,$scope.offer_points,$scope.myimg)
                        .success(function(data){

                            if(data.code==200)
                            {
                                alert('Offer Added Successfully');
                                $location.path('/admin/offers');
                            }
                            else
                            {
                                $scope.errmsg=data.message;
                            }

                        });
                }
            }
            else
            {
                $scope.errmsg="Please upload an image";
            }


        });


	};

}]);