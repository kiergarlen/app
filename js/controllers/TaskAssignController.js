/**
 * @name TaskAssignController
 * @constructor
 * @desc Controla la vista para capturar las Órdenes de trabajo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ChemicalSupervisorService - Proveedor de datos, Supervisores físicoquimico
 * @param {Object} MetalSupervisorService - Proveedor de datos, Supervisores metales pesados
 * @param {Object} BioSupervisorService - Proveedor de datos, Supervisores microbiológico
 * @param {Object} TaskAssignService - Proveedor de datos, Órdenes trabajo
 */
function TaskAssignController(ChemicalSupervisorService,
  MetalSupervisorService, BioSupervisorService, TaskAssignService) {
  var vm = this;
  vm.chemicalSupervisors = ChemicalSupervisorService.query();
  vm.metalSupervisors = MetalSupervisorService.query();
  vm.bioSupervisors = BioSupervisorService.query();
  vm.taskAssign = TaskAssignService.query();

  vm.selectChemicalSupervisor = selectChemicalSupervisor;
  vm.selectMetalSupervisor = selectMetalSupervisor;
  vm.selectSupervisorBio = selectSupervisorBio;

  vm.validateTaskAssignForm = validateTaskAssignForm;
  vm.submitTaskAssignForm = submitTaskAssignForm;

  function selectItemFromCollection(id, collection, field) {
    var i = 0, l = collection.length,
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

  function selectChemicalSupervisor(idSup) {
    selectItemFromCollection(
      idSup,'id_empleado', vm.chemicalSupervisors
    );
  }

  function selectMetalSupervisor(idSup) {
    selectItemFromCollection(
      idSup,'id_empleado', vm.metalSupervisors
    );
  }

  function selectSupervisorBio(idSup) {
    selectItemFromCollection(
      idSup,'id_empleado', vm.bioSupervisors
    );
  }

  function validateTaskAssignForm() {

  }

  function submitTaskAssignForm () {

  }
}

angular
  .module('siclabApp')
  .controller('TaskAssignController',
    [
      'ChemicalSupervisorService', 'MetalSupervisorService',
      'BioSupervisorService', 'TaskAssignService',
      TaskAssignController
    ]
  );