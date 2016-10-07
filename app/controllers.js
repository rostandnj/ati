'use strict';
  
angular.module('Authentication')


.controller('LoginController',
    ['$scope', '$rootScope', '$location', 'AuthenticationService','$cookieStore',
    function ($scope, $rootScope, $location, AuthenticationService,$cookieStore) {
        // reset login
        //$window.location.reload(); 

    

       // alert( $rootScope.globals.currentUser.id);
       if ($location.path() == '/logout') 
        {
                AuthenticationService.ClearCredentials();
                window.location.reload();
        }
        
        if ($location.path() == '/' && $rootScope.globals.currentUser) 
        {
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
                    var save = response.data.entity;
                    var time = response.data.time;
                    if(!time.depart){time.depart ="";}
                    

                    AuthenticationService.SetCredentials(save.id,save.apikey,save.username,save.nom,save.poste.libelle,save.roles[0],save.antenne.libelle,save.antenne.id,save.image.nom,time.depart,time.arrivee);
                    window.location.reload();

                    //location.href = 'dashboard.html';
                    //$location.path('/dashboard');
                } 
                else {
                    alert(response.status);
                    $scope.error = response.message;
                    $scope.dataLoading = false;
                }
            });
        };
    }]);




