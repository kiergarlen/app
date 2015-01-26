/**
 * @name ClientsListController
 * @constructor
 * @desc Controla la vista para consulta de Clientes
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ClientsService - Proveedor de datos, lista Clientes
 */
function ClientsListController(ClientService) {
  var vm = this;
  vm.clients = ClientService.query();
}

angular
  .module('siclabApp')
  .controller('ClientsListController',
    [
      'ClientService',
      ClientsListController
    ]
  );