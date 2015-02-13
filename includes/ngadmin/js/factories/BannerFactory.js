
(function() {
    var BannerFactory = function($http) {
    
        var factory = {};
        
		factory.getbanners=function(id) {
		return $http.get('banner_admin/listbanners/'+id);
		}
		
		factory.addBanner=function(user_id,name,bannerurl,image_url) {

		var dd={UserId:user_id,BannerName:name,BannerUrl:bannerurl,BannerImage:image_url};
		return $http.post('banner_admin/addbanner?format=json',dd);

		}
		factory. editBanner=function(bannerid,user_id,name,bannerurl,image_url) {

		var dd={BannerId:bannerid,UserId:user_id,BannerName:name,BannerUrl:bannerurl,BannerImage:image_url};
		return $http.post('banner_admin/editbanner?format=json',dd);

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