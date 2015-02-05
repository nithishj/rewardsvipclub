app.controller('addofferCtrl',['$scope','$location','ListOffersFactory', '$upload', function($scope, $location, ListOffersFactory ,$upload)
{
  
	$scope.offer_code = 98987;
	
	$scope.offerPreview = function($files){
		alert("In Add Offer"+JSON.stringify($files));
		
		$("#offer_preview_img").attr("src",$files.name).show();
		 angular.forEach($files, function ($file, i) {
                //var $file = $files[i];
				//alert($file.type.indexOf('video'));
                if (window.FileReader && (($file.type.indexOf('image') > -1 && type=='image') || ($file.type.indexOf('video') > -1 && type=='video') || ($file.type.indexOf('audio') > -1 && type=='audio') || ($file.type.indexOf('image') > -1 && type=='videothumb'))) 
				{
				   //alert($scope.vduploading);
				    if(type=="image")
				   $scope.imuploading=true;
				   
				
					var fileReader = new FileReader();
					fileReader.onload = (function (file) {

					return function (e) {
					var dd={ name1: $file.name.replace(" ","_"),type: type, ext:$file.type.split('/')[1].toLowerCase(),value: this.result };
					$scope.$apply(function(){
				
                   ListUserFactory.getmyfile(dd)
				   .success(function(data)
				   {
				   
				   if(data.type=="image")
				   {
				   $scope.myimg=data.filepath;
				   $scope.imuploading=false;
				   $scope.imfinish=true;
				   
				   }
				   else if(data.type=="video")
				   {
				   $scope.myvid=data.filepath;
				   $scope.vduploading=false;
				   $scope.vdfinish=true;
				   }
				   else if(data.type=="audio")
				   {
				   $scope.myaudi=data.filepath;
				   $scope.aduploading=false;
				   $scope.adfinish=true;
				   }
				   else if(data.type=="videothumb")
				   {
				   $scope.mythumb=data.filepath;
				   $scope.vtuploading=false;
				   $scope.vtfinish=true;
				   }
				   
				  // alert(JSON.stringify(data));
				   });

					});

					};
					})($files[i]);
					// For data URI purposes
					fileReader.readAsDataURL($file);
								
                }
                else 
				{
                 
					$scope.showemsg=true;
					$scope.emsg="Not a Valid File";

                }
            });
		
		
	}
	
	$scope.errmsg="";
	$scope.cancel=function()
	{
	$location.path('/offers');
	};

	$scope.submit=function()
	{
	ListOffersFactory.addOffer($scope.offer_name,$scope.offer_desc,$scope.offer_code,$scope.offer_points)
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
			 
			});

	};

}]);