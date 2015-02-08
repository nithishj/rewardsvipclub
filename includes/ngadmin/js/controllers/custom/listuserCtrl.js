app.controller('listuserCtrl',['$scope', 'ListUserFactory' , '$modal', function($scope, ListUserFactory ,$modal )
{

 ListUserFactory.users()
                .success(function(data) {
				    $scope.users=data;
				    //alert(JSON.stringify(data));
             });
			 
			
			 
		$scope.open = function (size,uid) 
		{
		
		ListUserFactory.getemail(uid)
		.success(function(data){
			 $scope.bindmail=data;
			 $scope.uid=uid;
		});
	
		$scope.uid=uid;
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/modal.html',
		controller: 'myModalCtrl',
		size: size,
		scope:$scope
		});
		};
		
		$scope.opendel=function(size,id,name)
		{
		$scope.delid=id;
		$scope.delname=name;
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/delmodal.html',
		controller: 'myModalCtrl',
		size: size,
		scope:$scope
		});
		
	    };
		
		$scope.openPushNotifications=function(size)
		{
		    var modalInstance = $modal.open({
			templateUrl: 'includes/ngadmin/tpl/pushNtfyModal.html',
			controller: 'myModalCtrl',
			size: size,
			scope:$scope
			});
		
	    };
		
		$scope.changestat=function(id)
		{
		
		var stat=$('#stat'+id).text();
		if(stat=='Pending')
		return false;
		
		if(stat=='Active')
		{
		$('#stat'+id).removeClass();
		$('#stat'+id).addClass('label bg-warning');
		$('#stat'+id).text('Suspended');
		}
		else
		{
		$('#stat'+id).removeClass();
		$('#stat'+id).addClass('label bg-success');
		$('#stat'+id).text('Active');
		}
		
		ListUserFactory.setStatus(id,stat)
		.success(function(data){
		});
		
		};


}])
.controller('myModalCtrl', ['$scope', '$modalInstance','ListUserFactory', 'loggedUserFactory', 'FileUploadFactory',
  function($scope, $modalInstance, ListUserFactory, loggedUserFactory, FileUploadFactory) {
  $scope.showmsg=false;
  $scope.showemsg=false;
  $scope.msgcontent="";
  $scope.btype="push";
  $scope.imuploading=false;
  $scope.aduploading=false;
  $scope.vduploading=false;
  $scope.vtuploading=false;
  $scope.imfinish=false;
  $scope.adfinish=false;
  $scope.vdfinish=false;
  $scope.vtfinish=false;
  
  
  $scope.setcolor=function(id)
  {
  $scope.colid=id;
  
    ListUserFactory.getcolor(id)
				   .success(function(data)
				   {
				    //alert(JSON.stringify(data));
					$scope.chosencolor=data.rgb;
					$scope.chosenimg=data.color_image;
				   });
 //alert("hello");
  };



      $scope.onFileSelect = function($files,type) {
          $scope.showemsg=false;
          FileUploadFactory.uploadFile($scope,$files,type);

      }
  
ListUserFactory.getcolorids()
	  .success(function(data){
	  $scope.colorcodes=data;
	 // alert(JSON.stringify(data));
	  });
  
$scope.ok = function() {

if($('#emtxt').text().trim().length>0)
{
  ListUserFactory.sendmail($scope.uid,$('#emtxt').text())
	  .success(function(data){
	  if(data.code==200)
	  $modalInstance.close();
	  else
		{
		$scope.showmsg=true;
		$scope.errmsg="Message cannot be empty";
		}
	  });

}
else	
{
$scope.showmsg=true;
$scope.errmsg="Message cannot be empty";
} 
};
	$scope.confirmdel=function()
	{

	  ListUserFactory.deleteuser($scope.delid)
	  .success(function(data){
	          
			alert('user deleted successfully');
			$('#Vip'+$scope.delid).hide();
		});
	  $modalInstance.close();
	};
	
	$scope.cancel=function()
	{
	$modalInstance.close();

	};
	
	
	$scope.sendNotification = function(){
    if($scope.msgcontent.trim().length>5)
	{
	
	/* alert($scope.myvid);
	alert($scope.myaudi);
	alert($scope.mythumb);
	alert($scope.myimg);
	alert($scope.btype);
	alert($scope.colid); */
	
    $scope.showemsg=false;
	//getting userid from session
	loggedUserFactory.userdata()
                .success(function(data) 
				{
                  var userid=data['ssdata']['user_id'];  
				   ListUserFactory.pushmessage(userid,$scope.msgcontent.trim(),$scope.btype,$scope.colid,$scope.myimg,$scope.myaudi,$scope.myvid,$scope.mythumb)
                .success(function(data) {
				    //alert(JSON.stringify(data));
				    if(data.code==200)
					{
					  $modalInstance.close();
					}
					else
					{
					  alert(JSON.stringify(data));
					}
             });
				  
				  
				 }); 
	
	
	 
	}
	
	else
	{
	$scope.showemsg=true;
	$scope.emsg="Required atleast 5 characters"
	}
	}
	
	/* $("textarea[maxlength].maxlength, input[maxlength].maxlength").keypress(function(event){
            var key = event.which;
              
            //all keys including return.
            if(key >= 33 || key == 13 || key == 32) {
                var maxLength = $(this).attr("maxlength");
                var length = this.value.length;
                if(length >= maxLength) {                    
                    event.preventDefault();
                }
            }
        }); */
  }
  ]);