
(function() {
    var SchedulePushFactory = function($http) {
    
        var factory = {};
        

        factory.getpush=function(id) {
            
            return $http.get('schedulepush_admin/getpush/'+id);
        }
		
		factory.addpush=function(userid,msg,type,dt,atime,aday) {
		var dd={UserId:userid,AlertMessage:msg,AlertType:type,AlertDate:dt,AlertTime:atime,AlertDay:aday};
		//alert(JSON.stringify(dd));
			 return $http.post('schedulepush_admin/addpush?format=json',dd);
		}
		
		factory.deletepush=function(delid) {
		var dd={SchedulePushId:delid};
		alert(JSON.stringify(dd));
			 return $http.post('schedulepush_admin/deletepush?format=json',dd);
		}

        return factory;
    };
    
    SchedulePushFactory.$inject = ['$http'];
        
    app.factory('SchedulePushFactory', SchedulePushFactory);
                                           
}());