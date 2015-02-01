/**
 * @name ReferencesListController
 * @constructor
 * @desc Controla la vista para consulta de Referencias
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReferencesListService - Proveedor de datos, lista Referencias
 */
function ReferencesListController(ReferencesListService) {
  var vm = this;
  vm.ReferencesList = ReferencesListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('ReferencesListController',
    [
      'ReferencesListService',
      ReferencesListController
    ]
  );