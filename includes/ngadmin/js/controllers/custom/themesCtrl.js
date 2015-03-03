app.controller('themesCtrl',['$scope','$location','$timeout','ThemesFactory','$modal','toaster','FileUploadFactory','loggedUserFactory', function($scope, $location,$timeout,ThemesFactory,$modal,toaster,FileUploadFactory,loggedUserFactory)
{

    $scope.themes_list = [];
    // default Diable Add users button
    $scope.isDisableButton = true;
   
    $scope.selected_themes = [];
    $scope.selected_theme = [];
    $scope.sltd_tms = 0;
    
    $scope.getIdsFromJSON = function(arr){
        arrIds = [];
        for(var i=0;i<arr.length;i++){
        
            arrIds.push(arr[i].id);
        }
        
        return arrIds;
    };
    
    $scope.onFileSelect = function($files,type) {
		
         var width = 1242,
            height = 2208;
         FileUploadFactory.validateImageFile($scope,$files,type,width,height);
		
	};
	
    
    $scope.get_themes_list = function(){
         // remove previous array                       
        $scope.themes_list.splice(0,$scope.themes_list.length);
        
        ThemesFactory.getThemes().success(function(data){
            
                $scope.themes_list = data;

        
        });
        
       
        
    };
    // get Themes list                         
    $scope.get_themes_list();
   
    $scope.removeSltdThemes = function(){
        
         var current_slt_objs = $(".themes_container input:checkbox:checked");
        
        if (current_slt_objs.length > 0){
           // Diable Add User button
            $scope.isDisableButton = true;
            
            $.each(current_slt_objs,function(index,obj){
               
            var current_obj = JSON.parse($(obj).val());    
            $scope.selected_themes.push(current_obj);
                
            $scope.removeItem($scope.themes_list,current_obj.id);
            
            
            });
            // remove doc elements
            current_slt_objs.parents("div.well").remove();
        }
            
    }
    
    $scope.removeTheme = function(){
        
        var current_slt_objs = $(".themes_container input:checkbox:checked");
        
        if (current_slt_objs.length > 0){
            
          
             var modalInstance = $modal.open({
            templateUrl: 'includes/ngadmin/tpl/delmodal.html',
            controller: 'themesModalCtrl',
            size: 'md',
            scope:$scope
        }); 
        }
        
    };
   
//    $scope.getSearchThemesList = function(){
//            
//         if($scope.search_filter!= undefined && $scope.search_filter.length>0){
//            
//             // remove previous array                       
//            $scope.themes_list.splice(0,$scope.themes_list.length);
//
//            RewardsFactory.getRewards($scope.search_filter,$scope.getIdsFromJSON($scope.selected_themes).toString()).success(function(data){
//
//                 $scope.themes_list = data;
//
//            });
//            
//        }
//    };
    
    
    $scope.enableRemoveTheme = function(){
        var checked_objs = $(".themes_container input:checkbox:checked")
        if(checked_objs.length == 0)
            $scope.isDisableButton = true;
        
        if(checked_objs.length > 0)
            $scope.isDisableButton = false;
        
        $scope.sltd_tms = $(".themes_container input:checkbox:checked").length;
        
    };
    
    $scope.removeItem = function(arr, id) {
        for (var i = 0; i < arr.length; i++) {
            var cur = arr[i];
            if (cur.id == id) {
                arr.splice(i, 1);
                break;
            }
        }
    }
    
    $scope.toggleCheckboxes = function(action){
        var checkbox_objs = $(".themes_container input:checkbox");
        switch(action)
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
         
        $scope.sltd_tms = $(".themes_container input:checkbox:checked").length;
        
    }   
                    

  $scope.closeAlert = function(index,theme,size) {
   console.log(" Remove object "+JSON.stringify(theme));
      $scope.rmdTheme_index = index;
     
      // remove previous array                       
      $scope.selected_theme.splice(0,$scope.selected_theme.length);
      
      $scope.selected_theme.splice(0,0,theme);
      
      var modalInstance = $modal.open({
            templateUrl: 'includes/ngadmin/tpl/delmodal.html',
            controller: 'themesModalCtrl',
            size: size,
            scope:$scope
        });    
  };
    

   /* Toaster type: 
        success,info,wait,warning,error
   */
 $scope.showToaster= function(type,title,msg){
    toaster.pop(type, title, msg);
 }
 
 $scope.addTheme = function(){
   
    loggedUserFactory.userdata().success(function(data){
        if ($scope.myimg)
        {
             
                ThemesFactory.addTheme(data.ssdata.user_id,$scope.myimg).success(function(data){
                      
                    
                     // get Themes list                         
                    $scope.get_themes_list();
                    
                    if(data.code == 200){
                        
                        $("input[type=file]").val("");
                        $scope.imfinish=false;
                        $scope.imguploaded=false;
                        $scope.myimg = "";
                        $scope.showToaster("info","Add Theme:","Seleted Theme added successfully.");
                    }else{
                        $scope.showToaster("error","Add Theme Error:",data.message);
                    }
   
                });
                    
            
        }
    });
     
   
 };

}]);



app.controller('themesModalCtrl', ['$scope', '$location', '$modalInstance','ThemesFactory','toaster','$rootScope',
  function($scope, $location, $modalInstance, ThemesFactory,toaster,$rootScope) {
      
      
      
      $scope.cancel = function(){
        $modalInstance.close();
      };
      
       $scope.confirmdel = function(){
           
    
           
           
           
           $scope.removed_ids = "";
           if($scope.selected_theme.length>0)
           {
                 // remove from seleted lists
                  $scope.themes_list.splice($scope.rmdTheme_index,1);
                 $scope.removed_ids = $scope.getIdsFromJSON($scope.selected_theme).toString();
            
           }else{
            
               $scope.removeSltdThemes();
               $scope.removed_ids = $scope.getIdsFromJSON($scope.selected_themes).toString();
           }
           
           
           $scope.enableRemoveTheme();
            // remove previous array                       
            $scope.selected_theme.splice(0,$scope.selected_theme.length);
            // remove previous array                       
            $scope.selected_themes.splice(0,$scope.selected_themes.length);
        
            ThemesFactory.removeTheme($scope.removed_ids).success(function(data){

                
                if(data.code == 200){
                    $modalInstance.close();
                     $scope.showToaster("info","Remove Theme:","Seleted Themes removed successfully.");
                }else{
                    $scope.showToaster("error","Remove Theme Error:",data.message);
                }
                
                
                
//                 // get Themes list                         
//                $scope.get_themes_list();
                

            });
           
      };
      
   
  }]);

