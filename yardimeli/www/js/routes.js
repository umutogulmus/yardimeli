angular.module('routes',['ngRoute'])
.config(function($routeProvider){
  $routeProvider
  .when('/',{
    templateUrl : 'views/index.html',
    controller : 'global'
  })
  .when('/needsList',{
    templateUrl : 'views/needsList.html',
    controller : 'needsList'
  })
  .when('/donate/:need_id',{
    templateUrl : 'views/donate.html',
    controller : 'donate'
  })
  .otherwise({
    redirectTo : '/'
  })
})
