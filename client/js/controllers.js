var APIPATH = "http://localhost:3000/"
var app = angular.module('MyApp',['components','routes'])
.controller('global',function($scope){

})
.controller('login',function($scope,$http){
  $scope.WindowHeight = window.innerHeight

  $scope.Login = function(){
    $http({
      method: 'GET',
      url: '/someUrl'
    }).then(function successCallback(response) {
        // this callback will be called asynchronously
        // when the response is available
      }, function errorCallback(response) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });
  }

})
.controller('needsList',function($scope){

})
