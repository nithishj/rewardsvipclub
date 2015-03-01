app.controller('addschedulepushCtrl',['$scope', '$modal', 'SchedulePushFactory', 'loggedUserFactory', '$stateParams', '$location', function($scope ,$modal, SchedulePushFactory, loggedUserFactory, $stateParams, $location)
{

$scope.heading="Add";


$scope.cancel=function()
{
$location.path('/admin/schedulepush');
};

//***********************date picker config functions************************//
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
//*****************************************************************************//

//***************************time picker config functions**********************//

$scope.mytime = new Date();

$scope.hstep = 1;
$scope.mstep = 1;
$scope.ismeridian = true;

//****************************************************************************//

$scope.showdate=false;
$scope.showday=false;
$scope.showtime=false;



$scope.atype=[{"id":1,"type":"Once"},{"id":2,"type":"Every Week"},{"id":3,"type":"Every Day"}];
$scope.weekdays=[{id:1,name:"Monday"},{id:2,name:"Tuesday"},{id:3,name:"Wednesday"},{id:4,name:"Thursday"},{id:5,name:"Friday"},{id:6,name:"Satday"},{id:7,name:"Sunday"}];

var options = {
    weekday: "long", year: "numeric", month: "short",
    day: "numeric", hour: "2-digit", minute: "2-digit"
}; 

if($stateParams.id)
{
SchedulePushFactory.getpush($stateParams.id).success(function(data){

$scope.message=data[0].AlertMessage;
$scope.alerttype=data[0].AlertType;
$scope.typechange();
//alert(JSON.stringify(data));
$scope.psid=data[0].PushScheduleId;
var wday=(data[0].AlertDay)?(parseInt(data[0].AlertDay)-1):'';
$scope.weekday=(wday)?$scope.weekdays[wday].id:'';
$scope.dt=data[0].AlertDate;
$scope.mytime=data[0].AlertTime;

});

};


$scope.typechange=function()
{
if($scope.alerttype==1)
{
$scope.showdate=true;
$scope.showday=false;
$scope.showtime=true;
$scope.alerttype=$scope.atype[0].id;
}
else if($scope.alerttype==2)
{
$scope.showdate=false;
$scope.showday=true;
$scope.showtime=true;

$scope.alerttype=$scope.atype[1].id;
//alert($scope.alerttype);

}
else if($scope.alerttype==3)
{
$scope.showdate=false;
$scope.showday=false;
$scope.showtime=true;
$scope.alerttype=$scope.atype[2].id;
}

};

$scope.submit=function()
{
if(!$scope.alerttype)
{
alert("Please choose alert type");
return false;
}
if($scope.alerttype==1 && (!$scope.dt || !$scope.mytime))
alert("Please choose a date");
else if($scope.alerttype==2 && (!$scope.weekday || !$scope.mytime))
alert("Please choose a day ");
else if($scope.alerttype==3 && !$scope.mytime)
alert("Please choose time");
else
{
loggedUserFactory.userdata().success(function(data){
//alert($scope.mytime);
//$scope.mytime=$scope.mytime.toLocaleTimeString();
//alert($scope.mytime);
//alert($scope.dt);
if($stateParams.id)
{

SchedulePushFactory.editpush($scope.psid,data.ssdata.user_id,$scope.message,$scope.alerttype,$scope.dt,$scope.mytime,$scope.weekday).success(function(data){

//alert(JSON.stringify(data));
$location.path('/admin/schedulepush');
});

}
else
{

SchedulePushFactory.addpush(data.ssdata.user_id,$scope.message,$scope.alerttype,$scope.dt,$scope.mytime,$scope.weekday).success(function(data){
//alert(JSON.stringify(data));
$location.path('/admin/schedulepush');
});

}

});
}

};

}]);