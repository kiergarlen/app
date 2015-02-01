/**
 * @name LogoutController
 * @constructor
 * @desc Controla la vista para Logout
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} LogoutService - Proveedor de datos, Logout
 */
function LogoutController(LogoutService) {
  var vm = this;
  vm.logout = LogoutService.query();
}

angular
  .module('siclabApp')
  .controller('LogoutController',
    [
      'LogoutService',
      LogoutController
    ]
  );