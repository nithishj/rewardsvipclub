app.controller('rewardsCtrl',['$scope','$location','RewardsFactory', function($scope, $location,RewardsFactory)
{

     $scope.rewards_lists = [];
    
    $scope.get_rewards_list = function(){
         // remove previous array                       
        $scope.rewards_lists.splice(0,$scope.rewards_lists.length);
        $scope.rewards_lists = RewardsFactory.getRewardsHistory();
        
    };
    // get rewards history list                         
    $scope.get_rewards_list();
   




}]);