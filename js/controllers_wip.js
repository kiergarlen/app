
  // PlanController.js
  /**
   * @name PlanController
   * @constructor
   * @desc Controla la vista para capturar un Plan de muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} PlanObjectivesService - Proveedor de datos, Objetivos Plan de muestreo
   * @param {Object} PointsByPackageService - Proveedor de datos, Puntos de muestreo por paquete
   * @param {Object} DistrictService - Proveedor de datos, Municipios
   * @param {Object} CityService - Proveedor de datos, Localidades
   * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   * @param {Object} ReactiveService - Proveedor de datos, Reactivos
   * @param {Object} MaterialService - Proveedor de datos, Material
   * @param {Object} CoolerService - Proveedor de datos, Hieleras
   * @param {Object} SamplingInstrumentService - Proveedor de datos, Equipos de muestreo
   * @param {Object} PlanService - Proveedor de datos, Plan de muestreo
   */
  function PlanController($scope, $routeParams, TokenService, ArrayUtilsService,
    PlanObjectivesService, PointsByPackageService, DistrictService,
    CityService, SamplingSupervisorService, SamplingEmployeeService,
    PreservationService, ContainerService, ReactiveService,
    MaterialService, CoolerService, SamplingInstrumentService,
    PlanService) {
    var vm = this;
    vm.plan = PlanService.query({planId: $routeParams.planId});
    vm.user = TokenService.getUserFromToken();
    vm.objectives = PlanObjectivesService.get();
    vm.instruments = SamplingInstrumentService.get();
    vm.cities = [];
    vm.districts = [];
    vm.samplingSupervisors = SamplingSupervisorService.get();
    vm.samplingEmployees = SamplingEmployeeService.get();
    vm.preservations = PreservationService.get();
    vm.containers = ContainerService.get();
    vm.reactives = ReactiveService.get();
    vm.materials = MaterialService.get();
    vm.coolers = CoolerService.get();
    vm.isInstrumentsListLoaded = false;
    vm.isContainersListLoaded = false;
    vm.isReactivesListLoaded = false;
    vm.isMaterialsListLoaded = false;
    vm.isCoolersListLoaded = false;
    vm.isDataSubmitted = false;
    vm.selectDistrict = selectDistrict;
    vm.selectInstruments = selectInstruments;
    vm.selectContainers = selectContainers;
    vm.selectReactives = selectReactives;
    vm.selectMaterials = selectMaterials;
    vm.selectCoolers = selectCoolers;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;

    DistrictService.get()
      .$promise.then(function success(response) {
        vm.districts = response;
        if (vm.plan.id_municipio && vm.plan.id_municipio > 0)
        {
          ArrayUtilsService.selectItemFromCollection(
            vm.districts,
            'id_municipio',
            parseInt(vm.plan.id_municipio)
          );
        }
        CityService
          .query({districtId: vm.plan.id_municipio})
          .$promise
          .then(function success(response) {
            vm.cities = response;
            if (vm.plan.id_localidad && vm.plan.id_localidad > 0)
            {
              ArrayUtilsService.selectItemFromCollection(
                vm.cities,
                'id_localidad',
                parseInt(vm.plan.id_localidad)
              );
            }
          });
      });

    function selectDistrict() {
      vm.cities = CityService.query({districtId: parseInt(vm.plan.id_municipio)});
    }

    function selectInstruments() {
      var items = [];
      if (vm.instruments.length > 0 && vm.plan.equipos)
      {
        if (vm.plan.equipos.length > 0 && !vm.isInstrumentsListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.instruments,
            vm.plan.equipos,
            'id_equipo',
            [
              'selected'
            ]
          );
          vm.isInstrumentsListLoaded = true;
        }
        else
        {
          vm.plan.equipos = [];
          vm.plan.equipos = ArrayUtilsService.selectItemsFromCollection(
            vm.instruments,
            'selected',
            true
          ).slice();
        }
      }
    }

    function selectContainers() {
      var items = [];
      if (vm.containers.length > 0 && vm.plan.recipientes)
      {
        if (vm.plan.recipientes.length > 0 && !vm.isContainersListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.containers,
            vm.plan.recipientes,
            'id_clase_recipiente',
            [
              'selected',
              'id_plan',
              'cantidad'
            ]
          );
          vm.isContainersListLoaded = true;
        }
        else
        {
          vm.plan.recipientes = [];
          vm.plan.recipientes = ArrayUtilsService.selectItemsFromCollection(
            vm.containers,
            'selected',
            true
          ).slice();
        }
      }
    }

    function selectReactives() {
      var items = [];
      if (vm.reactives.length > 0 && vm.plan.reactivos)
      {
        if (vm.plan.reactivos.length > 0 && !vm.isReactivesListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.reactives,
            vm.plan.reactivos,
            'id_reactivo',
            [
              'selected',
              'id_plan',
              'lote',
              'cantidad'
            ]
          );
          vm.isReactivesListLoaded = true;
        }
        else
        {
          vm.plan.reactivos = [];
          vm.plan.reactivos = ArrayUtilsService.selectItemsFromCollection(
            vm.reactives,
            'selected',
            true
          ).slice();
        }
      }
    }

    function selectMaterials() {
      var items = [];
      if (vm.materials.length > 0 && vm.plan.materiales)
      {
        if (vm.plan.materiales.length > 0 && !vm.isMaterialsListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.materials,
            vm.plan.materiales,
            'id_material',
            [
              'selected',
              'id_plan'
            ]
          );
          vm.isMaterialsListLoaded = true;
        }
        else
        {
          vm.plan.materiales = [];
          vm.plan.materiales = ArrayUtilsService.selectItemsFromCollection(
            vm.materials,
            'selected',
            true
          ).slice();
        }
      }
    }

    function selectCoolers() {
      var items = [];
      if (vm.coolers.length > 0 && vm.plan.hieleras)
      {
        if (vm.plan.hieleras.length > 0 && !vm.isCoolersListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.coolers,
            vm.plan.hieleras,
            'id_hielera',
            [
              'selected',
              'id_plan'
            ]
          );
          vm.isCoolersListLoaded = true;
        }
        else
        {
          vm.plan.hieleras = [];
          vm.plan.hieleras = ArrayUtilsService.selectItemsFromCollection(
            vm.coolers,
            'selected',
            true
          ).slice();
        }
      }
    }

    function approveItem() {
      ValidationService.approveItem(vm.study, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.study, vm.user);
    }

    function isFormValid() {
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        //if (vm.plan.id_estudio > 0)
        //{
        //  RestUtilsService
        //    .saveData(
        //      PlanService,
        //      vm.plan,
        //      'muestreo/plan',
        //      'id_plan'
        //    );
        //}
        //else
        //{
        //  if (vm.user.level < 3 || vm.plan.plan.id_status < 2)
        //  {
        //    RestUtilsService
        //      .updateData(
        //        PlanService,
        //        vm.plan,
        //        'muestreo/plan',
        //        'id_plan'
        //      );
        //  }
        //}
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('PlanController',
      [
        '$scope',
        '$routeParams', 'TokenService', 'ArrayUtilsService',
        'PlanObjectivesService', 'PointsByPackageService', 'DistrictService',
        'CityService', 'SamplingSupervisorService', 'SamplingEmployeeService',
        'PreservationService', 'ContainerService', 'ReactiveService',
        'MaterialService', 'CoolerService', 'SamplingInstrumentService',
        'PlanService',
        PlanController
      ]
    );

  // FieldSheetController.js
  /**
   * @name FieldSheetController
   * @constructor
   * @desc Controla la vista para capturar la hoja de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} CloudService - Proveedor de datos, Coberturas nubes
   * @param {Object} WindService - Proveedor de datos, Direcciones viento
   * @param {Object} WaveService - Proveedor de datos, Intensidades oleaje
   * @param {Object} SamplingNormService - Proveedor de datos, Normas muestreo
   * @param {Object} PointService - Proveedor de datos, Puntos de muestreo
   * @param {Object} FieldParameterService - Proveedor de datos, Parámetros campo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} FieldSheetService - Proveedor de datos, Hojas de campo
   */
  function FieldSheetController($routeParams, TokenService, ArrayUtilsService,
    CloudService, WindService, WaveService,
    SamplingNormService, PointService, FieldParameterService,
    PreservationService, FieldSheetService) {
    var vm = this;
    vm.fieldSheet = FieldSheetService.query({sheetId: $routeParams.sheetId});
    vm.user = TokenService.getUserFromToken();
    vm.cloudCovers = CloudService.get();
    vm.windDirections = WindService.get();
    vm.waveIntensities = WaveService.get();
    vm.samplingNorms = SamplingNormService.get();
    vm.points = PointService.get();
    vm.fieldParameters = FieldParameterService.get();
    vm.preservations = PreservationService.get();

    vm.temp1 = 0;
    vm.temp2 = 0;
    vm.temp3 = 0;
    vm.temp = 0;
    vm.tempAmb1 = 0;
    vm.tempAmb2 = 0;
    vm.tempAmb3 = 0;
    vm.tempAmb = 0;
    vm.ph1 = 0;
    vm.ph2 = 0;
    vm.ph3 = 0;
    vm.ph = 0;
    vm.cond1 = 0;
    vm.cond2 = 0;
    vm.cond3 = 0;
    vm.cond = 0;
    vm.od1 = 0;
    vm.od2 = 0;
    vm.od3 = 0;
    vm.od = 0;
    vm.cr1 = 0;
    vm.cr2 = 0;
    vm.cr3 = 0;
    vm.cr = 0;

    vm.tempAvg = tempAvg;
    vm.tempAmbAvg = tempAmbAvg;
    vm.phAvg = phAvg;
    vm.condAvg = condAvg;
    vm.odAvg = odAvg;
    vm.crAvg = crAvg;

    vm.selectCloudCover = selectCloudCover;
    vm.selectWindDirection = selectWindDirection;
    vm.selectWaveIntensity = selectWaveIntensity;
    vm.selectSamplingNorm = selectSamplingNorm;
    vm.selectPoint = selectPoint;

    vm.validateFieldSheetForm = validateFieldSheetForm;
    vm.submitFieldSheetForm = submitFieldSheetForm;

    function tempAvg(){
      vm.temp = ArrayUtilsService.averageFromValues([
        vm.temp1,
        vm.temp2,
        vm.temp3
      ]);
      return vm.temp;
    }

    function tempAmbAvg(){
      vm.tempAmb = ArrayUtilsService.averageFromValues([
        vm.tempAmb1,
        vm.tempAmb2,
        vm.tempAmb3
      ]);
      return vm.tempAmb;
    }

    function phAvg() {
      vm.ph = ArrayUtilsService.averageFromValues([
        vm.ph1,
        vm.ph2,
        vm.ph3
      ]);
      return vm.ph;
    }

    function condAvg() {
      vm.cond = ArrayUtilsService.averageFromValues([
        vm.cond1,
        vm.cond2,
        vm.cond3
      ]);
      return vm.cond;
    }

    function odAvg() {
      vm.od = ArrayUtilsService.averageFromValues([
        vm.od1,
        vm.od2,
        vm.od3
      ]);
      return vm.od;
    }

    function crAvg() {
      vm.cr = ArrayUtilsService.averageFromValues([
        vm.cr1,
        vm.cr2,
        vm.cr3
      ]);
      return vm.cr;
    }

    function selectCloudCover(idCloud) {
      ArrayUtilsService.selectItemFromCollection(
        vm.cloudCovers,
        'id_cobertura_nubes',
        idCloud
      );
    }

    function selectWindDirection(idWind) {
      ArrayUtilsService.selectItemFromCollection(
        vm.windDirections,
        'id_direccion_viento',
        idWind
      );
    }

    function selectWaveIntensity(idWave) {
      ArrayUtilsService.selectItemFromCollection(
        vm.waveIntensities,
        'id_oleaje',
        idWave
      );
    }

    function selectSamplingNorm(idNorm) {
      ArrayUtilsService.selectItemFromCollection(
        vm.samplingNorms,
        'id_metodo_muestreo',
        idNorm
      );
    }

    function selectPoint(idPoint) {
      ArrayUtilsService.selectItemFromCollection(
        vm.points,
        'id_punto_muestreo',
        idPoint
      );
    }

    function validateFieldSheetForm() {

    }

    function submitFieldSheetForm() {

    }
  }
  angular
    .module('sislabApp')
    .controller('FieldSheetController',
      [
        '$routeParams', 'TokenService', 'ArrayUtilsService',
        'CloudService', 'WindService', 'WaveService',
        'SamplingNormService', 'PointService', 'FieldParameterService',
        'PreservationService', 'FieldSheetService',
        FieldSheetController
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
    vm.validateReceptionForm = validateReceptionForm;
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

    function validateReceptionForm() {

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
