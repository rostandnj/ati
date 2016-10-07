'use strict';
  
angular.module('Authentication')


.controller('LoginController',
    ['$scope', '$rootScope', '$location', 'AuthenticationService',
    function ($scope, $rootScope, $location, AuthenticationService) {
        // reset login status
        
        if ($location.path() == '/' && $rootScope.globals.currentUser) {
                $location.path('/dashboard');
            }

        AuthenticationService.ClearCredentials();
  
        $scope.login = function () 
        {
            
            $scope.dataLoading = true;
            AuthenticationService.Login($scope.username, $scope.password, 
                function(response) 
                {
                if(response.success) 
                {
                    AuthenticationService.SetCredentials(response.data.entity.username, response.data.entity.apikey);

                    //location.href = 'dashboard.html';
                    $location.path('/dashboard');
                } 
                else {
                    alert(response.status);
                    $scope.error = response.message;
                    $scope.dataLoading = false;
                }
            });
        };
    }]);



