app.controller('addbannerCtrl',['$scope','$location','FileUploadFactory','BannerFactory','loggedUserFactory','$stateParams', function($scope, $location,FileUploadFactory,BannerFactory,loggedUserFactory,$stateParams)

{
  
	$scope.errmsg="";
    $scope.imguploaded=false;

	
	 $scope.onFileSelect = function($files,type) {
		
         var min_width = 1000,
            max_width = 2000,
             min_height = 200,
             max_height = 800;
         FileUploadFactory.validateImageFile($scope,$files,type,min_width,min_height,max_width,max_height);
		
	};
	
	
	$scope.cancel=function()
	{

        $location.path('/admin/listbanners');
	};

	$scope.submit=function()
	{
        loggedUserFactory.userdata().success(function(data){
            if ($scope.myimg)
            {
                BannerFactory.addBanner(data.ssdata.user_id,$scope.banner_name,$scope.myimg)
                    .success(function(data){

                        if(data.code==200)
                        {
                            alert('Banner Added Successfully');
                            $location.path('/admin/listbanners');
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