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
.controller('myModalCtrl', ['$scope', '$modalInstance','ListUserFactory', 'loggedUserFactory', '$upload',
  function($scope, $modalInstance, ListUserFactory, loggedUserFactory, $upload) {
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
	//alert(JSON.stringify($files));
	$scope.showemsg=false;
	
	 angular.forEach($files, function ($file, i) {
                //var $file = $files[i];
				//alert($file.type.indexOf('video'));
                if (window.FileReader && (($file.type.indexOf('image') > -1 && type=='image') || ($file.type.indexOf('video') > -1 && type=='video') || ($file.type.indexOf('audio') > -1 && type=='audio') || ($file.type.indexOf('image') > -1 && type=='videothumb'))) 
				{
				   //alert($scope.vduploading);
				    if(type=="image")
				   $scope.imuploading=true;
				   if(type=="video")
				   $scope.vduploading=true;
				   if(type=="audio")
				   $scope.aduploading=true;
				   if(type=="videothumb")
				   $scope.vtuploading=true;
				   //alert(type);
				   //alert($scope.vduploading);
				
				
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
	
	
	
	};
  
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