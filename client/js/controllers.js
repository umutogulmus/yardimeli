var APIPATH = "http://localhost:3001/api/api.php"
var app = angular.module('MyApp',['components','routes'])
.controller('global',function($scope,$rootScope){
    $scope.WindowHeight = window.innerHeight
    console.log($scope.WindowHeight)
    $scope.Login = function(){
      $scope.User.Action = "Login"
      $.post(APIPATH,$scope.User,function(response){
        if(response.status){
          $rootScope.UserInfo = response.info
          window.location = '#/needsList'
        }
        else{
          alert(response.message)
        }
      })
    }
    $scope.Register = function(){
      $scope.User.Action = "Registers"
      $.post(APIPATH,$scope.User,function(response){
        if(response.status){
          window.location = '#/needsList'
        }
        else{
          alert(response.message)
        }
      })
    }
})
.controller('needsList',function($scope){
  $scope.WindowHeight = window.innerHeight
  console.log('Fetching needs list')
  // Fetch Needs of Organizations
  $.post(APIPATH,{Action:'GetNeeds'},function(response){
    $scope.Needs = response
    $scope.$apply()
  })
})
.controller('donate',function($scope,$rootScope,$routeParams){
  $scope.WindowHeight = window.innerHeight

  $scope.Donate = function(){

    $.post(APIPATH,{
      donator_id : $rootScope.UserInfo._id,
      need_id : $routeParams.need_id,
      message : $scope.Message,
      Action : 'Donate'
    },function(response){
      if(response.status){
        alert(response.message)
      }
      else{
        alert(response.message)
      }
    })
  }
})
