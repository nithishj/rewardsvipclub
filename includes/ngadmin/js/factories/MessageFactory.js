
(function() {
    var MessageFactory = function($http) {
    
        var factory = {};
        
        factory.pushmessages = function(type) {
            return $http.post('admin_messages/getpushmessages?format=json',{type:type});
        };
        
		factory.newsmessages=function(userid) {
		return $http.get('admin_messages/getnewsmessages');
		}
		
		factory.deletemsg=function(broadcastid) {
		return $http.post('admin_messages/delbroadcast?format=json',{broadcastid:broadcastid});
		}
		
		factory.repush=function(broadcastid,userid) {
		return $http.post('admin_messages/clonebroadcast?format=json',{broadcastid:broadcastid,userid:userid});
		}
	
		
		/* factory.pushmessage=function(msg) {
		return $http.post('admin_users/pushmessage?format=json',{msg:msg});
		} */
		 
        return factory;
    };
	   
    MessageFactory.$inject = ['$http'];
        
    app.factory('MessageFactory', MessageFactory);
                                           
}());