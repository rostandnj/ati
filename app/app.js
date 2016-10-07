'use strict';
 
// declare modules
angular.module('Authentication', []);
angular.module('Home', []);
 
var app=angular.module('myApp', [
    'Authentication',
    'Home',
    'ngRoute',
    'ngCookies',
    'schemaForm',
    'angular-flare','angularSchemaFormBase64FileUpload','lr.upload','angularUtils.directives.dirPagination','pascalprecht.translate'
])
  
.config(['$routeProvider', function ($routeProvider,$locationProvider,formlyConfigProvider){
 
    $routeProvider
        .when('/', {
            controller: 'LoginController',
            templateUrl: 'partials/login.html'
        })
        .when('/logout', {
            controller: 'LoginController',
            templateUrl: 'partials/login.html'
        })
        .when('/dashboard', {controller: 'HomeController',templateUrl: 'partials/dashboard.html'})

        .when('/article/list', {templateUrl: 'views/articles.html',controller: articleListCtrl})
        .when('/article/add', {templateUrl: 'views/article_add.html', controller: articleAddCtrl})
        .when('/article/edit/:id', {templateUrl: 'views/edit.html', controller: EditCtrl})
        .when('/article/delete/:id', {templateUrl: 'views/article_del.html', controller: articleDelCtrl})

        .when('/antenne/list', {templateUrl: 'views/antenne_list.html', controller: antenneListCtrl})
        .when('/antenne/show/:id', {templateUrl: 'views/antenne_one.html', controller: antenneOneCtrl})
        .when('/antenne/add', {templateUrl: 'views/antenne_add.html', controller: antenneAddCtrl})
        .when('/antenne/edit/:id', {templateUrl: 'views/antenne_edit.html', controller: antenneEditCtrl})
        .when('/antenne/delete/:id', {templateUrl: 'views/antenne_del.html', controller: antenneDelCtrl})

        .when('/antenne/shop/:id', {templateUrl: 'views/shop_one.html', controller: shopOneCtrl})
        .when('/antenne/shop/add/:id', {templateUrl: 'views/shop_add.html', controller: shopAddCtrl})
        .when('/shop/edit/:id', {templateUrl: 'views/shop_edit.html', controller: shopEditCtrl})
        .when('/shop/delete/:id', {templateUrl: 'views/shop_del.html', controller: shopDelCtrl})

        .when('/shop/stock/add/:id', {templateUrl: 'views/stock_add.html', controller: stockAddCtrl})
        .when('/shop/stock/remove/:id', {templateUrl: 'views/stock_del.html', controller: stockDelCtrl})
        .when('/stock/in/:id', {templateUrl: 'views/stock_entree.html', controller: entreeCtrl})
        .when('/stock/out/:id', {templateUrl: 'views/stock_sortie.html', controller: sortieCtrl})

        .when('/shop/stat/:id', {templateUrl: 'views/shop_stat.html', controller: statCtrl})

        .when('/project', {templateUrl: 'views/project_all.html', controller: projectCtrl})
        .when('/project/add', {templateUrl: 'views/project_add.html', controller: projectAddCtrl})
        .when('/project/show/:id', {templateUrl: 'views/project_one.html', controller: projectOneCtrl})
        .when('/project/evolution/:id', {templateUrl: 'views/project_evolution.html', controller: evolutionCtrl})
        .when('/project/expenditure/:id', {templateUrl: 'views/project_expenditure.html', controller: expenditureCtrl})
        .when('/project/blocking/:id', {templateUrl: 'views/project_blocage.html', controller: blocageCtrl})
        .when('/project/end/:id', {templateUrl: 'views/project_end.html', controller: endCtrl})
        .when('/project/archive', {templateUrl: 'views/project_archive.html', controller: projectACtrl})

        .when('/users', {templateUrl: 'views/lists.html', controller: ListCtrl})
        .when('/user/add', {templateUrl: 'views/create.html', controller: AddCtrl})
        .when('/user/edit/:id', {templateUrl: 'views/user_edit.html', controller: usereditCtrl})
        .when('/user/profile/:id', {templateUrl: 'views/user_profile.html', controller: profileCtrl})
        .when('/user/bill/:id', {templateUrl: 'views/user_bill.html', controller: billCtrl})
        .when('/user/presence/:id', {templateUrl: 'views/user_presence.html', controller: presenceCtrl})
        .when('/bill/add/:id', {templateUrl: 'views/bill_add.html', controller: billaddCtrl})
        .when('/profile/edit/:id', {templateUrl: 'views/user_profile_edit.html', controller: profileeditCtrl})
        .when('/user/delete/:id', {templateUrl: 'views/user_del.html', controller: userdelCtrl})


        .when('/mail', {templateUrl: 'views/mail_all.html', controller: mailCtrl})
        .when('/mail/add', {templateUrl: 'views/mail_add.html', controller: mailAddCtrl})
        .when('/mail/archive', {templateUrl: 'views/mail_stat.html', controller: mailstatCtrl})

        .when('/stat/general', {templateUrl: 'views/stat_general.html', controller: statgeneralCtrl})
        .when('/stat/antenne/:id', {templateUrl: 'views/stat_antenne.html', controller: statantCtrl})

        .when('/test', {controller: 'testController',templateUrl: 'partials/test.html'})
        .when('/error', {controller: 'errorCtrl',templateUrl: 'views/error.html'})

        .when('/home', {controller: 'home',templateUrl: 'partials/dashboard.html'})
  
        .otherwise({ redirectTo: '/'} );
}])
.config(function(paginationTemplateProvider) {
    paginationTemplateProvider.setPath('partials/dirPagination.tpl.html');
})
.config(function ($translateProvider) {
  $translateProvider.translations('en', {
    Shop: 'Shop',
    Article: 'Product',
    Articles:'Products',
    shop_manager:'Shop Manager',
    Add:'Add',
    Article_list:'Products List',
    Name:'Name',
    Price:'Price',
    Alert:'Alert',
    Action:'Action',
    Get_General_State:'get global state',
    Article_information:'Product Information',
    Feature:'Feature',
    Usage:'Usage',
    File:'File',
    Add_new_article:'Add new Product',
    Stock_Alert:'Stock Alert',
    Image:'Image',
    Add_file:'Add File',
    Add_image:'Add Image',
    Save:'Save',
    Are_you_sure:'Are you sure to delete',
    Yes:'Yes',
    No:'No',
    Office:'Office',
    Office_list:'Office List',
    Country:'Country',
    Town:'Town',
    Contact:'Contact',
    Email:'Email',
    Add_new_office:'Add New Office',
    Phone:'Phone',
    Title:'Title',
    Location:'Location',
    Statistic:'Statistic',
    Quantity:'Quantity',
    ingress:'ingress',
    outflow:'output',
    remove:'remove',
    back:'back',
    archive:'archive',
    get_file:'download',
    Freq_day:'Freq(/day)',
    latest_action:'history',
    Month:'Month',
    Project:'Project',
    Ongoing:'Current',
    Project_list:'Project List',
    Manager:'Manager',
    Owner:'Owner',
    Date_debut:'Start date',
    Date_fin:'End Date',
    show:'show',
    Status:'Status',
    Remaining_time:'Remaining time',
    Display:'Display',
    Evolutions:'Evolutions',
    Add_evolution:'add evolution',
    Expenditures:'Expenditures',
    Add_expenditure:'add expenditure',
    Freezes:'Freezes',
    Add_freeze:'add freeze',
    Account:'Account',
    end:'end',
    Project_information:'Project Information',
    Project_evolution_file:'Project Evolution Files',
    Project_expenditures:'Project Expenditures',
    Cost:'Cost',
    Project_difficulties:'Project Difficulties',
    Percentage:'Percentage',
    Justificatory:'Justificatory',
    Description:'Description',
    Mail:'Mail',
    Sender:'Sender',
    Receiver:'Receiver',
    Details:'Details',
    Type:'Type',
    Date:'Date',
    Add_new_mail:'Add new mail',
    Staff:'Staff',
    Surname:'Surname',
    Poste:'Post',
    User:'Employee',
    Address:'Address',
    Phone_number:'Phone number',
    Role:'Role',
    Office:'Office',
    Gender:'Gender',
    General_stat:'General Statistic',
    Office_stat:'Office Statistic',
    Presence:'Presence',
    Stocks:'Stocks',
    Stock:'Stock',
    Entrance:'Entrance',
    Output:'Output',
    Incomming:'In Comming',
    Outgoing:'Out Going',
    From:'From',
    end_day:'end day',
    end_da:'Close at',
    start_work:'start work',
    Profile:'Profile',
    Bills:'Bills',
    Add_bill:'Add bill',
    New_pay_sheet:'New Pay sheet',
    File_upload:'File',
    Delete_antenne:'Delete Antenne',
    Edit_office:'Edit office',
    New_employe:'Add New Employee',
    Edit_article:"Edit Article",
    Staff_list:'Staff List',
    Mail_list:'Mail List',
    Mail_archive:'Mail Archive',
    Add_project:'Add new project',
    In_Progress:'Is running',
    End_project:'End Project',
    Exceed:'exceed',
    day:'day',
    previous:'previous',
    next:'next',
    Add_shop:'Add Shop',
    Edit_shop:'Edit Shop',
    Presence_history:'Presence History ',
    Stock_history:'Stocks history',
    Add_stock:'Add Stock',
    Logout:'Logout',
    Edit:'Edit',
    Home:'Home',
    Identifier:'NIC / Passport',

    EN: 'en',
    FR: 'fr'
  });

$translateProvider.translations('fr', {
    Shop: 'Boutique',
    Edit_office:'Modifier antenne',
    Edit_shop:'Modifier Boutique',
    Identifier:'CNI / Passeport',
    Edit:'modifier',
    Add_stock:'Ajouter stock',
    Stock_history:'Historique de stock',
    Presence_history:'Historique de présence',
    previous:'précédent',
    Add_shop:'Ajouter Boutique',
    next:'suivant',
    Exceed:'depassé',
    Add_project:'Ajouter projet',
    day:'jour',
    End_project:"Terminer le projet",
    In_Progress:'En cours',
    Edit_article:'Modifier article',
    Staff_list:'Liste du Personnel',
    Mail_archive:'Anciens Courriers',
    Mail_list:'Lise des courriers',
    New_employe:'Ajouter employé',
    Delete_antenne:'Supprimer Antenne',
    Article: 'Article',
    Internal_error:'Internal Error',
    Articles:'Articles',
    shop_manager:'Gestion de Boutique',
    Add:'Ajouter',
    Article_list:'Liste des articles',
    Name:'Nom',
    Price:'Prix',
    Alert:'Alerte',
    Action:'Opération',
    Get_General_State:'télécharger état',
    Article_information:'Description de l"article',
    Feature:'Outils',
    Usage:'Utilité',
    File:'Fichier',
    Add_new_article:'Ajout d"un article',
    Stock_Alert:'Alerte stock',
    Image:'Image',
    Add_file:'Ajouter un fichier',
    Add_image:'Ajouter une image ',
    Save:'enregistrer',
    Are_you_sure:'Etes-vous sûre de suprimer',
    Yes:'Oui',
    No:'Non',
    Logout:'Deconnecter',
    Account:'Compte',
    Office:'Antenne',
    Office_list:'Liste des antennes',
    Country:'Pays',
    Town:'Ville',
    Contact:'Contact',
    Email:'Email',
    Add_new_office:'Ajouter une antenne',
    Phone:'Téléphone',
    Title:'Libellé',
    Location:'Lieu',
    Statistic:'Statistique',
    Quantity:'Quantité',
    ingress:'entrée',
    outflow:'sortie',
    remove:'supprimer',
    back:'retour',
    archive:'archive',
    get_file:'télécharger',
    Freq_day:'Freq(/jour)',
    latest_action:'historique',
    Month:'Mois',
    Project:'Projet',
    Ongoing:'Courant',
    Project_list:'Liste des projets',
    Manager:'Gestionnaire',
    Owner:'Propriétaire',
    Date_debut:'debut',
    Date_fin:'fin',
    show:'afficher',
    Status:'Statut',
    Remaining_time:'Temps restant',
    Display:'Afiicher',
    Evolutions:'Evolutions',
    Add_evolution:'evoluer',
    Expenditures:'Depenses',
    Add_expenditure:'ajouter dépense',
    Freezes:'Difficultés',
    Add_freeze:'ajouter difficulté',
    end:'fin',
    Project_information:'Description Projet',
    Project_evolution_file:'Fichier des évolutions',
    Project_expenditures:'Depenses du projet',
    Cost:'Coût',
    Project_difficulties:'Difficultés du Projet',
    Percentage:'Pourcentage',
    Justificatory:'Justificatif',
    Description:'Description',
    Mail:'Courrier',
    Sender:'Emetteur',
    Receiver:'Recepteur',
    Details:'Details',
    Type:'Type',
    Internal_error:'Erreur Interne',
    Home:'Accueil',
    Date:'Date',
    Add_new_mail:'enregistrer courrier',
    Staff:'Personnel',
    Surname:'Prenom',
    Poste:'Poste',
    User:'Employé',
    Address:'Adresse',
    Phone_number:'téléphone',
    Role:'Fonction',
    Office:'Antenne',
    Gender:'Genre',
    General_stat:'Statistique Générale',
    Office_stat:'Statistique Antenne',
    Presence:'Presence',
    Stocks:'Stocks',
    Stock:'Stock',
    Entrance:'Entrée',
    Output:'Sortie',
    Incomming:'Entrée',
    Outgoing:'Sortie',
    From:'depuis',
    end_day:'terminer la journée',
    start_work:'debut du travail',
    Profile:'Profile',
    Bills:'Bulletins',
    Add_bill:'Ajouter Bulletin',
    New_pay_sheet:'Nouveau bulletin',
    File_upload:'Fichier',
    end_da:'Travail terminé à',


    EN: 'en',
    FR: 'fr'
  });
 $translateProvider.preferredLanguage('en');


 
})

 .factory('httpInterceptor', ['$q', '$location',function ($q, $location,flare) {
        var canceller = $q.defer();
        return {
            'request': function(config) {
                // promise that should abort the request when resolved.
                config.timeout = canceller.promise;
                return config;
            },
            'response': function(response) {
                return response;
            },
            'responseError': function(rejection) 
            {
                
                if (rejection.status === 500) {
                     
                    
                    $location.path('/error');
                    flare.warn("Please check your internet connection and try again", 10000);
                }
                
            }

        };
    }
    ])
    //Http Intercpetor to check auth failures for xhr requests
   .config(['$httpProvider',function($httpProvider) {
        $httpProvider.interceptors.push('httpInterceptor');
    }])

.directive('loading',   ['$http' ,function ($http)
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


  
.run(['$rootScope', '$location', '$cookieStore', '$http',
    function ($rootScope, $location, $cookieStore, $http) 
    {
        // keep user logged in after page refresh
        $rootScope.globals = $cookieStore.get('globals') || {};
        if ($rootScope.globals.currentUser) 
        {
            $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
        }
  
        $rootScope.$on('$locationChangeStart', function (event, next, current) 
        {
            // redirect to login page if not logged in
            if ($location.path() !== '/' && !$rootScope.globals.currentUser) 
            {
                $location.path('/');
            }

            if ($location.path() === '/') 
            {
                if($rootScope.globals.currentUser)
                {
                  $location.path('/dashboard');
                }
                
            }

        });
    }]);


function test($scope, $http) 
{
  

  $http.get('/test').success(function(data) {
    $scope.test = 1;
    
    
  });
   

 };

 function navCtrl($scope, $http,$cookieStore) 
{
   $scope.user = $cookieStore.get('globals');

  
 


 };

  function menuCtrl($scope, $http,$cookieStore) 
{
   $scope.u = $cookieStore.get('globals');

  
 


 };

function errorCtrl($scope, $http,$cookieStore) 
{
   $scope.u = $cookieStore.get('globals');

  
 


 };

 function HomeController($scope, $http,$cookieStore,AuthenticationService,$location,flare,$translate,$window) 
{

   $scope.changeLanguage = function (key) 
   {
    $translate.use(key);
  };

  $scope.int = 1800000; 
  

  var f=function myTimer() 
  {
    var a = base +'/stock/alerte';
        $http.get(a).success(function(data) 
        {
             $scope.stocks = data.entities;

             var m ="Stock Critique ";
             for (var prop in $scope.stocks)
             {
              m = m + $scope.stocks[prop].article.nom +" ";
               
              }

              flare.warn(m, 5000);
          });
  }
  var myVar = setInterval(f, $scope.int);


     
    // alert($scope.user.currentUser.role);
     if($cookieStore.get('globals'))
     {
        $scope.user = $cookieStore.get('globals');
        if($scope.user.currentUser.depart !='')
     {
      $scope.ok = true;
     }
     else
     {
      $scope.ok = false;
     }
     }
     
     

     

     $scope.end = function()
     {
        var url = base + '/user/endday/' + $scope.user.currentUser.id;
        $http.get(url).success(function(data) 
        {
          $scope.depart = data.data.depart;
          AuthenticationService.updateDepart($scope.depart);
          $scope.user = $cookieStore.get('globals');
          $scope.ok = true;
          if(data.code == 0)
          {
            $location.path('/dashrd');
            alert("Good Bye!!!");
          }
               
          
        });

     }

     $scope.print = function()
     {
        var url = base + '/generate/pdf';
        $scope.nom="";

        $http.get(url).success(function(data) 
        {
          $scope.nom = data.data;

          var x;
          if (confirm("Press a button!") == true) 
          {
              x = "You pressed OK!";
              alert(x);
          } 

          

          $window.open('http://localhost/auth/user/'+$scope.nom, '_blank');
          
          //window.location.reload();
               
          
        });

     }

   
 };
 //gestion des articles

 function articleListCtrl($scope, $http,flare,$window,$location) 
{
  

  var url= base + '/article/list';
  $http.get(url).success(function(data) 
  {
    $scope.articles = data.data.entities;
    $scope.user = data.data.user;
    $scope.currentPage = 1;
    $scope.pageSize = 4;
    


    
    
  })
  ;

   $scope.print = function()
 {
    
    var url = base + '/article/pdf';
    $scope.nom="";

    $http.get(url).success(function(data) 
    {
      $scope.nom = data.data;
      //$scope.a = $location.host();

      var x;
      if (confirm("File generate") == true) 
      {
         $window.open('/AAA/user/'+$scope.nom, '_blank');
      } 

      

      
      
      //window.location.reload();
           
      
    });

 }

}

function articleAddCtrl($scope, $http,$location,flare,upload) {

  $http.get(base +'/article/add').success(function(data)
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
            stocka: {type: "number", title: "Stock Alerte"},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            file: {
                  type: "string",
                  format: "base64",
                  maxSize: '4048576 ',
                },
            },
        
          "required": [
          "nom","caracteristique","utilisation","prix","stocka"
    
        ]
        };

      $scope.form = [
        "nom","caracteristique","utilisation","prix","stocka",
        {
          key:"image",
          title: "Image",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          key:"file",
          title: "File",
          description: "",
          placeholder: "Add file",

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
          url     : base +'/article/add',

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn(data.message, 10000);
              }
              else
              {
                flare.warn(data.message, 10000);

              }
              
  
             }
             else
             {
              flare.warn('Article successfull created', 10000);
              $location.path('/article/list');
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
          
      }
      });
}


function EditCtrl($scope, $http,$location,flare,upload,$routeParams) {
    var id = $routeParams.id;
    var url = base + '/article/edit/' +id;

  $http.get(url).success(function(data)
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
            prix: {type: "number", title: "Price",default:$scope.article.prix},
            stocka: {type: "number", title: "Stock Alerte",default:$scope.article.stocka},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            },
        
          "required": [
          "nom","caracteristique","utilisation","prix","stocka"
    
        ]
        };

      $scope.form = [
        "nom","caracteristique","utilisation","prix","stocka",
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('This  NIC or PASSPORT Number are already use, please try another', 10000);
              }
              else
              {
                flare.warn('Certain values are already use by another user, please try another', 10000);

              }
              
  
             }
             else
             {
              flare.warn('Article successfull update', 10000);
              $location.path('/article/list');
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
          
      }
      });
}

function articleDelCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
    var url = base +'/article/delete/' + $routeParams.id;
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.article = data.data.entity;

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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              flare.warn(data.message, 10000);
  
             }
             else
             {
              flare.warn('Article successfull delete', 10000);
              $location.path('/article/list');
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
      }
      });

 }

 //gestion des magasins

 function antenneListCtrl($scope, $location,$http,flare) 
{
  

  $http.get(base + '/antenne/list').success(function(data) 
  {
    $scope.antennes = data.data.entities;
    $scope.currentPage = 1;
    $scope.pageSize = 2;
    $scope.schema = 
    {
        type: "object",
        properties: {
            id: { type: "number", title: "id"},

          },
          "required" :["id"]
    };

    $scope.form =["id" ,{type: "submit", title: "Save"}];
    $scope.model = { };

   });
}

function antenneOneCtrl($scope, $http,flare,$routeParams) 
{
  
  var url = base + '/antenne/show/'+$routeParams.id;
  $http.get(url).success(function(data) {
    $scope.magasins = data.data.entities;
              $scope.antenne = data.data.antenne;

              $scope.currentPage = 1;
    $scope.pageSize = 5;
    
  });
 }

 function antenneAddCtrl($scope, $http,$location,flare,upload) {

  var url = base +'/antenne/add';
  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('Error', 10000);
              }
              else
              {
                flare.warn('Error', 10000);

              }
              
  
             }
             else
             {
              flare.warn('Office successfull created', 10000);
              $location.path('/antenne/list');
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     }}
      });
}

function antenneEditCtrl($scope, $http,$location,flare,upload,$routeParams) {

  var url = base + '/antenne/edit/' + $routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('Error', 10000);
              }
              else
              {
                flare.warn('Error', 10000);

              }
              
  
             }
             else
             {
              flare.warn('Office successfull update', 10000);
              $location.path('/antenne/list');
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          
      }
      });
}

function antenneDelCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
  var url = base +'/antenne/delete/'+ $routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              flare.warn(data.message, 10000);
  
             }
             else
             {
              flare.warn('Office successfull delete', 10000);
              $location.path('/antenne/list');
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          
      }
      });

 }

 //gestion des boutiques
 function shopOneCtrl($scope, $http,flare,$routeParams) 
{
  
  var url = base + '/antenne/shop/' + $routeParams.id;
  $http.get(url).success(function(data) {
    $scope.stocks = data.data.entities;
    $scope.magasin = data.data.magasin;
    $scope.currentPage = 1;
    $scope.pageSize = 5;
    
  });
   

 }

 function shopAddCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  var url = base + '/antenne/shop/add/'+$routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 10000);
  
             }
             else
             {
              flare.warn('Shop successfull created', 10000);

              var addr = '/antenne/show/'+$scope.antenne.id;
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
      }
      });
}

function shopEditCtrl($scope, $http,$location,flare,upload,$routeParams) {

  var url = base + '/shop/edit/'+$routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 10000);
  
             }
             else
             {
              flare.warn('Shop successfull update', 10000);

              var addr = '/antenne/show/'+$scope.magasin.antenne.id;
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          
      }
      });
}

function shopDelCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
  var url = base + '/shop/delete/'+$routeParams.id;
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.magasin = data.data.entity;


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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              flare.warn(data.message, 10000);
  
             }
             else
             {
              flare.warn('Shop successfull delete', 10000);
              var addr = '/antenne/show/'+$scope.magasin.antenne.id;
              $location.path(addr);
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          
      }
      });

 }

function stockAddCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {
  var url = base + '/shop/stock/add/'+$routeParams.id;

  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 10000);
  
             }
             else
             {
              var addr = '/antenne/shop/'+ data.data.entity.id;
              flare.warn('Stock successfull created', 10000);
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
          
      }
      });
}

function stockDelCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
    var url = base +'/shop/stock/remove/' + $routeParams.id;

    $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.stock = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: 
        {
            
            actif: {type: "boolean", title: "Are You Sure",default:true},
            
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

        if($scope.stock.quantite >0)
        {
          flare.warn('impossible because avaible stock ' + $scope.stock.quantite , 5000);
          form.$valid =false;
        }
      
        if (form.$valid)
        {
          $http({

          method  : 'POST',
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            
            if(data.code > 0)
             {
              flare.warn(data.message, 10000);
  
             }
             else
             {
              var addr = '/antenne/shop/'+ data.data.entity.magasin.id;
              flare.warn('stock successfull remove', 10000);
              $location.path(addr);
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      }
      }
      });

 }

 function entreeCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  var url = base + '/stock/in/'+$routeParams.id;
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.stock = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            libelle: {type: "string", title: "Object",minLength:5},
            quantite: {type: "integer", title: "Quantity",min:1},
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
             
                flare.warn(data.message, 5000);
  
             }
             else
             {
              flare.warn('entry successfull created', 5000);

              var addr = '/antenne/shop/'+data.data.entity.magasin.id;
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
          
      }
      });
}

function sortieCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  var url = base + '/stock/out/'+$routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
                if(data.code == 1)
                {
                  flare.warn('insufficient stock', 5000);
                }
                flare.warn(data.message, 5000);
  
             }
             else
             {
              var addr = '/antenne/shop/'+data.data.entity.magasin.id;
              flare.warn('outflow successfull added', 5000);
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
        
      }
      });
}

function statCtrl($scope, $http,flare,$routeParams,$window) 
{
  
  var url = base + '/shop/stat/' +$routeParams.id;
  $http.get(url).success(function(data) 
  {
    $scope.magasin = data.data.magasin;
    $scope.entreesm = data.data.entreesm;
    $scope.sortiesm = data.data.sortiesm;
    $scope.all = data.data.all;
    $scope.archive = data.data.archive;
    $scope.currentPage = 1;
    $scope.pageSize = 10;

  
    });


  $scope.printstat = function()
     {
        var url = base + '/shop/pdf/'+$scope.magasin.id;
        $scope.nom="";

        $http.get(url).success(function(data) 
        {
          $scope.nom = data.data;

          var x;
          if (confirm("File generate") == true) 
          {
             
          } 

          

          $window.open('http://localhost/auth/user/'+$scope.nom, '_blank');
          
          //window.location.reload();
               
          
        });

     }


}

//gestion des projets

function projectCtrl($scope, $http,flare) 
{
  
  var url= base +'/project';

  $http.get(url).success(function(data) 
  {
    $scope.projects = data.data.entities;
    $scope.currentPage = 1;
    $scope.pageSize = 5;


    
  });
   

 }

function projectAddCtrl($scope, $http,$location,flare,upload) {

  var url = base + '/project/add';
  $http.get(url).success(function(data)
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
            file: {
                  type: "string",
                  format: "base64",
                  maxSize: '4048576 ',
                },
            
            
            
            },
        
          "required": [
          "libelle","moa","image",
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
          title: "Image",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          key:"file",
          title: "File",
          description: "",
          placeholder: "Add file",

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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              
                flare.warn(data.message, 5000);

             
  
             }
             else
             {
              flare.warn('Project successfull created', 5000);
              $location.path('/project');
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
      }
      });
}

function projectOneCtrl($scope, $http,flare,$routeParams,$window) 
{
  
  var url = base + '/project/show/' + $routeParams.id;

  $http.get(url).success(function(data) 
  {
    $scope.project = data.data.entity;
    $scope.remain = data.data.remain;
    $scope.test = data.data.entity.statut;
    
 });


  $scope.printstat = function()
 {
    var url = base + '/project/dep/'+$scope.project.id;
    $scope.nom="";

    $http.get(url).success(function(data) 
    {
      $scope.nom = data.data;

      var x;
      if (confirm("File generate") == true) 
      {
         $window.open('http://localhost/auth/user/'+$scope.nom, '_blank');
      } 

      

      
      
      //window.location.reload();
           
      
    });

 }

 }

function evolutionCtrl($scope, $http,$location,flare,upload,$routeParams) {

  var url = base + '/project/evolution/'+$routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
                
                flare.warn(data.message, 20000);
             }
             else
             {
              flare.warn('Evolution successfull created', 20000);
              var addr = '/project/show/'+ $scope.id;
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });;
     
      
      
        }
      }
      });
}

function expenditureCtrl($scope, $http,$location,flare,upload,$routeParams) 
{

  var url = base + '/project/expenditure/' + $routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

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
              var addr='/project/show/' +$scope.id;
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
      }
      });
}

function blocageCtrl($scope, $http,$location,flare,upload,$routeParams) {

  var url = base + '/project/blocking/'+$routeParams.id;
  
  $http.get(url).success(function(data)
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
          url     : url,

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
              var addr = '/project/show/'+ $scope.id;
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
          
      }
      });
}

function endCtrl($scope, $http,$location,flare,upload,$routeParams) 
{
  var url = base + '/project/end/'+$routeParams.id;
  $http.get(url).success(function(data)
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
          url     : url,

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
              var addr = '/project/show/'+ $scope.id;
              $location.path(addr);
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
       
        }
          
      }
      });

 }

function projectACtrl($scope, $http,flare) 
{
  
  var url = base + '/project/archive';
  $http.get(url).success(function(data) 
  {
    $scope.projects = data.data.entities;
    $scope.mon = data.data.month;
    $scope.year = data.data.year;

    $scope.currentPage = 1;
    $scope.pageSize = 10;


    
  });

   

 }

 //gestion des mails

 function mailCtrl($scope, $http,flare,$window) 
{
  
  var url = base + '/mail';
  $http.get(url).success(function(data) {
    $scope.mails = data.data.entities;
     $scope.currentPage = 1;
    $scope.pageSize = 10;

    
  });

  $scope.print = function()
 {
    var url = base + '/mail/pdf';
    $scope.nom="";

    $http.get(url).success(function(data) 
    {
      $scope.nom = data.data;

      var x;
      if (confirm("File generate") == true) 
      {
         $window.open('http://localhost/auth/user/'+$scope.nom, '_blank');
      } 

      

      
      
      //window.location.reload();
           
      
    });

 }
   

 }

 function mailAddCtrl($scope, $http,$location,flare,upload) {

  var url = base + '/mail/add';
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;

        $scope.schema = {
        type: "object",
        properties: 
        {
            libelle: { type: "string", minLength: 2, title: "Title"},
            type: {type: "string", title: "Type", enum: ['Outgoing','Incomming']},
            
            date: {type: "string",title:" Date" ,format: "date"},
            emetteur: { type: "string", minLength: 2, title: "Sender"},
            recepteur: { type: "string", minLength: 2, title: "Receiver"},
            
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
                file: {
                  type: "string",
                  format: "base64",
                  maxSize: '4048576 ',
                },
        },
        
        "required": 
        [
          "libelle","type","emetteur","recepteur"
        ]
        };

        $scope.form = 
        [
         "libelle","type","emetteur","recepteur",
         {
          key: "date",
          type: "datepicker",
          format: "yyyy-mm-dd",
          minDate: new Date(),
          
          
          rangeSelector: true
        }, 
        
        {
          key:"image",
          title: "Image",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          key:"file",
          title: "File",
          description: "",
          placeholder: "Add File",

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
          url     : url,

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
              var addr = '/mail';
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
          
      }
      });
}

function mailstatCtrl($scope, $http,flare) 
{
  
  var url = base + '/mail/archive';
  $http.get(url).success(function(data) 
  {
    $scope.archive = data.data.entities;

    $scope.currentPage = 1;
    $scope.pageSize = 7;

    
  });
   

 }

 // gestion des utilisateurs

 function ListCtrl($scope, $http,flare) 
{
  

  var url = base +'/users';
  $http.get(url).success(function(data) {
    $scope.users = data.data.entities;
    $scope.currentPage = 1;
    $scope.pageSize = 7;
    
  });
   

 }

 function AddCtrl($scope, $http,$location,flare,upload) 
 {

  var url = base +'/user/add';
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.postes = data.data.postes;
       $scope.antennes = data.data.antennes;

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
            role: {type: "string", title: "Role",enum:["ROLE_USER","ROLE_MANAGER"]},
            antenne: {type: "string", title: "Office",enum:$scope.antennes},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            
            
            
            },
        
          "required": [
          "nom","sexe","cni","adresse","telephone","email","poste","role","antenne"
    
        ]
        };

      $scope.form = [
        "nom","prenom","sexe","cni","adresse","telephone","email","poste","role","antenne",
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('This email or CNI / PASSPORT Number are already use, please try another', 10000);
              }
              else
              {
                flare.warn('Certain values are already use by another user, please try another', 10000);

              }
              
  
             }
             else
             {
              flare.warn('User successfull created', 10000);
              var addr ='/users';
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          
        });
     
      
      
        }
      }
      });
}

function profileCtrl($scope, $location,$http,flare,$routeParams,$cookieStore) 
{
  var url = base +'/user/profile/' + $routeParams.id;

  $http.get(url).success(function(data) 
  {
    $scope.user = data.data.entity;
    
   });
}


 function billCtrl($scope, $http,flare,$routeParams,$cookieStore) 
{
  
  $scope.user = $cookieStore.get('globals');

  var url = base + '/user/bill/' + $routeParams.id;

  $http.get(url).success(function(data) 
  {
    $scope.bills = data.data.entities;
    $scope.currentPage = 1;
        $scope.pageSize = 7;
    
    
  });
   

 }

function presenceCtrl($scope, $http,flare,$routeParams,$cookieStore) 
{
  
  $scope.user = $cookieStore.get('globals');

  var url = base + '/user/presence/' + $routeParams.id;

  $http.get(url).success(function(data) 
  {
    $scope.current= data.data.current;
    $scope.all = data.data.all;
    $scope.currentPage = 1;
        $scope.pageSize = 6;
    
    
  });
   

 }


function billaddCtrl($scope, $http,$location,flare,upload,$routeParams) 
{

  var url = base + '/bill/add/' + $routeParams.id;
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.user = data.data.entity;
        

        $scope.schema = {
        type: "object",
        properties: {
         message: { type: "string", minLength: 2, title: "Title"},
         date: {type: "string",title:"Date" ,format: "date"},
          image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
          file: {
                  type: "string",
                  format: "base64",
                  maxSize: '3048576 ',
                },
            
            },
        
          "required": [
          "message","image"
    
        ]
        };

      $scope.form = [
        "message",
        {
          key: "date",
          type: "datepicker",
          format: "yyyy-mm-dd",
          minDate: new Date(),
          
          rangeStartDateField: "datedebut",
          rangeEndDateField: "datefin",
          rangeSelector: true
        },
        {
          key:"image",
          title: "Image",
          description: "",
          placeholder: "Add image",

          validationMessage: {
            "base64FileUploadSize": 'Seriously? Max file size is {{(schema.maxSize / 1024) / 1024}} MB, dude.'
          }
          
        },
        {
          key:"file",
          title: "File upload",
          description: "",
          placeholder: "Add file",

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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn(data.message, 10000);
              }
              else
              {
                flare.warn(data.message, 10000);

              }
              
  
             }
             else
             {
              flare.warn('Bill successfull added', 10000);
              var addr ='/user/profile/' + $scope.user.id;
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          
        });
     
      
      
        }
      }
      });
}

function profileeditCtrl($scope, $http,$location,flare,upload,$routeParams) 
 {

  var url = base +'/profile/edit/' + $routeParams.id;
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.user = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
            cni: {type: "string", minLength: 11, title: "CNI / PASSPORT Number",default:$scope.user.cni},
            adresse: {type: "string", minLength: 3, title: "Adresse",default:$scope.user.adresse},
            telephone: {type: "string", minLength: 11, title: "Phone",default:$scope.user.telephone},
            email: {type: "string","pattern": "^\\S+@\\S+$", minLength: 11, title: "Email",default:$scope.user.email},
            password: {type: "string", minLength: 6, title: "Password"},
            image: {
                  type: "string",
                  format: "base64",
                  maxSize: '1048576 ',
                },
            
            
            
            },
        
          "required": [
          "cni","adresse","telephone","email","password"
    
        ]
        };

      $scope.form = [
        "cni","adresse","telephone","email",
        {
          key:"password",
          title: "Password",
          type: "password",
          
        },
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
          $scope.model.password =  CryptoJS.AES.encrypt(JSON.stringify($scope.model.password), $scope.model.email, {format: CryptoJSAesJson}).toString();

          $http({

          method  : 'POST',
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('This email or CNI / PASSPORT Number are already use, please try another', 10000);
              }
              else
              {
                flare.warn('Certain values are already use by another user, please try another', 10000);

              }
              
  
             }
             else
             {
              flare.warn('Information successfull update', 10000);
              var addr ='/user/profile/' + data.data.entity.id;
              
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          
        });
     
      
      
        }
      }
      });
}

function usereditCtrl($scope,$http,$location,flare,upload,$routeParams) 
 {

  var url = base +'/user/edit/' + $routeParams.id;
  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.postes = data.data.postes;
       $scope.antennes = data.data.antennes;
       $scope.user = data.data.entity;

        $scope.schema = {
        type: "object",
        properties: {
        
        
        poste: {type: "string", title: "Poste",enum:$scope.postes,default:$scope.user.poste.libelle},
        role: {type: "string", title: "Role",enum:["ROLE_USER","ROLE_MANAGER"],default:$scope.user.roles[0]},
        antenne: {type: "string", title: "Office",enum:$scope.antennes,default:$scope.user.antenne.libelle},
        },
        
          "required": [
         "poste","role","antenne"
    
        ]
        };

      $scope.form = [
        "poste","role","antenne",
        
       
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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  
            if(data.code > 0)
             {
              
              var n = data.message.indexOf("INSERT INTO");
              if(n>0)
              {
                flare.warn('This email or CNI / PASSPORT Number are already use, please try another', 10000);
              }
              else
              {
                flare.warn('Certain values are already use by another user, please try another', 10000);

              }
              
  
             }
             else
             {
              flare.warn('User successfully update', 10000);
              var addr ='/users';
              $location.path(addr);
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          
        });
     
      
      
        }
      }
      });
}

function userdelCtrl($scope, $http,flare,$routeParams,$cookieStore,$location) 
{

  var url = base + '/user/delete/' + $routeParams.id;

  $http.get(url).success(function(data)
    {
       $scope.code = data.code;
       $scope.user = data.data.entity;

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
          url     : url,

          data    : $scope.model, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         }).success(function(data) 

         {  $scope.id = data.data.entity.id;
            if(data.code > 0)
             {
              flare.warn(data.message, 10000);
  
             }
             else
             {
              flare.warn('user successfully delete', 10000);
              $location.path('/users');
              
             }
          
            
          })
          .finally(function () {
          // Hide loading spinner whether our call succeeded or failed.
          $scope.loading = false;
        });
     
      
      
        }
      }
      });
  

 }

//ststistique générale
function statgeneralCtrl($scope, $http,flare,$routeParams) 
{
  
  var url = base + '/stat/general';

  $http.get(url).success(function(data) 
  {
    $scope.antennes = data.data.entities;
    $scope.currentPage = 1;
        $scope.pageSize = 6;
   
    
 });

 }

 function statantCtrl($scope, $http,flare,$routeParams,$window) 
{
  
  var url = base + '/stat/antenne/'+ $routeParams.id;

  $http.get(url).success(function(data) 
  {
    $scope.presences = data.data.entities;
    $scope.antenne = data.data.antenne;
    $scope.stocks = data.data.stocks;
    $scope.ids = data.data.ids;
    $scope.currentPage = 1;
        $scope.pageSize = 10;

   
    
 });

    $scope.print = function(id)
 {
    var url = base + '/presence/pdf/'+id;
    $scope.nom="";

    $http.get(url).success(function(data) 
    {
      $scope.nom = data.data;

      var x;
      if (confirm("File generate") == true) 
      {
         $window.open('http://localhost/auth/user/'+$scope.nom, '_blank');
      } 

      

      
      
      //window.location.reload();
           
      
    });

 }

 $scope.prints = function(nom)
 {
    
    var url = base + '/ant/pdf/'+$scope.ids[nom];
    $scope.nom="";

    $http.get(url).success(function(data) 
    {
      $scope.nom = data.data;

      var x;
      if (confirm("File generate") == true) 
      {
         $window.open('http://localhost/auth/user/'+$scope.nom, '_blank');
      } 

      

      
      
      //window.location.reload();
           
      
    });

 }


 }

