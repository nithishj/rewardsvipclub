app.controller('addeventCtrl',['$scope','$location','CalendarFactory','$modal', function($scope, $location,CalendarFactory,$modal)
{
    
    var openEventDialog = function(date){
        
        // open event modal when click on day on calendar
        $scope.openEventModal('md');
        $scope.seletedEventDate = date;
    };
    
    $scope.getFormatedDate = function(date){
        
        newDate = new Date(date);
        var d = newDate.getDate();
        var m = newDate.getMonth()+1;
        var y = newDate.getFullYear();
        
        if(d<10)
            d = '0'+d
        
        if(m < 10)
            m = '0'+m
        
        return d+"-"+m+"-"+y
        
    };

    
    $scope.openEventModal=function(size)
    {
        var modalInstance = $modal.open({
        templateUrl: 'includes/ngadmin/tpl/calendarEventModal.html',
        controller: 'calEventCtrl',
        size: size,
        scope:$scope
    });

    };

    /* event source that pulls from google.com */
    $scope.eventSource = {
        url: "http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic",
        className: 'gcal-event',           // an option!
        currentTimezone: 'America/Chicago' // an option!  America/Chicago
    };
    
     var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    
   
    $scope.events =[];
   
    
    $scope.refreshEvents = function(){
    
        $scope.events.splice(0, $scope.events.length);
       
             // get events from factory
        CalendarFactory.getEvents().success(function(data)
        {
            $.each(data,function(index,obj){
                 $scope.events.push({id:obj.EventId, title:obj.EventName, info:obj.EventDescription, icon:obj.Icon,iconid:obj.IconId, start:new Date(obj.EventDate)});
            });
            

        });
    
    };
    
    $scope.refreshEvents();
    
    // get events from factory
    CalendarFactory.getEventIcons().success(function(data)
    {
        $scope.eventIcons =  data;
        
        //console.log(JSON.stringify($scope.eventIcons));
                           
    });
    

    /* alert on dayClick */
    $scope.precision = 400;
    $scope.lastClickTime = 0;
    $scope.alertOnEventClick = function( date, jsEvent, view ){

        var time = new Date().getTime();
        if(time - $scope.lastClickTime <= $scope.precision){
            // pass clickable date
            openEventDialog($scope.getFormatedDate(date));
            $scope.isFromAction ="add";
            
            // clear modal previous data
        $scope.event_id = "";
        $scope.event_name = "";
        $scope.event_desc = "";
        $scope.dt = "";
        $scope.chosenicon = "";
        $scope.choseniconID = "";
            
            
            
    }
    $scope.lastClickTime = time;
    };
    

    $scope.overlay = $('.fc-overlay');
    $scope.alertOnMouseOver = function( event, jsEvent, view ){
          $scope.event = event;
       
          $scope.overlay.removeClass('left right').find('.arrow').removeClass('left right top pull-up');
          var wrap = $(jsEvent.target).closest('.fc-event');
          var cal = wrap.closest('.calendar');
          var left = wrap.offset().left - cal.offset().left;
          var right = cal.width() - (wrap.offset().left - cal.offset().left + wrap.width());
          if( right > $scope.overlay.width() ) { 
            $scope.overlay.addClass('left').find('.arrow').addClass('left pull-up')
          }else if ( left > $scope.overlay.width() ) {
            $scope.overlay.addClass('right').find('.arrow').addClass('right pull-up');
          }else{
            $scope.overlay.find('.arrow').addClass('top');
          }
          (wrap.find('.fc-overlay').length == 0) && wrap.append( $scope.overlay );
        
    }
    
    
    

    /* config object */
    $scope.uiConfig = {
      calendar:{
        height: 450,
        editable: false,
        header:{
          left: 'prev',
          center: 'title',
          right: 'next'
        },
        dayClick: $scope.alertOnEventClick,
        eventMouseover: $scope.alertOnMouseOver
      }
    };
    
    /* add custom event*/
    $scope.addEvent = function() {
       
         // pass current date
            openEventDialog($scope.getFormatedDate(new Date()));
            $scope.isFromAction = "add";
       
        // clear modal previous data
        $scope.event_id = "";
        $scope.event_name = "";
        $scope.event_desc = "";
        $scope.dt = "";
        $scope.chosenicon = "";
        $scope.choseniconID = "";
    };
    
    $scope.overlayEdit = function(){
        console.log("overlay-->");
    };
    
   
     /* add custom event*/
    $scope.addNewEvent = function(id,title,startDate,desc) {
        
        console.log(" ( Explicit Add event) ------> ");
      $scope.events.push({
        id:id,
        title: title,
        start: startDate,
        info:desc,
        className: ['b-l b-2x b-info']
      });
    };
    
    /* Edit event */
    $scope.edit = function(obj) {
   
       
        $scope.event_id = obj.id;
        $scope.event_name = obj.title;
        $scope.event_desc = obj.info;
        $scope.dt = obj.start;
        $scope.chosenicon = obj.icon;
        $scope.choseniconID = obj.iconid;
        
      
        openEventDialog($scope.getFormatedDate(obj.start));
        $scope.isFromAction = "edit"
      
    };

    /* remove event */
    $scope.remove = function(index,id, size) {
     console.log("Remove Event with index ="+index+", id= "+id);
     // $scope.events.splice(index,1);
      $scope.delid = id;
      $scope.delname="Event";
      $scope.delindex=index;   
        
        var modalInstance = $modal.open({
            templateUrl: 'includes/ngadmin/tpl/delmodal.html',
            controller: 'calEventCtrl',
            size: size,
            scope:$scope
        });    
        
    };
    

    /* Change View */
    $scope.changeView = function(view, calendar) {
      $('.calendar').fullCalendar('changeView', view);
    };

    $scope.today = function(calendar) {
      $('.calendar').fullCalendar('today');
    };

    
   
    
         /* event sources array*/
    $scope.eventSources = [$scope.events];
    

}]);



// Event modal controller


app.controller('calEventCtrl', ['$scope', '$modalInstance','CalendarFactory','loggedUserFactory',
  function($scope, $modalInstance, CalendarFactory,loggedUserFactory) {
      
      $scope.setIcon=function(icnObj)
      {
    
          $scope.chosenicon = icnObj.Icon;
          $scope.choseniconID = icnObj.IconId;
      };
    
    // Action is Add || Edit
    if( $scope.isFromAction == "add" ){
        
        $scope.event_header_icon = "fa fa-plus fa-lg";  
        $scope.header = "Add ";
        
    }else{
        
        $scope.event_header_icon = "fa fa-edit fa-lg";
        $scope.header = "Edit ";
    }
          
    
    $scope.cancel=function()
    {
          
       $modalInstance.close();
    };
      
    $scope.confirmdel=function()
    {
       $scope.events.splice($scope.delindex,1);
        CalendarFactory.deleteEvent($scope.delid).success(function(data){
         console.log(JSON.stringify(data));
         $modalInstance.close();
        });

    }
      
    $scope.submitEvent = function() {
        

        // Action is Add or Edit
        if( $scope.isFromAction == "add" ){

            //$scope.addNewEvent(10,$scope.event_name,$scope.dt,$scope.event_desc);
            
             
            
            loggedUserFactory.userdata().success(function(data){
            
                CalendarFactory.addEvent(data.ssdata.user_id,$scope.event_name,$scope.event_desc,$scope.choseniconID,$scope.dt).success(function(data){
   
    $scope.refreshEvents();                
    $modalInstance.close();
                });
                

            });
            
            
        }else{

      
          loggedUserFactory.userdata().success(function(data){
            
                CalendarFactory.editEvent( $scope.event_id,data.ssdata.user_id,$scope.event_name,$scope.event_desc,$scope.choseniconID,$scope.dt).success(function(data){
   
    $scope.refreshEvents();                
    $modalInstance.close();
                });
                

            });  
  
           
    }
    };

    $scope.today = function() {
        $scope.dt = $scope.seletedEventDate;
    };


    $scope.clear = function () {
        $scope.dt = null;
    };

    $scope.toggleMin = function() {
        $scope.minDate = $scope.minDate ? null : new Date();
    };

    $scope.toggleMin();

    $scope.open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = true;
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd-MM-yyyy', 'shortDate'];
    $scope.format = $scope.formats[2];
    $scope.today();
  
  }]);