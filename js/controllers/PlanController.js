/**
 * @name PlanController
 * @constructor
 * @desc Controla la vista para capturar un Plan muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PlanObjectivesService - Proveedor de datos, Objetivos Plan muestreo
 * @param {Object} PointKindsService - Proveedor de datos, tipos Punto
 * @param {Object} DistrictService - Proveedor de datos, Municipios
 * @param {Object} CityService - Proveedor de datos, Localidades
 * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
 * @param {Object} PreservationService - Proveedor de datos, Preservaciones
 * @param {Object} ContainerService - Proveedor de datos, Recipientes
 * @param {Object} ReactivesListService - Proveedor de datos, lista Reactivos
 * @param {Object} MaterialService - Proveedor de datos, Material
 * @param {Object} CoolerService - Proveedor de datos, lista Hieleras
 * @param {Object} PlanService - Proveedor de datos, Plan muestreo
 */
function PlanController(PlanObjectivesService, PointKindsService,
  DistrictService, CityService, SamplingSupervisorService,
  PreservationService, ContainerService, ReactivesListService,
  MaterialService, CoolerService,
  PlanService) {
  var vm = this;
  vm.plan = PlanService.query();
  vm.objectives = PlanObjectivesService.query();
  vm.pointKinds = PointKindsService.query();
  vm.districts = DistrictService.query();
  vm.cities = CityService.query(vm.plan.id_municipio);
  vm.samplingSupervisors = SamplingSupervisorService.query();
  vm.preservations = PreservationService.query();
  vm.reactives = ReactivesListService.query();
  vm.containers = ContainerService.query();
  vm.materials = MaterialService.query();
  vm.coolers = CoolerService.query();
  vm.addPoints = addPoints;

  vm.selectDistrict = selectDistrict;

  vm.countSelectedItems = countSelectedItems;

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

  function countSelectedItems(collection){
    var i, l, count = 0;
    if (!collection)
    {
      return 0;
    }
    l = collection.length;
    for (i = 0; i < l; i += 1) {
      if (collection[i].selected)
      {
        count += 1;
      }
    }
    return count;
  }

  function addPoints() {

  }

  function selectDistrict() {
    vm.cities = CityService.query(vm.plan.id_municipio);
  }
}

angular
  .module('siclabApp')
  .controller('PlanController',
    [
      'PlanObjectivesService', 'PointKindsService',
      'DistrictService', 'CityService', 'SamplingSupervisorService',
      'PreservationService', 'ContainerService', 'ReactivesListService',
      'MaterialService', 'CoolerService',
      'PlanService',
      PlanController
    ]
  );