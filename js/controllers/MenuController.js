/**
 * @name MenuController
 * @constructor
 * @desc Controla la vista para el Menú principal
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} MenuService - Proveedor de datos, Menú
 */
function MenuController($scope, MenuService) {
  $scope.menu = MenuService.query();
}

angular
  .module('siclabApp')
  .controller('MenuController',
    [
      '$scope',
      'MenuService',
      MenuController
    ]
  );