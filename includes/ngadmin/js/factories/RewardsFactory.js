
(function() {
    
	var RewardsFactory = function($http) {
    
        var factory = {};
		
		var users_list = [
								{id:1, name: 'srinadh korukonda ', profile_image:'./user_images/54d65df1ddf26Koala.jpg' },
								{id:2, name: 'basantth varma', profile_image:'./user_images/54d65cb6eeca1Chrysanthemum.jpg'},
								{id:3, name: 'ganesh sundarapu ', profile_image:'./user_images/54d65df1ddf26Koala.jpg' },
								{id:4, name: 'Nithish ready', profile_image:'./user_images/54d65cb6eeca1Chrysanthemum.jpg'}
						 ];
		// All Rewards
		factory.getRewards=function()
		{
		    
            //return $http.get('rewards_admin/getrewards');
			
			return users_list;
		}
		
		// Remove Event
		factory.deleteEvent=function(event_id)
		{
            
		  return $http.post('events_admin/deleteevent?format=json',{EventId:event_id});
		}
		
		// Add Event
		factory.addEvent=function(user_id,event_name,event_desc,iconID,date)
		{
            // add new event based on obj from local
            console.log("Add Event factory :");
            return $http.post('events_admin/addevent?format=json',{
    UserId:user_id,
    EventName:event_name,
    EventDescription:event_desc,
    IconId:iconID,
    EventDate:date});
		}
		
		// Edit Event
		factory.editEvent=function(event_id,user_id,event_name,event_desc,iconID,date)
		{
            // edit event based on obj from local
		  console.log('edit Event factory: ');
            return $http.post('events_admin/editevent?format=json',{
    EventId:event_id,            
    UserId:user_id,
    EventName:event_name,
    EventDescription:event_desc,
    IconId:iconID,
    EventDate:date});
		}
        
        // Get Event icons
        factory.getEventIcons=function()
		{
            // get event icons 
            return $http.get('events_admin/geticons');
		}
		
        return factory;
    };
	   
    RewardsFactory.$inject = ['$http'];
        
    app.factory('RewardsFactory', RewardsFactory);
                                           
}());