app.controller('addRewardCtrl',['$scope','$location','RewardsFactory', function($scope, $location,RewardsFactory)
{

    $scope.users_list = [];
    // default Diable Add users button
    $scope.isDisableButton = true;
    
    $scope.selected_users = [];
    
    $scope.get_users_list = function(){
         // remove previous array                       
        $scope.users_list.splice(0,$scope.users_list.length);
        $scope.users_list = RewardsFactory.getRewards();
        
    };
    // get users list                         
    $scope.get_users_list();
   
    $scope.addNewUsers = function(){
        
        var current_slt_objs = $(".users_container input:checkbox:checked");
        
        if (current_slt_objs.length > 0){
            
             // Diable Add User button
            $scope.isDisableButton = true;
            
            $.each(current_slt_objs,function(index,obj){
               
            var current_obj = JSON.parse($(obj).val());    
            $scope.selected_users.push(current_obj);
                
            $scope.removeItem($scope.users_list,current_obj.id);
            
            
        });
            // remove doc elements
            current_slt_objs.parents("div.well").remove();
        }
        
    };
   
    
    $scope.enableAddUser = function(){
        var checked_objs = $(".users_container input:checkbox:checked")
        if(checked_objs.length == 0)
            $scope.isDisableButton = true;
        
        if(checked_objs.length > 0)
            $scope.isDisableButton = false;
    };
    
    $scope.removeItem = function cleaner(arr, id) {
        for (var i = 0; i < arr.length; i++) {
            var cur = arr[i];
            if (cur.id == id) {
                arr.splice(i, 1);
                break;
            }
        }
    }
    
    
    
    $scope.toggleCheckboxes = function(input){
        var checkbox_objs = $(".users_container input:checkbox")
        switch(input)
        {
            case 0:
                 // Enable Add User button
                $scope.isDisableButton = false;
                checkbox_objs.prop('checked',true);
                
                break;
            case 1:
                 // Diable Add User button
                $scope.isDisableButton = true;
                checkbox_objs.prop('checked',false);
                
                break;
        }
    }   
                    

  $scope.closeAlert = function(index,user) {
    $scope.selected_users.splice(index, 1);
    $scope.users_list.splice(0,0,user);
  };



}]);