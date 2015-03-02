/**
 * @name ReceptionController
 * @constructor
 * @desc Controla la vista para capturar la recepción de muestras
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReceptionistService - Proveedor de datos, Recepcionistas
 * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
 */
function ReceptionController(ReceptionistService, ReceptionService) {
  var vm = this;
  vm.receptionists = ReceptionistService.query();
  vm.reception = ReceptionService.query();

  vm.selectReceptionist = selectReceptionist;
  vm.validateReceptionForm = validateReceptionForm;
  vm.submitReceptionForm = submitReceptionForm;

  function selectReceptionist(idRecepcionist) {
    var i = 0, l = vm.receptionists.length;
    vm.reception.recepcionista = {};
    for (i; i < l; i += 1) {
      if (vm.receptionists[i].id_empleado == idRecepcionist)
      {
        vm.reception.recepcionista = vm.receptionists[i];
        break;
      }
    }
    return vm.reception.recepcionista;
  }

  function validateReceptionForm() {

  }

  function submitReceptionForm() {
    //send to verification service
  }
}

angular
  .module('siclabApp')
  .controller('ReceptionController',
    [
      'ReceptionistService', 'ReceptionService',
      ReceptionController
    ]
  );