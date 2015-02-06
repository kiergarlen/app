/**
 * @name PlanController
 * @constructor
 * @desc Controla la vista para capturar un Plan muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PlanObjectivesService - Proveedor de datos, Objetivos Plan muestreo
 * @param {Object} PointKindsService - Proveedor de datos, tipos Punto
 * @param {Object} PlanService - Proveedor de datos, Plan muestreo
 */
function PlanController(PlanObjectivesService, PointKindsService,
  PlanService) {
  var vm = this;
  vm.plan = PlanService.query();
  vm.objectives = PlanObjectivesService.query();
  vm.pointKinds = PointKindsService.query();
  vm.addPoints = addPoints;
  vm.selectObjective = selectObjective;
  vm.selectPointType = selectPointType;
  vm.selectSamplingSupervisor = selectSamplingSupervisor;
  vm.selectCollectingSupervisor = selectCollectingSupervisor;
  vm.selectLoggingSupervisor = selectLoggingSupervisor;


  function selectItemFromCollection(id, collection, field) {
    var i = 0,
    l = collection.length,
    item = {};
    for (i; i < l; i += 1) {
      if (collection[i][field] == id)
      {
        item = collection[i];
        break;
      }
    }
    return item;
  }

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
      'PlanObjectivesService', 'PointKindsService',
      'PlanService',
      PlanController
    ]
  );