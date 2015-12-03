angular.module('routes',['ngRoute'])
.config(function($routeProvider){
  $routeProvider
  .when('/',{
    templateUrl : 'views/index.html',
    controller : 'login'
  })
  .when('/needsList',{
    templateUrl : 'views/needsList.html',
    controller : 'needsList'
  })
  .otherwise({
    redirectTo : '/'
  })
})
