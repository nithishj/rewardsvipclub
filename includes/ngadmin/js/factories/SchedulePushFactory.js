
(function() {
    var SchedulePushFactory = function($http) {
    
        var factory = {};
        

        factory.getpush=function() {
            
            return $http.get('schedulepush_admin/getpush');
        }

        return factory;
    };
    
    SchedulePushFactory.$inject = ['$http'];
        
    app.factory('SchedulePushFactory', SchedulePushFactory);
                                           
}());