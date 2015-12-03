angular.module('components',[])
.directive('customComponent',function(){
  return {
    restrict : 'E',
    scope : {},
    templateUrl : 'components/customComponent.html',
    link : function($scope,$element,$attrs){
      
    }
  }
})
