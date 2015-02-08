
(function() {
    var OfferFactory = function($http) {
    
        var factory = {};
        
		factory.getoffers=function(id) {
		return $http.get('offer_admin/listoffers/'+id);
		}
		
		factory.addOffer=function(user_id,name,desc,points,image_url) {

		var dd={userid:user_id,OfferName:name,Description:desc,Points:points,image:image_url};
		return $http.post('offer_admin/addoffer?format=json',dd);

		}

        factory.editOffer=function(user_id,offerid,name,desc,points,image_url) {

            var dd={userid:user_id,OfferId:offerid,OfferName:name,Description:desc,Points:points,image:image_url};
            return $http.post('offer_admin/editoffer?format=json',dd);

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