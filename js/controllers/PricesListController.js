/**
 * @name PricesListController
 * @constructor
 * @desc Controla la vista para consulta de Precios
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PricesListService - Proveedor de datos, lista Precios
 */
function PricesListController(PricesListService) {
  var vm = this;
  vm.pricesList = PricesListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('PricesListController',
    [
      'PricesListService',
      PricesListController
    ]
  );