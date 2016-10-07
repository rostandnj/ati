
 'use strict';
var origin = document.location.origin;
var folder = document.location.pathname.split('/')[1];
var path = origin + "/" + folder + "/web/assets/view/";
var pathfile = origin + "/" + folder + "/web/assets/uploads/";



angular.module('myApp', ['ngRoute','schemaForm','angular-flare','angularSchemaFormBase64FileUpload','lr.upload']).
  config(['$routeProvider', function($routeProvider,$locationProvider,formlyConfigProvider) {

  	$routeProvider.
      when(Routing.generate('rest_user_all'), {templateUrl: path+'lists.html', controller: ListCtrl})
      .when(Routing.generate('rest_user_add'), {templateUrl: path+'create.html', controller: AddCtrl})
      .when(Routing.generate('rest_article_list'), {templateUrl: path+'articles.html', controller: articleListCtrl})
      .when(Routing.generate('rest_article_add'), {templateUrl: path+'article_add.html', controller: articleAddCtrl})
      .when(Routing.generate('rest_antenne_list'), {templateUrl: path+'antenne_list.html', controller: antenneListCtrl})
      .when(Routing.generate('rest_antenne_add'), {templateUrl: path+'antenne_add.html', controller: antenneAddCtrl})
      .when(Routing.generate('rest_antenne_one') +'/:id', {templateUrl: path+'antenne_one.html', controller: antenneOneCtrl})
      .when(Routing.generate('rest_shop_add') +'/:id', {templateUrl: path+'shop_add.html', controller: shopAddCtrl})
      .when(Routing.generate('rest_shop_one') +'/:id', {templateUrl: path+'shop_one.html', controller: shopOneCtrl})
      .when(Routing.generate('rest_stock_add') +'/:id', {templateUrl: path+'stock_add.html', controller: stockAddCtrl})
      .when(Routing.generate('rest_stock_entree') +'/:id', {templateUrl: path+'stock_entree.html', controller: entreeCtrl})
      .when(Routing.generate('rest_stock_sortie') +'/:id', {templateUrl: path+'stock_sortie.html', controller: sortieCtrl})
      .when(Routing.generate('rest_project_all'), {templateUrl: path+'project_all.html', controller: projectCtrl})
      .when(Routing.generate('rest_project_add'), {templateUrl: path+'project_add.html', controller: projectAddCtrl})
      .when(Routing.generate('rest_project_show') +'/:id', {templateUrl: path+'project_one.html', controller: projectOneCtrl})
      .when(Routing.generate('rest_project_evolution') +'/:id', {templateUrl: path+'project_evolution.html', controller: evolutionCtrl})
      .when(Routing.generate('rest_project_expenditure') +'/:id', {templateUrl: path+'project_expenditure.html', controller: expenditureCtrl})
      .when(Routing.generate('rest_project_blocage') +'/:id', {templateUrl: path+'project_blocage.html', controller: blocageCtrl})
      .when(Routing.generate('rest_mail_all'), {templateUrl: path+'mail_all.html', controller: mailCtrl})
      .when(Routing.generate('rest_mail_add'), {templateUrl: path+'mail_add.html', controller: mailAddCtrl})
      .when(Routing.generate('rest_project_end') +'/:id', {templateUrl: path+'project_end.html', controller: endCtrl})
      .when(Routing.generate('rest_project_archive'), {templateUrl: path+'project_archive.html', controller: projectACtrl})
      .when(Routing.generate('rest_article_edit')+'/:id', {templateUrl: path +'edit.html', controller: EditCtrl})
      .when(Routing.generate('rest_article_del')+'/:id', {templateUrl: path +'article_del.html', controller: articleDelCtrl})
      .when(Routing.generate('rest_antenne_del')+'/:id', {templateUrl: path +'antenne_del.html', controller: antenneDelCtrl})
      .when(Routing.generate('rest_antenne_edit')+'/:id', {templateUrl: path +'antenne_edit.html', controller: antenneEditCtrl})
      .when(Routing.generate('rest_shop_edit')+'/:id', {templateUrl: path +'shop_edit.html', controller: shopEditCtrl})
      .when(Routing.generate('rest_shop_del')+'/:id', {templateUrl: path +'shop_del.html', controller: shopDelCtrl})
      .when(Routing.generate('rest_shop_stat')+'/:id', {templateUrl: path+'shop_stat.html', controller: statCtrl})
      .when(Routing.generate('rest_user_edit')+'/:id', {templateUrl: path +'user_edit.html', controller: userEditCtrl})
      .when(Routing.generate('rest_home'), {templateUrl: path +'home.html', controller: loginCtrl})
      
      
      ;
      

  
}]).directive('loading',   ['$http' ,function ($http)
    {
        return {
            restrict: 'A',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    if(v){
                        elm.show();
                    }else{
                        elm.hide();
                    }
                });
            }
        };

    }])
.directive('myModal', function() {
   return {
     restrict: 'A',
     link: function(scope, element, attr) {
       scope.dismiss = function() 
       {
           element.modal('hide');
       };
     }
   } 
})
.constant('global', {
        user: {};
    });


  




function ListCtrl($scope, $http,flare) 
{
	

  $http.get(Routing.generate('rest_user_all')).success(function(data) {
    $scope.users = data.data.entities;
    
  });
   

 }


function loginCtrl($scope, $http,flare) 
{
  

  $http.get(Routing.generate('rest_home')).success(function(data) {
    $scope.test = 1;
    
    
  });
   

 }



function AddCtrl($scope, $http,$location,flare,upload) {

  $http.get(Routing.generate('rest_user_add', { })).success(function(data)
		{
       $scope.code = data.code;
			 $scope.postes = data.data.postes;

        $scope.schema = {
        type: "object",
        properties: {
         nom: { type: "string", minLength: 2, title: "Name"},
    	      prenom: {type: "string", title: "Surname"},
    	      sexe: {type: "string", title: "Gender", enum: ['Woman','Man']},
    	      cni: {type: "string", minLength: 11, title: "CNI / PASSPORT Number"},
    	      adresse: {type: "string", minLength: 3, title: "Adresse"},
    	      telephone: {type: "string", minLength: 11, title: "Phone"},
    	     
    	      email: {type: "string","pattern": "^\\S+@\\S+$", minLength: 11, title: "Email"},
    	      poste: {type: "string", title: "Poste",enum:$scope.postes},
    	      password: {type: "string", minLength: 6, title: "Password", "x-schema-form":{type:"password"}},
    	      image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
    	      
    	      
            
            },
        
          "required": [
          "nom","sexe","cni","adresse","telephone","email","poste","password"
    
        ]
        };

      $scope.form = [
        "nom","prenom","sexe","cni","adresse","telephone","email","poste","password",
        {
          key:"image",
          title: "File upload",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
       	
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
         	$http({

          method  : 'POST',
          url     : Routing.generate('rest_user_add', { }),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {	
            if(data.code > 0)
             {
             	
             	var n = data.message.indexOf("INSERT INTO");
             	if(n>0)
             	{
             		flare.warn('This email or CNI / PASSPORT Number are already use, please try another', 20000);
             	}
             	else
             	{
             		flare.warn('Certain values are already use by another user, please try another', 20000);

             	}
             	
	
             }
             else
             {
             	flare.warn('User successfull created', 20000);
             	$location.path(Routing.generate('rest_user_show'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
			
   		
      	}
          else
          {
          	alert("no");
          }
      }
      });
}

function EditCtrl($scope, $http,$location,flare,upload,$routeParams) {

  $http.get(Routing.generate('rest_article_edit', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.postes = data.data.postes;
       $scope.article= data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            nom: { type: "string", minLength: 2, title: "Name",default:$scope.article.nom},
            caracteristique: {type: "string", title: "Feature", "x-schema-form":{type:"textarea"},default:$scope.article.caracteristique},
            utilisation: {type: "string", title: "Usage", "x-schema-form":{type:"textarea"},default:$scope.article.utilisation},
            prix: {type: "string", title: "Price",default:$scope.article.prix},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            },
        
          "required": [
          "nom","caracteristique","utilisation","prix"
    
        ]
        };

      $scope.form = [
        "nom","caracteristique","utilisation","prix",
        {
          key:"image",
          title: "File upload",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_article_edit', { id:$routeParams.id }),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('This  NIC or PASSPORT Number are already use, please try another', 20000);
              }
              else
              {
                flare.warn('Certain values are already use by another user, please try another', 20000);

              }
              
  
             }
             else
             {
              flare.warn('Article successfull update', 20000);
              $location.path(Routing.generate('rest_article_list'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        })
          .catch(function(error)
           {
              $scope.loading = false;
          });;;
     
      
      
        }
          else
          { $scope.loading = false;
            flare.warn('Empty Form', 20000);
            
          }
      }
      });
}

function articleListCtrl($scope, $http,flare) 
{
  

  $http.get(Routing.generate('rest_article_list', { })).success(function(data) {
    $scope.articles = data.data.entities;
    $scope.user = data.data.user;
    
    
  });

}

function articleDelCtrl($scope, $http,flare,$routeParams) 
{
  

  $http.get(Routing.generate('rest_article_del', {id:$routeParams.id })).success(function(data) 
  {
    $scope.article = data.data.entity;
    flare.warn('Article successfull delete', 20000);
    $location.path(Routing.generate('rest_article_list'));
    });

}


function articleAddCtrl($scope, $http,$location,flare,upload) {

  $http.get(Routing.generate('rest_article_add', { })).success(function(data)
    {
       $scope.code = data.code;
       $scope.message = data.message;

        $scope.schema = {
        type: "object",
        properties: {
            nom: { type: "string", minLength: 2, title: "Name"},
            caracteristique: {type: "string", title: "Feature", "x-schema-form":{type:"textarea"}},
            utilisation: {type: "string", title: "Usage", "x-schema-form":{type:"textarea"}},
            prix: {type: "string", title: "Price"},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            },
        
          "required": [
          "nom","caracteristique","utilisation","prix"
    
        ]
        };

      $scope.form = [
        "nom","caracteristique","utilisation","prix",
        {
          key:"image",
          title: "File upload",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_article_add', { }),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('data.message', 20000);
              }
              else
              {
                flare.warn('data.message', 20000);

              }
              
  
             }
             else
             {
              flare.warn('Article successfull created', 20000);
              $location.path(Routing.generate('rest_article_list'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function antenneListCtrl($scope, $location,$http,flare) 
{
  

  $http.get(Routing.generate('rest_antenne_list', { })).success(function(data) 
  {
    $scope.antennes = data.data.entities;

    $scope.schema = 
    {
        type: "object",
        properties: {
            id: { type: "number", title: "id"},

          },
          "required" :["id"]
    };

    $scope.form =["id" ,{
          type: "submit",
          title: "Save"
        }];

    $scope.model = { };

    
    
    
    
  }
      
    
);

}


function antenneAddCtrl($scope, $http,$location,flare,upload) {

  $http.get(Routing.generate('rest_antenne_add', { })).success(function(data)
    {
       $scope.code = data.code;
       $scope.message = data.message;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: { type: "string", minLength: 2, title: "Name"},
            pays: {type: "string", minLength: 3,title: "Country"},
            ville: {type: "string", minLength: 3,title: "Town"},
            contact: {type: "string", minLength: 11, title: "Phone"},
           
            email: {type: "string","pattern": "^\\S+@\\S+$", minLength: 4, title: "Email"},
            },
        
          "required": [
          "libelle","pays","ville","contact","email"
    
        ]
        };

      $scope.form = [
        "libelle","pays","ville","contact","email"
        ,
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_antenne_add', { }),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('Error', 20000);
              }
              else
              {
                flare.warn('Error', 20000);

              }
              
  
             }
             else
             {
              flare.warn('Antenne successfull created', 20000);
              $location.path(Routing.generate('rest_antenne_list'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function antenneOneCtrl($scope, $http,flare,$routeParams) 
{
  

  $http.get(Routing.generate('rest_antenne_one',{id:$routeParams.id})).success(function(data) {
    $scope.magasins = data.data.entities;
              $scope.antenne = data.data.antenne;
    
  });
   

 }

 function shopAddCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  $http.get(Routing.generate('rest_shop_add', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.antenne = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            nom: { type: "string", minLength: 2, title: "Name"},
            localisation: {type: "string", minLength: 3,title: "Localisation"},
            },
        
          "required": [
          "nom","localisation"
    
        ]
        };

      $scope.form = [
        "nom","localisation"
        ,
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_shop_add', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('Shop successfull created', 20000);
              $location.path(Routing.generate('rest_antenne_one',{id: $scope.antenne.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function shopOneCtrl($scope, $http,flare,$routeParams) 
{
  

  $http.get(Routing.generate('rest_shop_one',{id:$routeParams.id})).success(function(data) {
    $scope.stocks = data.data.entities;
    $scope.magasin = data.data.magasin;
    
  });
   

 }


 function stockAddCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  $http.get(Routing.generate('rest_stock_add', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.magasin = data.data.entity;
       $scope.produits = data.data.produits;

        $scope.schema = {
        type: "object",
        properties: {
            article: {type: "string", title: "Article",enum:$scope.produits},
            },
        
          "required": [
          "article"
    
        ]
        };

      $scope.form = [
       "article"
        ,
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_stock_add', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('Stock successfull created', 20000);
              $location.path(Routing.generate('rest_shop_one',{id: data.data.entity.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}


function entreeCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  $http.get(Routing.generate('rest_stock_entree', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.stock = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: {type: "string", title: "Object",minLength:5},
            quantite: {type: "integer", title: "Quantity"},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            },
        
          "required": [
          "libelle","quantite"
    
        ]
        };

      $scope.form = [
       "libelle","quantite",
       {
          key:"image",
          title: "justificatory",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_stock_entree', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('entry successfull created', 20000);
              $location.path(Routing.generate('rest_shop_one',{id: data.data.entity.magasin.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            flare.warn('please check your form', 20000);
          }
      }
      });
}

function sortieCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  $http.get(Routing.generate('rest_stock_sortie', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.stock = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: {type: "string", title: "Object",minLength:5},
            quantite: {type: "integer", title: "Quantity"},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            },
        
          "required": [
          "libelle","quantite"
    
        ]
        };

      $scope.form = [ "libelle","quantite",
       {
          key:"image",
          title: "justificatory",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_stock_sortie', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
                if(data.code == 1)
                {
                  flare.warn('insufficient stock', 20000);
                }
                flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('outflow successfull added', 20000);
              $location.path(Routing.generate('rest_shop_one',{id: data.data.entity.magasin.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            flare.warn('please check your form', 20000);
          }
      }
      });
}

function projectCtrl($scope, $http,flare) 
{
  

  $http.get(Routing.generate('rest_project_all')).success(function(data) {
    $scope.projects = data.data.entities;

    
  });
   

 }

 function projectAddCtrl($scope, $http,$location,flare,upload) {

  $http.get(Routing.generate('rest_project_add', { })).success(function(data)
    {
       $scope.code = data.code;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: { type: "string", minLength: 2, title: "Title"},
            moa: {type: "string", title: "Owner"},
            datedebut: {type: "string",title:"Begining Date" ,format: "date"},
            datefin: {type: "string",title: "Ending Date" ,format: "date"},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            
            
            
            },
        
          "required": [
          "libelle","moa"
        ]
        };

      $scope.form = [
         "libelle","moa",
         {
          key: "datedebut",
          type: "datepicker",
          format: "yyyy-mm-dd",
          minDate: new Date(),
          
          rangeStartDateField: "datedebut",
          rangeEndDateField: "datefin",
          rangeSelector: true
        }, 
        {
      key: "datefin",
      type: "datepicker",
      format: "yyyy-mm-dd",
      minDate: new Date(),
      
      rangeStartDateField: "",
      rangeEndDateField: "",
      rangeSelector: true
    },
    {
          key:"image",
          title: "justificatory",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
         
        {
          type: "submit",
          title: "Save"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_project_add', { }),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              
                flare.warn(data.message, 20000);

             
  
             }
             else
             {
              flare.warn('Project successfull created', 20000);
              $location.path(Routing.generate('rest_project_all'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function projectOneCtrl($scope, $http,flare,$routeParams) 
{
  

  $http.get(Routing.generate('rest_project_show',{id:$routeParams.id})).success(function(data) {
    $scope.project = data.data.entity;
    $scope.remain = data.data.remain;
    $scope.test = data.data.entity.statut;
    
    
    
  });

  
   

 }

 function evolutionCtrl($scope, $http,$location,flare,upload,$routeParams) {

  $http.get(Routing.generate('rest_project_evolution', {id:$routeParams.id})).success(function(data)
    {
       $scope.code = data.code;
       $scope.project = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: { type: "string", minLength: 2, title: "Title"},
            pourcentage: {type: "string", title: "Percentage", },
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            
            
            
            },
        
          "required": [
          "libelle","pourcentage"
        ]
        };

      $scope.form = [
         "libelle","pourcentage",
         
    {
          key:"image",
          title: "justificatory",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
         
        {
          type: "submit",
          title: "Save"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_project_evolution', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              
              
                flare.warn(data.message, 20000);

             
  
             }
             else
             {
              flare.warn('Evolution successfull created', 20000);
              $location.path(Routing.generate('rest_project_show', { id: $scope.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function expenditureCtrl($scope, $http,$location,flare,upload,$routeParams) {

  $http.get(Routing.generate('rest_project_expenditure', {id:$routeParams.id})).success(function(data)
    {
       $scope.code = data.code;
       $scope.project = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: { type: "string", minLength: 2, title: "Title"},
            montant: {type: "string", title: "Cost", },
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            
            
            
            },
        
          "required": [
          "libelle","montant"
        ]
        };

      $scope.form = [
         "libelle","montant",
         
    {
          key:"image",
          title: "justificatory",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
         
        {
          type: "submit",
          title: "Save"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_project_expenditure', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              
              
                flare.warn(data.message, 20000);

             
  
             }
             else
             {
              flare.warn('Expenditure successfull created', 20000);
              $location.path(Routing.generate('rest_project_show', { id: $scope.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

 function blocageCtrl($scope, $http,$location,flare,upload,$routeParams) {

  $http.get(Routing.generate('rest_project_blocage', {id:$routeParams.id})).success(function(data)
    {
       $scope.code = data.code;
       $scope.project = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: { type: "string", minLength: 2, title: "Title"},
            description: {type: "string", title: "Description", "x-schema-form":{type:"textarea"}},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            
            
            
            },
        
          "required": [
          "libelle","description"
        ]
        };

      $scope.form = [
         "libelle","description",
         
    {
          key:"image",
          title: "justificatory",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
         
        {
          type: "submit",
          title: "Save"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_project_blocage', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              
              
                flare.warn(data.message, 20000);

             
  
             }
             else
             {
              flare.warn('freeze successfull created', 20000);
              $location.path(Routing.generate('rest_project_show', { id: $scope.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function mailCtrl($scope, $http,flare) 
{
  

  $http.get(Routing.generate('rest_mail_all')).success(function(data) {
    $scope.mails = data.data.entities;

    
  });
   

 }

  function mailAddCtrl($scope, $http,$location,flare,upload) {

  $http.get(Routing.generate('rest_mail_add', { })).success(function(data)
    {
       $scope.code = data.code;

        $scope.schema = {
        type: "object",
        properties: 
        {
            libelle: { type: "string", minLength: 2, title: "Title"},
            type: {type: "string", title: "Type", enum: ['Outgoing','Incomming']},
            statut: {type: "string", title: "Statut", enum: ['Ok','Wait for Response']},
            date: {type: "string",title:" Date" ,format: "date"},
            emetteur: { type: "string", minLength: 2, title: "Sender"},
            recepteur: { type: "string", minLength: 2, title: "Receiver"},
            
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
        },
        
        "required": 
        [
          "libelle","type","emetteur","recepteur","statut"
        ]
        };

        $scope.form = 
        [
         "libelle","type","emetteur","recepteur","statut",
         {
          key: "date",
          type: "datepicker",
          format: "yyyy-mm-dd",
          minDate: new Date(),
          
          
          rangeSelector: true
        }, 
        
        {
          key:"image",
          title: "justificatory",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
         
        {
          type: "submit",
          title: "Save"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_mail_add', { }),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              
                flare.warn(data.message, 20000);

             
  
             }
             else
             {
              flare.warn('Mail successfull created', 20000);
              $location.path(Routing.generate('rest_mail_all'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function endCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
  $http.get(Routing.generate('rest_project_end', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.project = data.data.entity

        $scope.schema = {
        type: "object",
        properties: 
        {
            
            statut: {type: "boolean", title: "Are You Sure",default:true},
            
        },
        
        "required": 
        [
          "statut"
        ]
        };

        $scope.form = 
        [
         
         
        ,
         
        {
          type: "submit",
          title: "Yes"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_project_end', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('Project successfull closed', 20000);
              $location.path(Routing.generate('rest_project_show', { id:$scope.id}));
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });

 }

 function articleDelCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
  $http.get(Routing.generate('rest_article_del', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.article = data.data.entity

        $scope.schema = {
        type: "object",
        properties: 
        {
            
            actif: {type: "boolean", title: "Are You Sure",default:false},
            
        },
        
        "required": 
        [
          "actif"
        ]
        };

        $scope.form = 
        [
         
         
        ,
         
        {
          type: "submit",
          title: "Yes"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_article_del', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('Article successfull delete', 20000);
              $location.path(Routing.generate('rest_article_list', {}));
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });

 }

function projectACtrl($scope, $http,flare) 
{
  

  $http.get(Routing.generate('rest_project_archive')).success(function(data) 
  {
    $scope.projects = data.data.entities;
    $scope.mon = data.data.month;
    $scope.year = data.data.year;


    
  });

   

 }

 function antenneDelCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
  $http.get(Routing.generate('rest_antenne_del', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.article = data.data.entity

        $scope.schema = {
        type: "object",
        properties: 
        {
            
            actif: {type: "boolean", title: "Are You Sure",default:false},
            
        },
        
        "required": 
        [
          "actif"
        ]
        };

        $scope.form = 
        [
         
         
        ,
         
        {
          type: "submit",
          title: "Yes"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_antenne_del', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('Office successfull delete', 20000);
              $location.path(Routing.generate('rest_antenne_list', {}));
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });

 }



 function antenneEditCtrl($scope, $http,$location,flare,upload,$routeParams) {

  $http.get(Routing.generate('rest_antenne_edit', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.message = data.message;
       $scope.antenne = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: { type: "string", minLength: 2, title: "Name",default: $scope.antenne.libelle},
            pays: {type: "string", minLength: 3,title: "Country",default: $scope.antenne.pays},
            ville: {type: "string", minLength: 3,title: "Town",default: $scope.antenne.ville},
            contact: {type: "string", minLength: 11, title: "Phone",default: $scope.antenne.contact},
           
            email: {type: "string","pattern": "^\\S+@\\S+$", minLength: 4, title: "Email",default: $scope.antenne.email},
            },
        
          "required": [
          "libelle","pays","ville","contact","email"
    
        ]
        };

      $scope.form = [
        "libelle","pays","ville","contact","email"
        ,
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_antenne_edit', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('Error', 20000);
              }
              else
              {
                flare.warn('Error', 20000);

              }
              
  
             }
             else
             {
              flare.warn('Antenne successfull update', 20000);
              $location.path(Routing.generate('rest_antenne_list'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}


function shopEditCtrl($scope, $http,$location,flare,upload,$routeParams) {

  $http.get(Routing.generate('rest_shop_edit', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.magasin = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            nom: { type: "string", minLength: 2, title: "Name",default:$scope.magasin.nom},
            localisation: {type: "string", minLength: 3,title: "Localisation",default:$scope.magasin.localisation},
            },
        
          "required": [
          "nom","localisation"
    
        ]
        };

      $scope.form = [
        "nom","localisation"
        ,
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = { };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_shop_edit', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('Shop successfull update', 20000);
              $location.path(Routing.generate('rest_antenne_one',{id: $scope.magasin.antenne.id}));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });
}

function shopDelCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
  $http.get(Routing.generate('rest_shop_del', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.magasin = data.data.entity

        $scope.schema = {
        type: "object",
        properties: 
        {
            
            actif: {type: "boolean", title: "Are You Sure",default:false},
            
        },
        
        "required": 
        [
          "actif"
        ]
        };

        $scope.form = 
        [
         
         
        ,
         
        {
          type: "submit",
          title: "Yes"
        }

        
      ];

      $scope.model = {  };
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');


      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_shop_del', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('Shop successfull delete', 20000);
              $location.path(Routing.generate('rest_antenne_one', {id:$scope.magasin.antenne.id}));
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          else
          {
            alert("no");
          }
      }
      });

 }

 function statCtrl($scope, $http,flare,$routeParams) 
{
  

  $http.get(Routing.generate('rest_shop_stat', {id:$routeParams.id })).success(function(data) 
  {
    $scope.magasin = data.data.magasin;
    $scope.entreesm = data.data.entreesm;
    $scope.sortiesm = data.data.sortiesm;

  
    });

}

function userEditCtrl($scope, $http,$location,flare,upload,$routeParams) 
{

  $http.get(Routing.generate('rest_user_edit', { id:$routeParams.id })).success(function(data)
    {
       $scope.code = data.code;
       $scope.user = data.data.entity;
       $scope.postes = data.data.postes;

        $scope.schema = {
        type: "object",
        properties: {
            cni: {type: "string", minLength: 11, title: "CNI / PASSPORT Number",default:$scope.user.cni},
            adresse: {type: "string", minLength: 3, title: "Adresse",default:$scope.user.adresse},
            telephone: {type: "string", minLength: 11, title: "Phone",default:$scope.user.telephone},
           
            email: {type: "string","pattern": "^\\S+@\\S+$", minLength: 11, title: "Email",default:$scope.user.email},
            poste: {type: "string", title: "Poste",enum:$scope.postes,default:$scope.user.poste.libelle},
            password: {type: "string", minLength: 6, title: "Password", "x-schema-form":{type:"password"}},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                }},
        
          "required": [ "cni","adresse","telephone","email","poste","password"]
        };

      $scope.form = [
        "email","telephone","adresse","cni","poste","password","image",
        {
          type: "submit",
          title: "Save"
        }
      ];

      $scope.model = {};
  
      $scope.debug = {schema: angular.copy($scope.schema), form: angular.copy($scope.form)};


      $scope.onSubmit = function(form)
       {
        
        $scope.loading = true;
        // First we broadcast an event so all fields validate themselves
        $scope.$broadcast('schemaFormValidate');

        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : Routing.generate('rest_user_edit', { id:$routeParams.id}),

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 20000);
  
             }
             else
             {
              flare.warn('user successfull update', 20000);
              $location.path(Routing.generate('rest_user_all'));
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
        else
        {
          alert("no");
        }
      }
      });
}






