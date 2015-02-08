
(function() {
    var OfferFactory = function($http) {
    
        var factory = {};
        
		factory.getoffers=function() {
		return $http.get('offer_admin/listoffers');
		}
		
		factory.addOffer=function(user_id,name,desc,points,image_url) {

		var dd={userid:user_id,OfferName:name,Description:desc,Points:points,image:image_url};
		return $http.post('offer_admin/addoffer?format=json',dd);

		}
        
        return factory;
    };
    
    OfferFactory.$inject = ['$http'];
        
    app.factory('OfferFactory', OfferFactory);
                                           
}());