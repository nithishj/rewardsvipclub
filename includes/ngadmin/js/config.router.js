'use strict';

/**
 * Config for the router
 */
angular.module('app')
  .run(
    [          '$rootScope', '$state', '$stateParams',
      function ($rootScope,   $state,   $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;        
      }
    ]
  )
  .config(
    [          '$stateProvider', '$urlRouterProvider',
      function ($stateProvider,   $urlRouterProvider) {
          
          $urlRouterProvider
              .otherwise('/admin/users');
          $stateProvider
              .state('app', {
                  abstract: true,
                  url: '/admin',
                  templateUrl: 'includes/ngadmin/tpl/app.html'
              })
              .state('app.listusers', {
                  url: '/users',
                  templateUrl: 'includes/ngadmin/tpl/users/listusers.html',
				  controller:'listuserCtrl'  
              })
			   .state('app.adduser', {
                          url: '/adduser',
                          templateUrl: 'includes/ngadmin/tpl/users/adduser.html',
                           controller:'addUserCtrl'
                      })
			.state('app.push', {
				  url: '/pushmsgs',
				  templateUrl: 'includes/ngadmin/tpl/messages/pushmsgs.html',
				   controller:'pushMsgCtrl'
			  })
			.state('app.news', {
				  url: '/newsmsgs',
				  templateUrl: 'includes/ngadmin/tpl/messages/newsmsgs.html',
				   controller:'newsMsgCtrl'
			  })	
			   .state('app.listoffers', {
                  url: '/offers',
                  templateUrl: 'includes/ngadmin/tpl/offers/listoffers.html',
                  controller:'listoffersCtrl'
              })
			   .state('app.addoffer', {
                  url: '/addoffer',
                  templateUrl: 'includes/ngadmin/tpl/offers/addoffer.html',
                  controller:'addofferCtrl'
              })
              .state('app.editoffer', {
                  url: '/editoffer/:id',
                  templateUrl: 'includes/ngadmin/tpl/offers/addoffer.html',
                  controller:'addofferCtrl'
              })
			  .state('app.listbanners', {
                  url: '/banners',
                  templateUrl: 'includes/ngadmin/tpl/banners/listbanners.html',
                  controller:'listbannersCtrl'
              })
              .state('app.addbanner', {
                  url: '/addbanner/',
                  templateUrl: 'includes/ngadmin/tpl/banners/addbanner.html',
                  controller:'addbannerCtrl'
              })
              .state('app.editbanner', {
                  url: '/editbanner/:id',
                  templateUrl: 'includes/ngadmin/tpl/banners/addbanner.html',
                  controller:'addbannerCtrl'
              })
			 
			  .state('app.events', {
                  url: '/events',
                  templateUrl: 'includes/ngadmin/tpl/events/addevent.html',
                  controller:'addeventCtrl',
                  // use resolve to load other dependences
                  resolve: {
                      deps: ['$ocLazyLoad', 'uiLoad',
                        function( $ocLazyLoad, uiLoad ){
                          return uiLoad.load(
                            ['includes/ngadmin/vendor/jquery/fullcalendar/fullcalendar.css',
                              'includes/ngadmin/vendor/jquery/fullcalendar/theme.css',
                              'includes/ngadmin/vendor/jquery/jquery-ui-1.10.3.custom.min.js',
                              'includes/ngadmin/vendor/libs/moment.min.js',
                              'includes/ngadmin/vendor/jquery/fullcalendar/fullcalendar.min.js'
                              ]
                          ).then(
                            function(){
                              return $ocLazyLoad.load('ui.calendar');
                            }
                          )
                      }]
                  }
              })

			   .state('app.schedulepush', {
                  url: '/schedulepush',
                  templateUrl: 'includes/ngadmin/tpl/schedulepush/schedulepush.html',
                  controller:'schedulepushCtrl'
              })
			  .state('app.addschedulepush', {
                  url: '/adddschedulepush',
                  templateUrl: 'includes/ngadmin/tpl/schedulepush/addschedulepush.html',
                  controller:'addschedulepushCtrl'
				})
              .state('app.addreward', {
                  url: '/addrewards',
                  templateUrl: 'includes/ngadmin/tpl/rewards/addreward.html',
                  controller:'addRewardCtrl'
              })
                .state('app.rewards', {
                  url: '/rewards',
                  templateUrl: 'includes/ngadmin/tpl/rewards/rewards.html',
                  controller:'rewardsCtrl'

              })
              .state('app.ui', {
                  url: '/ui',
                  template: '<div ui-view class="fade-in-up"></div>'
              })
              .state('app.ui.buttons', {
                  url: '/buttons',
                  templateUrl: 'includes/ngadmin/tpl/ui_buttons.html'
              })
              .state('app.ui.icons', {
                  url: '/icons',
                  templateUrl: 'includes/ngadmin/tpl/ui_icons.html'
              })
              .state('app.ui.grid', {
                  url: '/grid',
                  templateUrl: 'includes/ngadmin/tpl/ui_grid.html'
              })
              .state('app.ui.widgets', {
                  url: '/widgets',
                  templateUrl: 'includes/ngadmin/tpl/ui_widgets.html'
              })          
              .state('app.ui.bootstrap', {
                  url: '/bootstrap',
                  templateUrl: 'includes/ngadmin/tpl/ui_bootstrap.html'
              })
              .state('app.ui.sortable', {
                  url: '/sortable',
                  templateUrl: 'includes/ngadmin/tpl/ui_sortable.html'
              })
              .state('app.ui.portlet', {
                  url: '/portlet',
                  templateUrl: 'includes/ngadmin/tpl/ui_portlet.html'
              })
              .state('app.ui.timeline', {
                  url: '/timeline',
                  templateUrl: 'includes/ngadmin/tpl/ui_timeline.html'
              })
              .state('app.ui.tree', {
                  url: '/tree',
                  templateUrl: 'includes/ngadmin/tpl/ui_tree.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                          return $ocLazyLoad.load('angularBootstrapNavTree').then(
                              function(){
                                 return $ocLazyLoad.load('includes/ngadmin/js/controllers/tree.js');
                              }
                          );
                        }
                      ]
                  }
              })
              .state('app.ui.toaster', {
                  url: '/toaster',
                  templateUrl: 'includes/ngadmin/tpl/ui_toaster.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('toaster').then(
                              function(){
                                 return $ocLazyLoad.load('includes/ngadmin/js/controllers/toaster.js');
                              }
                          );
                      }]
                  }
              })
              .state('app.ui.jvectormap', {
                  url: '/jvectormap',
                  templateUrl: 'includes/ngadmin/tpl/ui_jvectormap.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('includes/ngadmin/js/controllers/vectormap.js');
                      }]
                  }
              })
              .state('app.ui.googlemap', {
                  url: '/googlemap',
                  templateUrl: 'includes/ngadmin/tpl/ui_googlemap.html',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( [
                            'includes/ngadmin/js/app/map/load-google-maps.js',
                            'includes/ngadmin/js/app/map/ui-map.js',
                            'includes/ngadmin/js/app/map/map.js'] ).then(
                              function(){
                                return loadGoogleMaps(); 
                              }
                            );
                      }]
                  }
              })
              .state('app.chart', {
                  url: '/chart',
                  templateUrl: 'includes/ngadmin/tpl/ui_chart.html',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad){
                          return uiLoad.load('includes/ngadmin/js/controllers/chart.js');
                      }]
                  }
              })
              // table
              .state('app.table', {
                  url: '/table',
                  template: '<div ui-view></div>'
              })
              .state('app.table.static', {
                  url: '/static',
                  templateUrl: 'tpl/table_static.html'
              })
              .state('app.table.datatable', {
                  url: '/datatable',
                  templateUrl: 'includes/ngadmin/tpl/table_datatable.html'
              })
              .state('app.table.footable', {
                  url: '/footable',
                  templateUrl: 'includes/ngadmin/tpl/table_footable.html'
              })
              .state('app.table.grid', {
                  url: '/grid',
                  templateUrl: 'includes/ngadmin/tpl/table_grid.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                          return $ocLazyLoad.load('ngGrid').then(
                              function(){
                                  return $ocLazyLoad.load('includes/ngadmin/js/controllers/grid.js');
                              }
                          );
                      }]
                  }
              })
              // form
              .state('app.form', {
                  url: '/form',
                  template: '<div ui-view class="fade-in"></div>',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad){
                          return uiLoad.load('includes/ngadmin/js/controllers/form.js');
                      }]
                  }
              })
              .state('app.form.elements', {
                  url: '/elements',
                  templateUrl: 'includes/ngadmin/tpl/form_elements.html'
              })
              .state('app.form.validation', {
                  url: '/validation',
                  templateUrl: 'includes/ngadmin/tpl/form_validation.html'
              })
              .state('app.form.wizard', {
                  url: '/wizard',
                  templateUrl: 'includes/ngadmin/tpl/form_wizard.html'
              })
              .state('app.form.fileupload', {
                  url: '/fileupload',
                  templateUrl: 'includes/ngadmin/tpl/form_fileupload.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('angularFileUpload').then(
                              function(){
                                 return $ocLazyLoad.load('includes/ngadmin/js/controllers/file-upload.js');
                              }
                          );
                      }]
                  }
              })
              .state('app.form.imagecrop', {
                  url: '/imagecrop',
                  templateUrl: 'includes/ngadmin/tpl/form_imagecrop.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad){
                          return $ocLazyLoad.load('ngImgCrop').then(
                              function(){
                                 return $ocLazyLoad.load('includes/ngadmin/js/controllers/imgcrop.js');
                              }
                          );
                      }]
                  }
              })
              .state('app.form.select', {
                  url: '/select',
                  templateUrl: 'includes/ngadmin/tpl/form_select.html',
                  controller: 'SelectCtrl',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                          return $ocLazyLoad.load('ui.select').then(
                              function(){
                                  return $ocLazyLoad.load('includes/ngadmin/js/controllers/select.js');
                              }
                          );
                      }]
                  }
              })
              .state('app.form.slider', {
                  url: '/slider',
                  templateUrl: 'includes/ngadmin/tpl/form_slider.html',
                  controller: 'SliderCtrl',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                          return $ocLazyLoad.load('vr.directives.slider').then(
                              function(){
                                  return $ocLazyLoad.load('includes/ngadmin/js/controllers/slider.js');
                              }
                          );
                      }]
                  }
              })
              .state('app.form.editor', {
                  url: '/editor',
                  templateUrl: 'includes/ngadmin/tpl/form_editor.html',
                  controller: 'EditorCtrl',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                          return $ocLazyLoad.load('textAngular').then(
                              function(){
                                  return $ocLazyLoad.load('includes/ngadmin/js/controllers/editor.js');
                              }
                          );
                      }]
                  }
              })
              // pages
              .state('app.page', {
                  url: '/page',
                  template: '<div ui-view class="fade-in-down"></div>'
              })
              .state('app.page.profile', {
                  url: '/profile',
                  templateUrl: 'includes/ngadmin/tpl/page_profile.html'
              })
              .state('app.page.post', {
                  url: '/post',
                  templateUrl: 'includes/ngadmin/tpl/page_post.html'
              })
              .state('app.page.search', {
                  url: '/search',
                  templateUrl: 'includes/ngadmin/tpl/page_search.html'
              })
              .state('app.page.invoice', {
                  url: '/invoice',
                  templateUrl: 'includes/ngadmin/tpl/page_invoice.html'
              })
              .state('app.page.price', {
                  url: '/price',
                  templateUrl: 'includes/ngadmin/tpl/page_price.html'
              })
              .state('app.docs', {
                  url: '/docs',
                  templateUrl: 'includes/ngadmin/tpl/docs.html'
              })
              // others
              .state('lockme', {
                  url: '/lockme',
                  templateUrl: 'includes/ngadmin/tpl/page_lockme.html'
              })
              .state('access', {
                  url: '/access',
                  template: '<div ui-view class="fade-in-right-big smooth"></div>'
              })
              .state('access.signin', {
                  url: '/signin',
                  templateUrl: 'includes/ngadmin/tpl/page_signin.html',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['includes/ngadmin/js/controllers/signin.js'] );
                      }]
                  }
              })
              .state('access.signup', {
                  url: '/signup',
                  templateUrl: 'includes/ngadmin/tpl/page_signup.html',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['includes/ngadmin/js/controllers/signup.js'] );
                      }]
                  }
              })
              .state('access.forgotpwd', {
                  url: '/forgotpwd',
                  templateUrl: 'includes/ngadmin/tpl/page_forgotpwd.html'
              })
              .state('access.404', {
                  url: '/404',
                  templateUrl: 'includes/ngadmin/tpl/page_404.html'
              })

              // fullCalendar
              .state('app.calendar', {
                  url: '/calendar',
                  templateUrl: 'includes/ngadmin/tpl/app_calendar.html',
                  // use resolve to load other dependences
                  resolve: {
                      deps: ['$ocLazyLoad', 'uiLoad',
                        function( $ocLazyLoad, uiLoad ){
                          return uiLoad.load(
                            ['includes/ngadmin/vendor/jquery/fullcalendar/fullcalendar.css',
                              'includes/ngadmin/vendor/jquery/fullcalendar/theme.css',
                              'includes/ngadmin/vendor/jquery/jquery-ui-1.10.3.custom.min.js',
                              'includes/ngadmin/vendor/libs/moment.min.js',
                              'includes/ngadmin/vendor/jquery/fullcalendar/fullcalendar.min.js',
                              'includes/ngadmin/js/app/calendar/calendar.js']
                          ).then(
                            function(){
                              return $ocLazyLoad.load('ui.calendar');
                            }
                          )
                      }]
                  }
              })

              // mail
              .state('app.mail', {
                  abstract: true,
                  url: '/mail',
                  templateUrl: 'includes/ngadmin/tpl/mail.html',
                  // use resolve to load other dependences
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['includes/ngadmin/js/app/mail/mail.js',
                                               'includes/ngadmin/js/app/mail/mail-service.js',
                                               'includes/ngadmin/vendor/libs/moment.min.js'] );
                      }]
                  }
              })
              .state('app.mail.list', {
                  url: '/inbox/{fold}',
                  templateUrl: 'includes/ngadmin/tpl/mail.list.html'
              })
              .state('app.mail.detail', {
                  url: '/{mailId:[0-9]{1,4}}',
                  templateUrl: 'includes/ngadmin/tpl/mail.detail.html'
              })
              .state('app.mail.compose', {
                  url: '/compose',
                  templateUrl: 'includes/ngadmin/tpl/mail.new.html'
              })

              .state('layout', {
                  abstract: true,
                  url: '/layout',
                  templateUrl: 'includes/ngadmin/tpl/layout.html'
              })
              .state('layout.fullwidth', {
                  url: '/fullwidth',
                  views: {
                      '': {
                          templateUrl: 'includes/ngadmin/tpl/layout_fullwidth.html'
                      },
                      'footer': {
                          templateUrl: 'includes/ngadmin/tpl/layout_footer_fullwidth.html'
                      }
                  },
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['includes/ngadmin/js/controllers/vectormap.js'] );
                      }]
                  }
              })
              .state('layout.mobile', {
                  url: '/mobile',
                  views: {
                      '': {
                          templateUrl: 'includes/ngadmin/tpl/layout_mobile.html'
                      },
                      'footer': {
                          templateUrl: 'includes/ngadmin/tpl/layout_footer_mobile.html'
                      }
                  }
              })
              .state('layout.app', {
                  url: '/app',
                  views: {
                      '': {
                          templateUrl: 'includes/ngadmin/tpl/layout_app.html'
                      },
                      'footer': {
                          templateUrl: 'includes/ngadmin/tpl/layout_footer_fullwidth.html'
                      }
                  },
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['includes/ngadmin/js/controllers/tab.js'] );
                      }]
                  }
              })
              .state('apps', {
                  abstract: true,
                  url: '/apps',
                  templateUrl: 'includes/ngadmin/tpl/layout.html'
              })
              .state('apps.note', {
                  url: '/note',
                  templateUrl: 'includes/ngadmin/tpl/apps_note.html',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['includes/ngadmin/js/app/note/note.js',
                                               'includes/ngadmin/vendor/libs/moment.min.js'] );
                      }]
                  }
              })
              .state('apps.contact', {
                  url: '/contact',
                  templateUrl: 'includes/ngadmin/tpl/apps_contact.html',
                  resolve: {
                      deps: ['uiLoad',
                        function( uiLoad ){
                          return uiLoad.load( ['includes/ngadmin/js/app/contact/contact.js'] );
                      }]
                  }
              })
              .state('app.weather', {
                  url: '/weather',
                  templateUrl: 'includes/ngadmin/tpl/apps_weather.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                          return $ocLazyLoad.load(
                              {
                                  name: 'angular-skycons',
                                  files: ['includes/ngadmin/js/app/weather/skycons.js',
                                          'includes/ngadmin/vendor/libs/moment.min.js', 
                                          'includes/ngadmin/js/app/weather/angular-skycons.js',
                                          'includes/ngadmin/js/app/weather/ctrl.js' ] 
                              }
                          );
                      }]
                  }
              })
              .state('music', {
                  url: '/music',
                  templateUrl: 'includes/ngadmin/tpl/music.html',
                  controller: 'MusicCtrl',
                  resolve: {
                      deps: ['$ocLazyLoad',
                        function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                            'com.2fdevs.videogular', 
                            'com.2fdevs.videogular.plugins.controls', 
                            'com.2fdevs.videogular.plugins.overlayplay',
                            'com.2fdevs.videogular.plugins.poster',
                            'com.2fdevs.videogular.plugins.buffering',
                            'includes/ngadmin/js/app/music/ctrl.js', 
                            'includes/ngadmin/js/app/music/theme.css'
                          ]);
                      }]
                  }
              })
                .state('music.home', {
                    url: '/home',
                    templateUrl: 'includes/ngadmin/tpl/music.home.html'
                })
                .state('music.genres', {
                    url: '/genres',
                    templateUrl: 'includes/ngadmin/tpl/music.genres.html'
                })
                .state('music.detail', {
                    url: '/detail',
                    templateUrl: 'includes/ngadmin/tpl/music.detail.html'
                })
                .state('music.mtv', {
                    url: '/mtv',
                    templateUrl: 'includes/ngadmin/tpl/music.mtv.html'
                })
                .state('music.mtvdetail', {
                    url: '/mtvdetail',
                    templateUrl: 'includes/ngadmin/tpl/music.mtv.detail.html'
                })
                .state('music.playlist', {
                    url: '/playlist/{fold}',
                    templateUrl: 'includes/ngadmin/tpl/music.playlist.html'
                })
      }
    ]
  );