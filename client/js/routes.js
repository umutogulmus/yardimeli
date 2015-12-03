angular.module('routes',['ngRoute'])
.config(function($routeProvider){
  $routeProvider
  .when('/',{
    templateUrl : 'views/index.html',
    controller : 'global'
  })
  .otherwise({
    redirectTo : '/'
  })
})
