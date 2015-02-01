/**
 * @name ReactivesListController
 * @constructor
 * @desc Controla la vista para consulta de Reactivos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReactivesListService - Proveedor de datos, lista Reactivos
 */
function ReactivesListController(ReactivesListService) {
  var vm = this;
  vm.pricesList = ReactivesListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('ReactivesListController',
    [
      'ReactivesListService',
      ReactivesListController
    ]
  );