app.controller('rewardsCtrl',['$scope','$location','$modal','RewardsFactory', function($scope, $location,$modal,RewardsFactory)
{

     $scope.rewards_lists = [];
    
    $scope.get_rewards_list = function(){
         // remove previous array                       
        $scope.rewards_lists.splice(0,$scope.rewards_lists.length);
        RewardsFactory.getRewardsHistory().success(function(data){
            $scope.rewards_lists = data;
            
        });
        
    };
    // get rewards history list                         
    $scope.get_rewards_list();
   

    //$scope.rewards_users_lists
    $scope.openUsersList = function(usersList,size){
        $scope.rewards_users_lists = usersList;
         var modalInstance = $modal.open({
            templateUrl: 'includes/ngadmin/tpl/rewards_user_list_modal.html',
            controller: 'rewardUsersCtrl',
            size: size,
            scope:$scope
        });
        
    };


}]);


app.controller('rewardUsersCtrl', ['$scope', '$location', '$modalInstance','RewardsFactory',
  function($scope, $location, $modalInstance, RewardsFactory) {
      
      $scope.user_cancel = function(){
        $modalInstance.close();
      };
      
  }]);