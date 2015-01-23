/**
 * @name AnalysisController
 * @constructor
 * @desc Controla la vista para seleccionar formato de captura de Análisis
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} AreaService - Proveedor de datos, Áreas
 * @param {Object} ParameterService - Proveedor de datos, Parámetros
 * @param {Object} AnalysisService - Proveedor de datos, selección de formato de captura de Análisis
 */
function AnalysisController(AreaService, ParameterService, AnalysisService) {
  var vm = this;
  vm.areas = AreaService.query();
  vm.parameters = ParameterService.query();
  vm.analysis = AnalysisService.query();

  vm.selectArea = selectArea;
  vm.selectParameter = selectParameter;

  vm.validateAnalysisForm = validateAnalysisForm;
  vm.submitAnalysisForm = submitAnalysisForm;

  function selectArea() {

  }

  function selectParameter() {

  }

  function validateAnalysisForm() {

  }

  function submitAnalysisForm() {

  }
}

angular
  .module('siclabApp')
  .controller('AnalysisController',
    [
      'AreaService', 'ParameterService',
      'AnalysisService',
      AnalysisController
    ]
  );