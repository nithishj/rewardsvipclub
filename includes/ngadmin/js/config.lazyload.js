// lazyload config

angular.module('app')
    /**
   * jQuery plugin config use ui-jq directive , config the js and css files that required
   * key: function name of the jQuery plugin
   * value: array of the css js file located
   */
  .constant('JQ_CONFIG', {
      easyPieChart:   ['includes/ngadmin/vendor/jquery/charts/easypiechart/jquery.easy-pie-chart.js'],
      sparkline:      ['includes/ngadmin/vendor/jquery/charts/sparkline/jquery.sparkline.min.js'],
      plot:           ['includes/ngadmin/vendor/jquery/charts/flot/jquery.flot.min.js', 
                          'includes/ngadmin/vendor/jquery/charts/flot/jquery.flot.resize.js',
                          'includes/ngadmin/vendor/jquery/charts/flot/jquery.flot.tooltip.min.js',
                          'includes/ngadmin/vendor/jquery/charts/flot/jquery.flot.spline.js',
                          'includes/ngadmin/vendor/jquery/charts/flot/jquery.flot.orderBars.js',
                          'includes/ngadmin/vendor/jquery/charts/flot/jquery.flot.pie.min.js'],
      slimScroll:     ['includes/ngadmin/vendor/jquery/slimscroll/jquery.slimscroll.min.js'],
      sortable:       ['includes/ngadmin/vendor/jquery/sortable/jquery.sortable.js'],
      nestable:       ['includes/ngadmin/vendor/jquery/nestable/jquery.nestable.js',
                          'includes/ngadmin/vendor/jquery/nestable/nestable.css'],
      filestyle:      ['includes/ngadmin/vendor/jquery/file/bootstrap-filestyle.min.js'],
      slider:         ['includes/ngadmin/vendor/jquery/slider/bootstrap-slider.js',
                          'includes/ngadmin/vendor/jquery/slider/slider.css'],
      chosen:         ['includes/ngadmin/vendor/jquery/chosen/chosen.jquery.min.js',
                          'includes/ngadmin/vendor/jquery/chosen/chosen.css'],
      TouchSpin:      ['includes/ngadmin/vendor/jquery/spinner/jquery.bootstrap-touchspin.min.js',
                          'includes/ngadmin/vendor/jquery/spinner/jquery.bootstrap-touchspin.css'],
      wysiwyg:        ['includes/ngadmin/vendor/jquery/wysiwyg/bootstrap-wysiwyg.js',
                          'includes/ngadmin/vendor/jquery/wysiwyg/jquery.hotkeys.js'],
      dataTable:      ['includes/ngadmin/vendor/jquery/datatables/jquery.dataTables.min.js',
                          'includes/ngadmin/vendor/jquery/datatables/dataTables.bootstrap.js',
                          'includes/ngadmin/vendor/jquery/datatables/dataTables.bootstrap.css'],
      vectorMap:      ['includes/ngadmin/vendor/jquery/jvectormap/jquery-jvectormap.min.js', 
                          'includes/ngadmin/vendor/jquery/jvectormap/jquery-jvectormap-world-mill-en.js',
                          'includes/ngadmin/vendor/jquery/jvectormap/jquery-jvectormap-us-aea-en.js',
                          'includes/ngadmin/vendor/jquery/jvectormap/jquery-jvectormap.css'],
      footable:       ['includes/ngadmin/vendor/jquery/footable/footable.all.min.js',
                          'includes/ngadmin/vendor/jquery/footable/footable.core.css']
      }
  )
  // oclazyload config
  .config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
      // We configure ocLazyLoad to use the lib script.js as the async loader
      $ocLazyLoadProvider.config({
          debug:  false,
          events: true,
          modules: [
              {
                  name: 'ngGrid',
                  files: [
                      'includes/ngadmin/vendor/modules/ng-grid/ng-grid.min.js',
                      'includes/ngadmin/vendor/modules/ng-grid/ng-grid.min.css',
                      'includes/ngadmin/vendor/modules/ng-grid/theme.css'
                  ]
              },
              {
                  name: 'ui.select',
                  files: [
                      'includes/ngadmin/vendor/modules/angular-ui-select/select.min.js',
                      'includes/ngadmin/vendor/modules/angular-ui-select/select.min.css'
                  ]
              },
              {
                  name:'angularFileUpload',
                  files: [
                    'includes/ngadmin/vendor/modules/angular-file-upload/angular-file-upload.min.js'
                  ]
              },
              {
                  name:'ui.calendar',
                  files: ['includes/ngadmin/vendor/modules/angular-ui-calendar/calendar.js']
              },
              {
                  name: 'ngImgCrop',
                  files: [
                      'includes/ngadmin/vendor/modules/ngImgCrop/ng-img-crop.js',
                      'includes/ngadmin/vendor/modules/ngImgCrop/ng-img-crop.css'
                  ]
              },
              {
                  name: 'angularBootstrapNavTree',
                  files: [
                      'includes/ngadmin/vendor/modules/angular-bootstrap-nav-tree/abn_tree_directive.js',
                      'includes/ngadmin/vendor/modules/angular-bootstrap-nav-tree/abn_tree.css'
                  ]
              },
              {
                  name: 'toaster',
                  files: [
                      'includes/ngadmin/vendor/modules/angularjs-toaster/toaster.js',
                      'includes/ngadmin/vendor/modules/angularjs-toaster/toaster.css'
                  ]
              },
              {
                  name: 'textAngular',
                  files: [
                      'includes/ngadmin/vendor/modules/textAngular/textAngular-sanitize.min.js',
                      'includes/ngadmin/vendor/modules/textAngular/textAngular.min.js'
                  ]
              },
              {
                  name: 'vr.directives.slider',
                  files: [
                      'includes/ngadmin/vendor/modules/angular-slider/angular-slider.min.js',
                      'includes/ngadmin/vendor/modules/angular-slider/angular-slider.css'
                  ]
              },
              {
                  name: 'com.2fdevs.videogular',
                  files: [
                      'includes/ngadmin/vendor/modules/videogular/videogular.min.js'
                  ]
              },
              {
                  name: 'com.2fdevs.videogular.plugins.controls',
                  files: [
                      'includes/ngadmin/vendor/modules/videogular/plugins/controls.min.js'
                  ]
              },
              {
                  name: 'com.2fdevs.videogular.plugins.buffering',
                  files: [
                      'includes/ngadmin/vendor/modules/videogular/plugins/buffering.min.js'
                  ]
              },
              {
                  name: 'com.2fdevs.videogular.plugins.overlayplay',
                  files: [
                      'includes/ngadmin/vendor/modules/videogular/plugins/overlay-play.min.js'
                  ]
              },
              {
                  name: 'com.2fdevs.videogular.plugins.poster',
                  files: [
                      'includes/ngadmin/vendor/modules/videogular/plugins/poster.min.js'
                  ]
              },
              {
                  name: 'com.2fdevs.videogular.plugins.imaads',
                  files: [
                      'includes/ngadmin/vendor/modules/videogular/plugins/ima-ads.min.js'
                  ]
              }
          ]
      });
  }])
;