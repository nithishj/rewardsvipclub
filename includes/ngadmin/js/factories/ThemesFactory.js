
(function() {
    
	var ThemesFactory = function($http) {
    
        var factory = {};
		        
		// All Rewards
		factory.getThemes=function()
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

		// Add Theme
		factory.addTheme=function(user_id,theme_image)
		{
		    
            return $http.post('starrewards_admin/addstarreward?format=json',{
            UserId:user_ids
                
            });
			
		}
		
   
         // Rewards history
        factory.removeTheme=function(ids)
		{
		    
            return $http.post('starrewards_admin/addstarreward?format=json',{
            ThemeIds:user_ids
                
            });
			
		}
		
		
        return factory;
    };
	   
    ThemesFactory.$inject = ['$http'];
        
    app.factory('ThemesFactory', ThemesFactory);
                                           
}());