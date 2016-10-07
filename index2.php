<!DOCTYPE html>
<html lang="en" ng-app="myApp">

  <head>
    <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
          <title>AngularJS Authentication App</title>
          <!-- Bootstrap -->
          <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="css/custom.css" rel="stylesheet">
              <link href="css/toaster.css" rel="stylesheet">
                <style>
                  a {
                  color: orange;
                  }
                </style>
                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]><link href= "css/bootstrap-theme.css"rel= "stylesheet" >

<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
              </head>

  <body ng-cloak="" >
  <div class="container">
  
    <nav class="back navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				
					<img alt="Brand" height="50" src="img/logo.png">
				
			</div>
		</div>
	</nav>
	
	
	
    
		
      <div class="container" style="margin-top:20px;">
		<div class="nav pull-right">
			<toaster-container toaster-options="{'time-out': 3000}"></toaster-container>
		</div>
		

        <div data-ng-view="" id="ng-view" class="row slide-animation">
		
		
		</div>

      </div>
	  </div>
    </body>
	
  
  <!-- Libs -->
  <script src="js/angular.min.js"></script>
  <script src="js/angular-route.min.js"></script>
  <script src="js/angular-animate.min.js" ></script>
  <script src="js/toaster.js"></script>
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  <script src="app/authCtrl.js"></script>
</html>

