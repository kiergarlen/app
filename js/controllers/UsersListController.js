/**
 * @name UsersListController
 * @constructor
 * @desc Controla la vista para el listado de Usuarios
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} UserService - Proveedor de datos, Usuarios
 */
function UsersListController (UserService) {
  var vm = this;
  vm.users = UserService.query();
}

angular
  .module('siclabApp')
  .controller('UsersListController',
    [
      '$scope',
      'UserService',
      UsersListController
    ]
  );