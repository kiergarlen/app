/**
 * @name CustodyController
 * @constructor
 * @desc Controla la vista para capturar las Hojas de custodia
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PreservationService - Proveedor de datos, Preservaciones
 * @param {Object} ExpirationService - Proveedor de datos, Vigencias
 * @param {Object} RequiredVolumeService - Proveedor de datos, Volúmenes requeridos
 * @param {Object} ContainerService - Proveedor de datos, Recipientes
 * @param {Object} CheckerService - Proveedor de datos, Responsables verificación
 * @param {Object} CustodyService - Proveedor de datos, Cadenas custodia
 */
function CustodyController(PreservationService, ExpirationService,
  RequiredVolumeService, ContainerService, CheckerService,
  CustodyService) {
  var vm = this;
  vm.preservations = PreservationService.query();
  vm.expirations = ExpirationService.query();
  vm.volumes = RequiredVolumeService.query();
  vm.containers = ContainerService.query();
  vm.checkers = CheckerService.query();
  vm.custody = CustodyService.query();

  vm.selectChecker = selectChecker;

  vm.validateCustodyForm = validateCustodyForm;
  vm.submitCustodyForm = submitCustodyForm;

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

  function selectChecker(idChecker) {
    selectItemFromCollection(
      idChecker,'id_responsable_verificacion', vm.checkers
    );
  }

  function validateCustodyForm() {

  }

  function submitCustodyForm () {

  }
}

angular
  .module('siclabApp')
  .controller('CustodyController',
    [
      'PreservationService', 'ExpirationService', 'RequiredVolumeService',
      'ContainerService', 'CheckerService', 'CustodyService',
      CustodyController
    ]
  );