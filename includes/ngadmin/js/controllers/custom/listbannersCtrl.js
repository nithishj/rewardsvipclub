app.controller('listbannersCtrl',['$scope','$location','BannerFactory','$modal', function($scope, $location, BannerFactory, $modal)
{
    $scope.AddBannerid=[];
    $scope.disdel=true;

    BannerFactory.getbanners('')
        .success(function (data) {

            $scope.banners=data;
        });

    $scope.edit=function(bannerid)
    {
        $location.path('/admin/editbanner/'+bannerid);
    };

    $scope.pushbannerid=function(bannerid)
    {

        // alert(broadcastid);
        if ($scope.AddBannerid.indexOf(bannerid) == -1) {
            $scope.AddBannerid.push(bannerid);
        }
        else
        {
            var index = $.inArray(bannerid, $scope.AddBannerid);
            $scope.AddBannerid.splice(index, 1);
            //$scope.storeidAdd.push(StoreId);
        }

        if ($scope.AddBannerid.length == 0)
            $scope.disdel=true;
        else
            $scope.disdel=false;
        //alert($scope.AddBannerid);
    };

     $scope.changestat=function(id)
            {

                var stat=$('#stat'+id).text();

                if(stat=='Active')
                {
                    $('#stat'+id).removeClass();
                    $('#stat'+id).addClass('label bg-warning');
                    $('#stat'+id).text('InActive');
                }
                else
                {
                    $('#stat'+id).removeClass();
                    $('#stat'+id).addClass('label bg-success');
                    $('#stat'+id).text('Active');
                }

                 BannerFactory.setStatus(id)
                .success(function(data){
                   //alert(JSON.stringify(data));
                }); 

            };

    $scope.openimg = function (size,imgurl)
    {
        // alert(imgurl);
        $scope.vidurl="";
        $scope.imgurl=imgurl;
        var modalInstance = $modal.open({
            templateUrl: 'includes/ngadmin/tpl/pushmsgmodal.html',
            controller: 'bannerModalCtrl',
            size: size,
            scope:$scope
        });
    };

    $scope.opendelete=function(size , id, type)
    {
        if(type=="singular") {
            $scope.delid = id;
            $scope.delname="Banner";
        }
        else    // type=="multi"
        {
            $scope.delname = "Selected Banners";
        }

        $scope.deltype=type;

        var modalInstance = $modal.open({
            templateUrl: 'includes/ngadmin/tpl/delmodal.html',
            controller: 'bannerModalCtrl',
            size: size,
            scope:$scope
        });

    };

}])
    .controller('bannerModalCtrl', ['$scope' ,'$modalInstance','BannerFactory', function($scope ,$modalInstance ,BannerFactory){


        $scope.confirmdel=function()
        {

            //alert($scope.deltype);
            if($scope.deltype=="singular")
            {

                BannerFactory.deletebanner($scope.delid)
                    .success(function(data){
                        alert('Banner deleted successfully');
                        $('#Vip'+$scope.delid).hide();
                    });
            }
            else if($scope.deltype=="multi")
            {
                BannerFactory.deletebanner($scope.AddBannerid.toString())
                    .success(function(data){
                        //alert(JSON.stringify(data));
                        alert('Banners deleted successfully');
                        angular.forEach($scope.AddBannerid, function(value, key) {
                            $('#Vip'+value).hide();
                        });
                    });

            }

            $modalInstance.close();
        };


        $scope.cancel=function()
        {
            $scope.vidurl="";
            $scope.imgurl="";
            $modalInstance.close();

        };

    }]);