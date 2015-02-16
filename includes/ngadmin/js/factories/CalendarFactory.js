
(function() {
    
	var CalendarFactory = function($http) {
    
        var factory = {};
		

//		factory.deletemsg=function(broadcastid) {
//		return $http.post('admin_messages/delbroadcast?format=json',{broadcastid:broadcastid});
//		}
		
		// All Events
		factory.getEvents=function()
		{
		    
            return $http.get('events_admin/getevents');
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
	   
    CalendarFactory.$inject = ['$http'];
        
    app.factory('CalendarFactory', CalendarFactory);
                                           
}());