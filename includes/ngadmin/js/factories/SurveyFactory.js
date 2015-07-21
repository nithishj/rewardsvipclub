
(function() {
    var SurveyFactory = function($http) {
    
        var factory = {};
        

        factory.getsurvey=function(userid) {
            
            return $http.get('admin_survey/getsurvey?userid='+userid);
        }
		
		factory.addsurvey=function(dd) {
		//alert(JSON.stringify(dd));
			 return $http.post('admin_survey/addsurvey?format=json',dd);
		}
		
		factory.deletesurvey=function(delid) {
		var dd={SurveyId:delid};
			 return $http.post('admin_survey/deletesurvey?format=json',dd);
		}
		
		factory.getsurveystatistics=function(surveyid) {
			 return $http.get('admin_survey/getsurveystatistics?surveyid='+surveyid);
		}
		
		factory.getmyanswers=function(surveyid,userid) {
			 return $http.get('admin_survey/getmyanswers?surveyid='+surveyid+'&userid='+userid);
		}
		
		factory.submitsurvey=function(dd) {
			 return $http.post('admin_survey/submitsurvey?format=json',dd);
		}
		
		factory.getparticipants=function(surveyid)
		{
		 return $http.get('admin_survey/getparticipants?SurveyId='+surveyid);
		}
		
		

        return factory;
    };
    
    SurveyFactory.$inject = ['$http'];
        
    app.factory('SurveyFactory', SurveyFactory);
                                           
}());