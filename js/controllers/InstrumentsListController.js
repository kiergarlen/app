/**
 * @name InstrumentsListController
 * @constructor
 * @desc Controla la vista para consulta de Equipos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} InstrumentsListService - Proveedor de datos, lista Equipos
 */
function InstrumentsListController(InstrumentsListService) {
  var vm = this;
  vm.clients = InstrumentsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('InstrumentsListController',
    [
      'InstrumentsListService',
      InstrumentsListController
    ]
  );