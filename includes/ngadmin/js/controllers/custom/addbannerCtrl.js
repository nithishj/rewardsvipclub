app.controller('addbannerCtrl',['$scope','$location','FileUploadFactory','BannerFactory','loggedUserFactory','$stateParams', function($scope, $location,FileUploadFactory,BannerFactory,loggedUserFactory,$stateParams)

{
  
	$scope.errmsg="";
    $scope.imguploaded=false;
	$scope.heading="Add"

	if($stateParams.id)
    {
	$scope.heading="Edit"
	 BannerFactory.getbanners($stateParams.id)
                    .success(function(data){
					//alert(JSON.stringify(data));
					$scope.banid=data[0].BannerId;
					$scope.banner_name=data[0].BannerName;
					$scope.bannerurl=data[0].BannerUrl;
					$scope.imguploaded=true;
					$scope.myimg=data[0].BannerImage;
					});

	
	
	}
	 $scope.onFileSelect = function($files,type) {
		
         var width = 1242,
            height = 192;
         FileUploadFactory.validateImageFile($scope,$files,type,width,height);
		
	};
	
	
	$scope.cancel=function()
	{

        $location.path('/admin/banners');
	};

	$scope.submit=function()
	{
        loggedUserFactory.userdata().success(function(data){
            if ($scope.myimg)
            {
			 if($stateParams.id)
			 {
			   BannerFactory.editBanner($scope.banid,data.ssdata.user_id,$scope.banner_name,$scope.bannerurl,$scope.myimg)
                    .success(function(data){

                        if(data.code==200)
                        {
                            alert('Banner Edited Successfully');
                            $location.path('/admin/banners');
                        }
                        else
                        {
                            $scope.errmsg=data.message;
                        }

                    });
			 
			 
			 }
			 else
			 {
                BannerFactory.addBanner(data.ssdata.user_id,$scope.banner_name,$scope.bannerurl,$scope.myimg)
                    .success(function(data){

                        if(data.code==200)
                        {
                            alert('Banner Added Successfully');
                            $location.path('/admin/banners');
                        }
                        else
                        {
                            $scope.errmsg=data.message;
                        }

                    });
			 }
            }
            else{
                $scope.errmsg="Please upload a valid Banner";
            }


        });


	};
    
    
   

}]);