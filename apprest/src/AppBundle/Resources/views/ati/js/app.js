var base_url = 'http://localhost/angularcrud/';
var crudApp = angular.module('crudApp', ['ngRoute','ngSanitize','ui.bootstrap','LocalStorageModule','oitozero.ngSweetAlert','cfp.loadingBar', 'ngAnimate','ngIdle','ui.bootstrap']);

crudApp.factory("CallHighlightMenuService", function() {

	return {
		callisActive : function (viewLocation,$location) {
			var active = (viewLocation === $location.path());
			return '{"active": '+active+'}';
		},
	};

});



crudApp.config(function ($routeProvider,localStorageServiceProvider,cfpLoadingBarProvider,IdleProvider, KeepaliveProvider) {
	cfpLoadingBarProvider.includeSpinner = true;

    // configure Idle settings
    IdleProvider.idle(10); // in seconds
    IdleProvider.timeout(5); // in seconds
    KeepaliveProvider.interval(2); // in seconds

    // set up routing
	$routeProvider
		.when('/', { templateUrl : 'templates/home.html' , controller : 'HomeController' , title : 'Home'})
		.when('/newuser', { templateUrl : 'templates/newuser.html' , controller : 'NewUserController' , title : 'New User'})
		.when('/newuser/:eid', { templateUrl : 'templates/newuser.html' , controller : 'NewUserController' , title : 'Edit User'})
		.when('/users', { templateUrl : 'templates/users.html' , controller : 'UsersController' , title : 'Users'})
		.otherwise({ redirectTo: '/'});

    localStorageServiceProvider
    .setPrefix('crudApp')
    .setStorageType('sessionStorage')
    .setStorageCookie(1, base_url)
    .setStorageCookieDomain('')
    .setNotify(true, true);

});



crudApp.run(function(Idle){
    // start watching when the app runs. also starts the Keepalive service by default.
    Idle.watch();
});



crudApp.controller("MenuController",function ($scope,$location,CallHighlightMenuService,$http,localStorageService,SweetAlert) {

	if(localStorageService.get('token') == null) {
		location.href = 'index.html';
	}

	$scope.logoutnow = function () {

		swal({   title: "Are you sure want to logout?",   text: "",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes",   closeOnConfirm: false },
		 function(isConfirm){																																																			                  if (isConfirm)																																																			                  {
						localStorageService.remove('token');
						var url = base_url + 'api/logout';
						//var responseData = $http.get(url);
						location.href = 'index.html';
						//$state.go($state.current, {}, {reload: true}); // reload
				  }
		});

	};

	$scope.isActive = function (viewLocation) {
		var a = CallHighlightMenuService.callisActive(viewLocation,$location);
		var b = angular.fromJson(a);
		return b.active;
	};
});

crudApp.controller("SidebarMenuController",function ($scope,$location,CallHighlightMenuService,localStorageService) {
	$scope.logoutnow = function () {


		swal({   title: "Are you sure want to logout?",   text: "",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes",   closeOnConfirm: false },
		 function(isConfirm){																																																			                  if (isConfirm)																																																			                  {
						localStorageService.remove('token');
						var url = base_url + 'api/logout';
						//var responseData = $http.get(url);
						location.href = 'index.html';
						//$state.go($state.current, {}, {reload: true}); // reload
				  }
		});

	};

	$scope.isActive = function (viewLocation) {
		var a = CallHighlightMenuService.callisActive(viewLocation,$location);
		var b = angular.fromJson(a);
		return b.active;
	};
});

crudApp.controller("HomeController",function ($scope) 
  {
    alert("hello");

  });

crudApp.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

crudApp.controller("UsersController",function ($scope,$http,$timeout,localStorageService,cfpLoadingBar,$location,$route) {

    cfpLoadingBar.start();
    var token = localStorageService.get('token');

    $http({
    url:base_url + 'api/loadUsers',
    method:"GET",
    withCredentials:true,
    headers:{'token':token}
    }).success(function(data, status, headers, config) {
        console.log(data);
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.list.length; //Initially for no filter
        $scope.totalItems = $scope.list.length;
        //here data is response from server. You can check status, headers, configuration settings too.
        cfpLoadingBar.complete();
    }).error(function(data, status, headers, config) {
        //do something here. Error occurd while fetching data from server
        cfpLoadingBar.complete();
    });

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };

	//delete user
	$scope.delete_user = function(did) {
		var token = localStorageService.get('token');

		if(token != null) {
            swal({   title: "Are you sure want to delete this record?",   text: "",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes",   closeOnConfirm: true },
            function(isConfirm){
                   if (isConfirm)																																																			                  {
                                var url = base_url + 'api/deleteUser/'+did;
                                $http({
                                url:url,
                                method:"DELETE",
                                withCredentials:true,
                                headers:{'token':token}
                                }).success(function(data, status, headers, config) {
                                        $location.path('/users');
                                        $route.reload();
                                }).error(function(data, status, headers, config) {
                                    //do something here. Error occurd while fetching data from server
                                });
                        }
            });
        } else $route.reload();
	};
});

//both new user and edit user
crudApp.controller("NewUserController",function ($scope,$routeParams,$location,$http,cfpLoadingBar,localStorageService) {
    var token = localStorageService.get('token');
	var edit_id = $routeParams.eid;

	if(angular.isUndefined($routeParams.eid) == false) {
        cfpLoadingBar.start();
		//load edit user
		var url = base_url + 'api/loadEditUser/'+edit_id;

    $http({
        url:url,
        method:"GET",
        withCredentials:true,
        headers:{'token':token}
        }).success(function(data, status, headers, config) {
                $scope.name = data[0].name;
                $scope.email = data[0].email;
                $scope.mobile = +(data[0].mobile);
                cfpLoadingBar.complete();
        }).error(function(data, status, headers, config) {
            cfpLoadingBar.complete();
        });

		//save edit changes
		$scope.submitForm = function () {
			cfpLoadingBar.start();
      var url = base_url + 'api/editUser';

      var d1 = {'id' :edit_id, 'name': $scope.name,'email':$scope.email,'mobile':$scope.mobile };
      $http({
          url:url,
          method:"POST",
          data:d1,
          withCredentials:true,
          headers:{'token':token}
          }).success(function(data, status, headers, config) {
                  if(data.status) {
                      $location.path('/users');
                      cfpLoadingBar.complete();
                  }
          }).error(function(data, status, headers, config) {
              cfpLoadingBar.complete();
          });
		};

	} else if(angular.isUndefined($routeParams.eid) == true) {
		//save new user
		$scope.submitForm = function () {
		cfpLoadingBar.start();
    var url = base_url + 'api/newUser';
    var d1 = { 'name': $scope.name,'email':$scope.email,'mobile':$scope.mobile};
    $http({
        url:url,
        method:"POST",
        data:d1,
        withCredentials:true,
        headers:{'token':token}
        }).success(function(data, status, headers, config) {
                if(data.status) {
                    swal("User added successfully", "", "success");
                    cfpLoadingBar.complete();
                }
        }).error(function(data, status, headers, config) {
            cfpLoadingBar.complete();
        });
		};
	} else {
		$scope.msg = 'Wrong url input';
	}
});
crudApp.controller("CommonController",function ($scope,$http,$modal,localStorageService) {
    function closeModals() {
        if ($scope.warning) {
          $scope.warning.close();
          $scope.warning = null;
        }

        if ($scope.timedout) {
          $scope.timedout.close();
          $scope.timedout = null;
        }
      }

      $scope.$on('IdleStart', function() {
        closeModals();

        $scope.warning = $modal.open({
          templateUrl: 'warning-dialog.html',
          windowClass: 'modal-danger'
        });
      });

      $scope.$on('IdleEnd', function() {
        closeModals();

      });

      $scope.$on('IdleTimeout', function() {
        localStorageService.remove('token');
        closeModals();
        $scope.timedout = $modal.open({
          templateUrl: 'timedout-dialog.html',
          windowClass: 'modal-danger'
        });
      });
});
