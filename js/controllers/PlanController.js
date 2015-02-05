/**
 * @name PlanController
 * @constructor
 * @desc Controla la vista para capturar un Plan muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PlanObjectivesService - Proveedor de datos, Objetivos Plan muestreo
 * @param {Object} PlanService - Proveedor de datos, Plan muestreo
 */
function PlanController(PlanObjectivesService, PlanService) {
  var vm = this;
  vm.plan = PlanService.query();
  vm.objectives = PlanObjectivesService.query();
  vm.addPoints = addPoints;
  vm.selectObjective = selectObjective;
  vm.selectPointType = selectPointType;
  vm.selectSamplingSupervisor = selectSamplingSupervisor;
  vm.selectCollectingSupervisor = selectCollectingSupervisor;
  vm.selectLoggingSupervisor = selectLoggingSupervisor;

  function addPoints() {

  }

  function selectObjective() {

  }

  function selectPointType() {

  }

  function selectSamplingSupervisor() {

  }

  function selectCollectingSupervisor() {

  }

  function selectLoggingSupervisor() {

  }
  //
}

angular
  .module('siclabApp')
  .controller('PlanController',
    [
      'PlanObjectivesService', 'PlanService',
      PlanController
    ]
  );