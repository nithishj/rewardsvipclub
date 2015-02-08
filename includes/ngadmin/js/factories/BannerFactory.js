
(function() {
    var BannerFactory = function($http) {
    
        var factory = {};
        
		factory.getbanners=function() {
		return $http.get('banner_admin/listbanners');
		}
		
		factory.addBanner=function(user_id,name,image_url) {

		var dd={userid:user_id,BannerName:name,image:image_url};
		return $http.post('banner_admin/addbanner?format=json',dd);

		}


        factory.deletebanner=function(bannerid) {

            var dd={Bannerid:bannerid};
            //alert(JSON.stringify(dd));
            return $http.post('banner_admin/deletebanner?format=json',dd);
        }

        return factory;
    };
    
    BannerFactory.$inject = ['$http'];
        
    app.factory('BannerFactory', BannerFactory);
                                           
}());