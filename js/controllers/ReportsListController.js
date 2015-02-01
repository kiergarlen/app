/**
 * @name ReportsListController
 * @constructor
 * @desc Controla la vista para consulta de Reportes
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReportsListService - Proveedor de datos, lista Reportes
 */
function ReportsListController(ReportsListService) {
  var vm = this;
  vm.pricesList = ReportsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('ReportsListController',
    [
      'ReportsListService',
      ReportsListController
    ]
  );