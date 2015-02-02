
(function() {
    var loggedUserFactory = function($http) {
    
        var factory = {};
        
        factory.logout = function() {
            return $http.get('admin/logout');
        };
        
        factory.userdata = function(userId) {
            return $http.get('admin/sessionvalues');
        };
        
        return factory;
    };
    
    loggedUserFactory.$inject = ['$http'];
        
    app.factory('loggedUserFactory', loggedUserFactory);
                                           
}());