
(function() {
    var FileUploadFactory = function($http,$upload) {
    
        var factory = {};
        
      
		
		factory.getmyfile=function(dd)
		{
		  return $http.post('admin_users/getmyfile?format=json',dd);
		}
        
		factory.uploadFile=function($scope,$files,type) {
            
			
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
				
                   factory.getmyfile(dd)
				   .success(function(data)
				   {
                       $scope.errmsg=""; // remove previous error msg
				   
				   if(data.type=="image")
				   {
				   $scope.myimg=data.filepath;
				   $scope.imuploading=false;
				   $scope.imfinish=true;
                   $scope.imguploaded=true; //showing image preview after file upload
                  // $("#preview_image").attr("src",data.filepath).show();
				   
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
					$scope.errmsg="Not a Valid File";

                }
            }); 
		}
        
          factory.validateImageFile = function($scope,files,type,min_width,min_height,max_width,max_height) {

            
         if (window.FileReader && (files[0].type.indexOf('image') > -1 ))
         {
            
            var reader = new FileReader();
            var img = new Image();
            
            reader.onload = function (e) {
                img.src = e.target.result;
                img.onload = function () {
                   
                    if((this.width > min_width && this.height > min_height) && (this.width < max_width && this.height < max_height)){
                        factory.uploadFile($scope,files,type);
                        
                    }else
                    {
                        
                       alert("Invalid Image Resolution");
                       
                    }
                    
                };
            };
            reader.readAsDataURL(files[0]);
            
             
         }else{
            
             $scope.errmsg="Invalid Format";
             
             $scope.imfinish=false;
             
         }
            
        };
        
         
		
        return factory;
    };
	   
    FileUploadFactory.$inject = ['$http','$upload'];
        
    app.factory('FileUploadFactory', FileUploadFactory);
                                           
}());