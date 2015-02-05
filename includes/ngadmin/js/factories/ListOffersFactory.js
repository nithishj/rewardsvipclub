
(function() {
    var ListOffersFactory = function($http) {
    
        var factory = {};
        
        
		
		factory.addOffer=function(offer_name,offer_desc,offer_code,offer_points) {
		
		var dd={offer_name:offer_name,offer_desc:offer_desc,offer_code:offer_code,offer_points:offer_points};
		return $http.post('add_offer/?format=json',dd);
		}
		
		
        return factory;
    };
	   
    ListOffersFactory.$inject = ['$http'];
        
    app.factory('ListOffersFactory', ListOffersFactory);
                                           
}());