  // CustodyController.js
  /**
   * @name CustodyController
   * @constructor
   * @desc Controla la vista para capturar las Hojas de custodia
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} ExpirationService - Proveedor de datos, Vigencias
   * @param {Object} RequiredVolumeService - Proveedor de datos, Volúmenes requeridos
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   * @param {Object} CheckerService - Proveedor de datos, Responsables verificación
   * @param {Object} CustodyService - Proveedor de datos, Cadenas de custodia
   */
  function CustodyController($routeParams, TokenService, ArrayUtilsService,
    PreservationService, ExpirationService, RequiredVolumeService,
    ContainerService, CheckerService, CustodyService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.preservations = PreservationService.get();
    vm.expirations = ExpirationService.get();
    vm.volumes = RequiredVolumeService.get();
    vm.containers = ContainerService.get();
    vm.checkers = CheckerService.get();
    vm.custody = CustodyService.query({custodyId: $routeParams.custodyId});

    vm.selectChecker = selectChecker;

    vm.validateCustodyForm = validateCustodyForm;
    vm.submitCustodyForm = submitCustodyForm;

    function selectChecker(idChecker) {
      ArrayUtilsService.selectItemFromCollection(
        vm.checkers,
        'id_responsable_verificacion',
        idChecker
      );
    }

    function validateCustodyForm() {

    }

    function submitCustodyForm () {

    }
  }
  angular
    .module('sislabApp')
    .controller('CustodyController',
      [
        '$routeParams', 'TokenService', 'ArrayUtilsService',
        'PreservationService', 'ExpirationService', 'RequiredVolumeService',
        'ContainerService', 'CheckerService', 'CustodyService',
        CustodyController
      ]
    );
