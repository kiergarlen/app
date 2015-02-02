/**
 * @name ClientsListController
 * @constructor
 * @desc Controla la vista para el listado de Clientes
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ClientService - Proveedor de datos, Cliente
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
