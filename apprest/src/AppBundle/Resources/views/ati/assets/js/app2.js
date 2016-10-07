console.clear();
var origin = document.location.origin;
var folder = document.location.pathname.split('/')[1];
var path = origin + "/" + folder + "/web/assets/view/";



	var app = angular.module('myApp', ['ngRoute','formly', 'formlyBootstrap'], function config(formlyConfigProvider) 
	{
    // set templates here
    formlyConfigProvider.setType({
      name: 'custom',
      templateUrl: 'custom.html'
    });
    $routeProvider.
      when(Routing.generate('rest_user_show'), {templateUrl: path+'lists.html', controller: ListCtrl})
      .when(Routing.generate('rest_user_add'), {templateUrl: path+'create.html', controller: AddCtrl})
      ;

  });

app.controller('FormController', function FormController() 
{
  var vm = this; // vm stands for "View Model" --> see https://github.com/johnpapa/angular-styleguide#controlleras-with-vm
  vm.rental = {};

    
    // An array of our form fields with configuration
    // and options set. We make reference to this in
    // the 'fields' attribute on the  element
    vm.rentalFields = [
        {
            key: 'nom',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'Name',
                placeholder: 'Enter your first name',
                required: true
            }
        },
        {
            key: 'prenom',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'Surname',
                placeholder: 'Enter your last name',
                required: False
            }
        },
        {
            key: 'sexe',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'Sex',
                placeholder: '',
                required: true
            }
        },
        {
            key: 'telephone',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'Phone',
                placeholder: '',
                required: true
            }
        },

        {
            key: 'cni',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'CNI / PASSPORT Number',
                placeholder: '',
                required: true
            }
        },
        {
            key: 'email',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'Email',
                placeholder: '',
                required: true
            }
        },
        {
            key: 'adresse',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'Adress',
                placeholder: '',
                required: true
            }
        },
        {
            key: 'password',
            type: 'input',
            templateOptions: {
                type: 'text',
                label: 'Password',
                placeholder: '',
                required: true
            }
        },


        
    ];
    vm.onSubmit = onSubmit;
    function onSubmit() {
    console.log('form submitted:', vm.user);
  }

};
function ListCtrl($scope, $http) {
	
  $http.get(Routing.generate('rest_user_show', { })).success(function(data) {
    $scope.users = data.data.entities;
  });
}
;


}

	)();
