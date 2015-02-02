
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
		
		factory.pushmessage=function(userid,msg,type,color,image,audio,video,thumb) {
		
		var dd={userid:userid,msg:msg,type:type,color:color,image:image,audio:audio,video:video,thumb:thumb};
		return $http.post('admin_users/pushmessage?format=json',dd);
		}
		
		//to get colorids
		factory.getcolorids=function() {
		return $http.get('admin_users/getcolorcodes');
		}
		
		factory.getmyfile=function(dd)
		{
		return $http.post('admin_users/getmyfile?format=json',dd);
		}
		
		//to get color of colorid
		factory.getcolor=function(id)
		{
		return $http.post('admin_users/getcolor?format=json',{id:id});
		}
		
        return factory;
    };
	   
    ListUserFactory.$inject = ['$http'];
        
    app.factory('ListUserFactory', ListUserFactory);
                                           
}());