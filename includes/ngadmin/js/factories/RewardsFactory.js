
(function() {
    
	var RewardsFactory = function($http) {
    
        var factory = {};
		
		var users_list = [
								{id:1, name: 'srinadh korukonda hjghg hghg hghg hgh hg', profile_image:'./user_images/54d65df1ddf26Koala.jpg' },
								{id:2, name: 'basantth varma', profile_image:'./user_images/54d65cb6eeca1Chrysanthemum.jpg'},
								{id:3, name: 'ganesh sundarapu ', profile_image:'./user_images/54d65df1ddf26Koala.jpg' },
								{id:4, name: 'Nithish ready', profile_image:'./user_images/54d65cb6eeca1Chrysanthemum.jpg'},
                                {id:5, name: 'Nithish ready 12343', profile_image:'./user_images/54d65cb6eeca1Chrysanthemum.jpg'}
						 ];
        var rewards_history = [
        {id:1, name: 'basantth', profile_image:'./user_images/54d65cb6eeca1Chrysanthemum.jpg',msg:'Testing Rewards',points:200},
        {id:1, name: 'varma', profile_image:'./user_images/54d65cb6eeca1Chrysanthemum.jpg',msg:'Testing Rewards',points:200}
        ];
        
        
		// All Rewards
		factory.getRewards=function()
		{
		    
            return $http.get('starrewards_admin/getusers');
            
            // add new event based on obj from local
//            console.log("Add Event factory :");
//            return $http.post('rewards_admin/getrewards?format=json',{
//                query:user_id,
//                users:event_name
//             });
            
			
			//return users_list;
		}
        
        factory.getRewards=function(query_str,users_ids)
		{
            
            // add new event based on obj from local
            
            return $http.post('starrewards_admin/getusers?format=json',{
                query:query_str,
                users:users_ids
             });
            
			
		}
        
        // Rewards history
        factory.getRewardsHistory=function()
		{
		    
            return $http.get('starrewards_admin/getschedulehistory');
		}
        
         // Rewards history
        factory.addStarRewards=function(msg,points,user_ids)
		{
		    
            return $http.post('starrewards_admin/addstarreward?format=json',{
            Message:msg,
            Points:points,
            UserIds:user_ids
                
            });
			
		}
		
		
        return factory;
    };
	   
    RewardsFactory.$inject = ['$http'];
        
    app.factory('RewardsFactory', RewardsFactory);
                                           
}());