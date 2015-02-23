app.controller('addschedulepushCtrl',['$scope', '$modal', 'SchedulePushFactory', 'loggedUserFactory', '$stateParams', '$location', function($scope ,$modal, SchedulePushFactory, loggedUserFactory, $stateParams, $location)
{

$scope.heading="Add";


$scope.cancel=function()
{
$location.path('/schedulepush');
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

if($stateParams.id)
{
SchedulePushFactory.getpush($stateParams.id).success(function(data){

alert(JSON.stringify(data));

});

};


$scope.typechange=function()
{
if($scope.alerttype==1)
{
$scope.showdate=true;
$scope.showday=false;
$scope.showtime=true;
}
else if($scope.alerttype==2)
{
$scope.showdate=false;
$scope.showday=true;
$scope.showtime=true;
}
else if($scope.alerttype==3)
{
$scope.showdate=false;
$scope.showday=false;
$scope.showtime=true;
}

};

$scope.submit=function()
{
var options = {
    weekday: "long", year: "numeric", month: "short",
    day: "numeric", hour: "2-digit", minute: "2-digit"
};
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
$scope.mytime=$scope.mytime.toLocaleTimeString("en-us", options);
SchedulePushFactory.addpush(data.ssdata.user_id,$scope.message,$scope.alerttype,$scope.dt,$scope.mytime,$scope.weekday).success(function(data){

alert(JSON.stringify(data));
});

});
}

};

}]);