function MenuController($scope, MenuService) {
  $scope.menu = MenuService.query();
}

angular
  .module('siclabApp')
  .controller('MenuController',
  ['$scope', 'MenuService',
  MenuController
]);