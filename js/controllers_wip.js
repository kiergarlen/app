  // SheetController.js
  /**
   * @name SheetController
   * @constructor
   * @desc Controla la vista para capturar la hoja de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} CloudService - Proveedor de datos, Coberturas nubes
   * @param {Object} WindService - Proveedor de datos, Direcciones viento
   * @param {Object} WaveService - Proveedor de datos, Intensidades oleaje
   * @param {Object} SamplingNormService - Proveedor de datos, Normas muestreo
   * @param {Object} PointService - Proveedor de datos, Puntos de muestreo
   * @param {Object} FieldParameterService - Proveedor de datos, Parámetros campo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} SheetService - Proveedor de datos, Hojas de campo
   */
  function SheetController($routeParams, TokenService, ValidationService,
    ArrayUtilsService, DateUtilsService, CloudService,
    WindService, WaveService, SamplingNormService,
    PointService, FieldParameterService, PreservationService,
    SheetService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.sheet = SheetService.query({sheetId: $routeParams.sheetId});
    vm.cloudCovers = CloudService.get();
    vm.windDirections = WindService.get();
    vm.waveIntensities = WaveService.get();
    vm.samplingNorms = SamplingNormService.get();
    vm.preservations = PreservationService.get();
    /*
    SheetService
      .query({sheetId: $routeParams.sheetId})
      .$promise
      .then(function success(response) {
        vm.sheet = response;
      });
    */
    vm.isPreservationListLoaded = false;
    vm.isDataSubmitted = false;
    vm.selectPreservations = selectPreservations;
    vm.isResultListValid = isResultListValid;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;

    function selectPreservations() {
      var items = [];
      if (vm.preservations.length > 0 && vm.sheet.preservaciones)
      {
        if (vm.sheet.preservaciones.length > 0 && !vm.isPreservationListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.preservations,
            vm.sheet.preservaciones,
            'id_preservacion',
            [
              'selected'
            ]
          );
          vm.isPreservationListLoaded = true;
        }
        else
        {
          vm.sheet.preservaciones = [];
          vm.sheet.preservaciones = ArrayUtilsService.selectItemsFromCollection(
            vm.preservations,
            'selected',
            true
          ).slice();
        }
      }
    }

    function approveItem() {
      ValidationService.approveItem(vm.sheet, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.sheet, vm.user);
    }

    function isResultListValid() {
      var i = 0,
      j = 0,
      l = 0,
      m = 0,
      samples = [],
      results = [];
      if (vm.sheet.muestras && vm.sheet.muestras.length > 0)
      {
        samples = vm.sheet.muestras;
        l = samples.length;
        for (i = 0; i < l; i += 1) {
          if (!DateUtilsService.isValidDate(new Date(samples[i].fecha_muestreo)))
          {
            vm.message += ' Ingrese una fecha/hora válida para el punto ';
            vm.message += samples[i].punto + ' ';
            return false;
          }
          console.log(samples[i].resultados.slice());
          break;
            /*
          results = samples[i].resultados.slice();
          m = results.length;
          for (j = 0; j < m; j += 1) {
            if (isNaN(samples[i].cantidad) || samples[i].cantidad < 1)
            {
              vm.message += ' Ingrese cantidad, para el reactivo ';
              vm.message += '(Ver fila ' + (i + 1) + ')';
              return false;
            }
            if (isNaN(samples[i].lote) || samples[i].lote < 1)
            {
              vm.message += ' Ingrese lote, para el reactivo ';
              vm.message += '(Ver fila ' + (i + 1) + ')';
              return false;
            }
          }
            */
        }
      }
      else
      {
        vm.message += ' No hay resultados ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (vm.sheet.id_metodo_muestreo < 1)
      {
        vm.message += ' Seleccione una Norma de referencia ';
        return false;
      }
      if (!DateUtilsService.isValidDate(new Date(vm.sheet.fecha_inicio)))
      {
        vm.message += ' Ingrese una fecha/hora válida de muestreo ';
        return false;
      }
      if (!vm.isResultListValid)
      {
        return false;
      }
      /*
      if (vm.sheet.id_nubes < 1)
      {
        vm.message += ' Seleccione una cobertura de nubes ';
        return false;
      }
      if (vm.sheet.id_direccion_corriente < 1)
      {
        vm.message += ' Seleccione una dirección de corriente ';
        return false;
      }
      if (vm.sheet.id_oleaje < 1)
      {
        vm.message += ' Seleccione una intensidad del oleaje ';
        return false;
      }
      if (vm.sheet.preservaciones.length < 1)
      {
        vm.message += ' Seleccione al menos un tipo de preservación ';
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.sheet.id_status == 3 && vm.sheet.motivo_rechaza.length < 1)
        {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      */
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        console.log(vm.sheet);
        vm.isDataSubmitted = true;
        if (vm.sheet.id_hoja > 0)
        {
          RestUtilsService
            .saveData(
              SheetService,
              vm.sheet,
              'recepcion/hoja',
              'id_hoja'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.sheet.sheet.id_status < 2)
          {
            RestUtilsService
              .updateData(
                SheetService,
                vm.sheet,
                'recepcion/hoja',
                'id_hoja'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('SheetController',
      [
        '$routeParams', 'TokenService', 'ValidationService',
        'ArrayUtilsService', 'DateUtilsService', 'CloudService',
        'WindService', 'WaveService', 'SamplingNormService',
        'PointService', 'FieldParameterService', 'PreservationService',
        'SheetService',
        SheetController
      ]
    );

  // ReceptionController.js
  /**
   * @name ReceptionController
   * @constructor
   * @desc Controla la vista para capturar la recepción de muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReceptionistService - Proveedor de datos, Recepcionistas
   * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
   */
  function ReceptionController($routeParams, ReceptionistService,
    ReceptionService) {
    var vm = this;
    vm.receptionists = ReceptionistService.get();
    vm.reception = ReceptionService.query({receptionId: $routeParams.sheetId});

    vm.selectReceptionist = selectReceptionist;
    vm.validateForm = validateForm;
    vm.submitReceptionForm = submitReceptionForm;

    function selectReceptionist(idRecepcionist) {
      var i = 0, l = vm.receptionists.length;
      vm.reception.recepcionista = {};
      for (i = 0; i < l; i += 1) {
        if (vm.receptionists[i].id_empleado == idRecepcionist)
        {
          vm.reception.recepcionista = vm.receptionists[i];
          break;
        }
      }
      return vm.reception.recepcionista;
    }

    function validateForm() {

    }

    function submitReceptionForm() {
      //send to verification service
    }
  }
  angular
    .module('sislabApp')
    .controller('ReceptionController',
      [
        '$routeParams', 'ReceptionistService', 'ReceptionService',
        ReceptionController
      ]
    );

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
