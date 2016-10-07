
angular.module('FormController').controller('FormController', function FormController() 
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

});

...