app.controller('newsMsgCtrl',['$scope','$location', '$modal', 'MessageFactory', 'loggedUserFactory', function($scope, $location, $modal, MessageFactory, loggedUserFactory)
{
 $scope.Addbroadcastid=[];
 $scope.disdel=true;
 
		MessageFactory.pushmessages('news')
		.success(function(data){
		$scope.msgs=data;
		});
		
		$scope.openimg = function (size,imgurl) 
		{
		$scope.vidurl="";
		$scope.imgurl=imgurl;
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/pushmsgmodal.html',
		controller: 'PushModalCtrl',
		size: size,
		scope:$scope
		});
		};
		
		$scope.openvid=function(size,vidurl)
		{
		$scope.imgurl="";
		$scope.vidurl=vidurl;
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/pushmsgmodal.html',
		controller: 'PushModalCtrl',
		size: size,
		scope:$scope
		});
		};
		
		$scope.opendeleteall=function(size)
		{
	
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/pushmsgdel.html',
		controller: 'PushModalCtrl',
		size: size,
		scope:$scope
		});
		};
		
		$scope.opendelete=function(size,delid)
		{
		$scope.delid=delid;
		var modalInstance = $modal.open({
		templateUrl: 'includes/ngadmin/tpl/pushmsgdelsingle.html',
		controller: 'PushModalCtrl',
		size: size,
		scope:$scope
		});
		};
		
		
		
		$scope.pushbroad=function(broadcastid)
		{
	
		 // alert(broadcastid);
			if ($scope.Addbroadcastid.indexOf(broadcastid) == -1) {
			$scope.Addbroadcastid.push(broadcastid);
			}
			else
			{
			var index = $.inArray(broadcastid, $scope.Addbroadcastid);
			$scope.Addbroadcastid.splice(index, 1);
			//$scope.storeidAdd.push(StoreId);
			}
			
			if ($scope.Addbroadcastid.length == 0) 
			 $scope.disdel=true;
			 else
			 $scope.disdel=false;
			//alert($scope.Addbroadcastid);
		};
		
		$scope.repush=function(broadcastid)
		{
		//gettting userid of repush user from session 
		 loggedUserFactory.userdata()
                .success(function(data) 
				{
                  var userid=data['ssdata']['user_id'];  
				  
				  //repushing 
				  MessageFactory.repush(broadcastid,userid )
                .success(function(data) 
				{
				      //reloading data after repushing
						MessageFactory.pushmessages('news')
						.success(function(data){
						$scope.msgs=data;
						alert("Repushed successfully");
						});  
				});	  
		    });
		};

}]);