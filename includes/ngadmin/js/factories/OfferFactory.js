
(function() {
    var OfferFactory = function($http) {
    
        var factory = {};
        
		factory.getoffers=function() {
		return $http.get('offer_admin/listoffers');
		}
		
		factory.addOffer=function(offer_name,offer_desc,offer_code,offer_points) {

		var dd={offer_name:offer_name,offer_desc:offer_desc,offer_code:offer_code,offer_points:offer_points};
		return $http.post('offer_admin/addoffer?format=json',dd);
		}


        factory.deleteoffer=function(offerid) {

            var dd={offerid:offerid};
            //alert(JSON.stringify(dd));
            return $http.post('offer_admin/deleteoffer?format=json',dd);
        }

        return factory;
    };
    
    OfferFactory.$inject = ['$http'];
        
    app.factory('OfferFactory', OfferFactory);
                                           
}());