/**
 * @name NormsListController
 * @constructor
 * @desc Controla la vista para consulta de Normas
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} NormsListService - Proveedor de datos, lista Normas
 */
function NormsListController(NormsListService) {
  var vm = this;
  vm.clients = NormsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('NormsListController',
    [
      'NormsListService',
      NormsListController
    ]
  );