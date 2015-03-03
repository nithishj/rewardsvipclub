
(function() {
    var FileUploadFactory = function($http,$upload,toaster) {
    
        var factory = {};
        
      
		
		factory.getmyfile=function(dd)
		{
		  return $http.post('admin_users/getmyfile?format=json',dd);
		}
        
		factory.uploadFile=function($scope,$files,type) {
            $scope.showemsg=false;
			
		 angular.forEach($files, function ($file, i) {
                //var $file = $files[i];
				alert($file.type);
                if (window.FileReader && (($file.type.indexOf('image') > -1 && (type=='image'||type=="theme")) || ($file.type.indexOf('text') > -1 && type=='csv') || ($file.type.indexOf('video') > -1 && type=='video') || ($file.type.indexOf('audio') > -1 && type=='audio') || ($file.type.indexOf('image') > -1 && type=='videothumb'))) 
				{
				   //alert($scope.vduploading);
                     
						if(type=="image"||type=="theme"||type=="csv")
						$scope.imuploading=true;
						if(type=="video")
						$scope.vduploading=true;
						if(type=="audio")
						$scope.aduploading=true;
						if(type=="videothumb")
						$scope.vtuploading=true;
				
					var fileReader = new FileReader();
					fileReader.onload = (function (file) {

					return function (e) {
					var dd={ name1: $file.name.replace(" ","_"),type: type, ext:$file.type.split('/')[1].toLowerCase(),value: this.result };
					$scope.$apply(function(){
				
                   factory.getmyfile(dd)
				   .success(function(data)
				   {
                       $scope.errmsg=""; // remove previous error msg
				   
				   if(data.type=="image"||data.type == "theme"||data.type=="csv")
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
        
         factory.validateImageFile = function($scope,files,type,width,height) {

            
         if (window.FileReader && (files[0].type.indexOf('image') > -1 ))
         {
           
            var reader = new FileReader();
            var img = new Image();
            
            reader.onload = function (e) {
                img.src = e.target.result;
                img.onload = function () {
                   
                if(type == "theme"){
                   
                    if(this.width == width && this.height == height){
                        factory.uploadFile($scope,files,type);
                         
                        
                    }else
                    {
                        
                       alert("Invalid Image Resolution");
                        toaster.pop("error", "Error", "Invalid Image Resolution");
                       
                    }
                }else{
                    if(this.width > width && this.height > height){
                        factory.uploadFile($scope,files,type);
                        
                    }else
                    {
                        
                       alert("Invalid Image Resolution");
                        toaster.pop("error", "Error", "Invalid Image Resolution");
                       
                    }
                
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
	   
    FileUploadFactory.$inject = ['$http','$upload','toaster'];
        
    app.factory('FileUploadFactory', FileUploadFactory);
                                           
}());