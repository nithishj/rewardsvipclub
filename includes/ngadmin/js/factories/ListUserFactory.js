
(function() {
    var ListUserFactory = function($http) {
    
        var factory = {};
        
        factory.users = function() {
            return $http.get('admin/listusers');
        };
        /*
        factory.userdata = function(userId) {
            return $http.get('admin/sessionvalues');
        };
		*/
		factory.getemail=function(userid) {
		return $http.get('admin_users/getemail/'+userid);
		}
		
		factory.deleteuser=function(userid) {
		return $http.get('admin_users/deleteuser/'+userid);
		}
		
		factory.setStatus=function(id,stat) {
		return $http.get('admin_users/setStatus/'+id+'/'+stat);
		}
		
		factory.addUser=function(name,email,role,gender) {
		//return $http.get('admin_users/plususer/'+encodeURIComponent(name)+'/'+encodeURIComponent(email)+'/'+encodeURIComponent(role)+'/'+encodeURIComponent(gender));
		return $http.post('admin_users/plususer?format=json',{username:name,email:email,role:role,gender:gender}); 
	    }
		
		factory.sendmail=function(id,msg) {
		//return $http.get('admin_users/plususer/'+encodeURIComponent(name)+'/'+encodeURIComponent(email)+'/'+encodeURIComponent(role)+'/'+encodeURIComponent(gender));
		return $http.post('admin_users/sendmail?format=json',{to_id:id,message:msg}); 
	    }
		
		factory.pushmessage=function(msg) {
		return $http.post('admin_users/pushmessage?format=json',{msg:msg});
		}
		 
        return factory;
    };
	   
    ListUserFactory.$inject = ['$http'];
        
    app.factory('ListUserFactory', ListUserFactory);
                                           
}());