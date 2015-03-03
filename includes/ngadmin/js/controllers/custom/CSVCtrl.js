app.controller('CSVCtrl',['$scope','$location','$timeout','$modal','toaster','FileUploadFactory', function($scope, $location,$timeout,$modal,toaster,FileUploadFactory)
{

   
    
    $scope.onFileSelect = function($files,type) {
		
         FileUploadFactory.uploadFile($scope,$files,type);
		
	};
	

   /* Toaster type: 
        success,info,wait,warning,error
   */
 $scope.showToaster= function(type,title,msg){
    toaster.pop(type, title, msg);
 }
 

}]);



