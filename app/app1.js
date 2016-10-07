//'use strict';
 
// declare modules
angular.module('Authentication', []);
angular.module('Home', []);
 
var app =angular.module('myApp', [
    'Authentication',
    'Home',
    'ngRoute',
    'ngCookies'
])
  
.config(['$routeProvider', function ($routeProvider) {
 
    $routeProvider
        .when('/', {
            controller: 'LoginController',
            templateUrl: 'partials/login.html'
        })
        .when('/dashboard', {
            controller: 'HomeController',
            templateUrl: 'partials/dashboard.html'
        })
  
  
        .otherwise({ redirectTo: '/' });
}])

  
.run(['$rootScope', '$location', '$cookieStore', '$http',
    function ($rootScope, $location, $cookieStore, $http) 
    {
        // keep user logged in after page refresh
        $rootScope.globals = $cookieStore.get('globals') || {};
        if ($rootScope.globals.currentUser) {
            $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
        }
  
        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            // redirect to login page if not logged in
            if ($location.path() !== '/' && !$rootScope.globals.currentUser) {
                $location.path('/');
            }
        });
    }]);

app.value('online',0);