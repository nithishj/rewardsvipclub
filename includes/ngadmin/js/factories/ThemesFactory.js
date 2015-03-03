
(function() {
    
	var ThemesFactory = function($http) {
    
        var factory = {};
		        
		// All Rewards
		factory.getThemes=function()
		{
		    
            return $http.get('admin_themes/listthemes');

		}

		// Add Theme
		factory.addTheme=function(user_id,theme_image)
		{
		    
            return $http.post('admin_themes/addtheme?format=json',{
            UserId:user_id,
            Image:theme_image    
            });
			
		}
		
   
         // Rewards history
        factory.removeTheme=function(theme_ids)
		{
		    
            return $http.post('admin_themes/deletetheme?format=json',{
            ThemeId:theme_ids
            });
			
		}
		
		
        return factory;
    };
	   
    ThemesFactory.$inject = ['$http'];
        
    app.factory('ThemesFactory', ThemesFactory);
                                           
}());