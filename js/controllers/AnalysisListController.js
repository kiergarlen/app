/**
 * @name AnalysisListController
 * @constructor
 * @desc Controla la vista para la búsqueda de Análisis
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} AnalysisListService - Proveedor de datos, Análisis
 */
function AnalysisListController(AnalysisListService) {
  var vm = this;
  vm.analysisList = AnalysisListService.query();

  vm.selectRow = selectRow;
  function selectRow() {
    //TODO send to details view
    console.log('clicked in row');
  }
}

angular
  .module('siclabApp')
  .controller('AnalysisListController',
    [
      'AnalysisListService',
      AnalysisListController
    ]
  );