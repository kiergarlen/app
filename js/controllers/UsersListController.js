/**
 * @name UsersListController
 * @constructor
 * @desc Controla la vista para el listado de Usuarios
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} UsersListService - Proveedor de datos, Usuarios
 */
function UsersListController (UsersListService) {
  var vm = this;
  vm.users = UsersListService.query();
}

angular
  .module('siclabApp')
  .controller('UsersListController',
    [
      'UsersListService',
      UsersListController
    ]
  );