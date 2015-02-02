/**
 * @name ClientDetailController
 * @constructor
 * @desc Controla la vista para con el detalle de un Cliente
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ClientDetailService - Proveedor de datos, Detalle cliente
 */
function ClientDetailController($scope, ClientDetailService) {
  $scope.clientDetail = ClientDetailService.query();
}

angular
  .module('siclabApp')
  .controller('ClientDetailController',
    [
      '$scope',
      'ClientDetailService',
      ClientsListController
    ]
  );