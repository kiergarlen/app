/**
 * @name SamplesListController
 * @constructor
 * @desc Controla la vista para consulta de Muestras
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} SamplesListService - Proveedor de datos, lista Muestras
 */
function SamplesListController(SamplesListService) {
  var vm = this;
  vm.pricesList = SamplesListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('SamplesListController',
    [
      'SamplesListService',
      SamplesListController
    ]
  );