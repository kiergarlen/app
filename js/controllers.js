

  // StudyController.js
  /**
   * @name StudyController
   * @constructor
   * @desc Controla la vista para capturar un Estudio
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} ClientService - Proveedor de datos, Clientes
   * @param {Object} MatrixService - Proveedor de datos, Tipos matriz
   * @param {Object} SamplingTypeService - Proveedor de datos, Tipos muestreo
   * @param {Object} NormService - Proveedor de datos, Normas
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes orden
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudyController($scope, $routeParams, TokenService,
    RestUtilsService, ArrayUtilsService, DateUtilsService,
    ClientService, MatrixService, SamplingTypeService,
    NormService, OrderSourceService, StudyService) {
    var vm = this;
    vm.study = StudyService.query({studyId: $routeParams.studyId});
    vm.user = TokenService.getUserFromToken();
    vm.clients = ClientService.query();
    vm.matrices = MatrixService.query();
    vm.samplingTypes = SamplingTypeService.query();
    vm.norms = NormService.query();
    vm.orderSources = OrderSourceService.query();
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.selectClient = selectClient;
    vm.getStudyScope = getStudyScope;
    vm.addQuote = addQuote;
    vm.removeQuote = removeQuote;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;

    function selectClient() {
      vm.study.cliente = ArrayUtilsService.selectItemFromCollection(
        vm.clients,
        'id_cliente',
        vm.study.id_cliente
      );
      return vm.study.cliente;
    }

    function getStudyScope() {
      return vm;
    }

    function addQuote() {
      vm.study.solicitudes.push({
        'id_solicitud':vm.study.solicitudes.length + 1,
        'id_estudio':vm.study.id_estudio,
        'id_matriz':0,
        'cantidad_muestras':0,
        'id_tipo_muestreo':1,
        'id_norma':0
      });
    }

    function removeQuote(e) {
      var field = '$$hashKey',
      quoteRow = ArrayUtilsService.extractItemFromCollection(
        vm.study.solicitudes,
        field,
        e[field]
      );
    }

    function approveItem(item, user) {
      item.id_status = 2;
      item.status = 'Validado';
      item.id_usuario_valida = user.id;
      item.motivo_rechaza = '';
      item.fecha_valida = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function rejectItem(item, user) {
      item.id_status = 3;
      item.status = 'Rechazado';
      item.id_usuario_valida = user.id;
      item.fecha_rechaza = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function isQuoteListValid() {
      var i = 0,
      l = 0,
      quotes = [];
      if (vm.study.solicitudes && vm.study.solicitudes.length > 0)
      {
        quotes = vm.study.solicitudes;
        l = quotes.length;
        for (i = 0; i < l; i += 1) {
          if (quotes[i].id_matriz < 1)
          {
            vm.message += ' Seleccione una matriz, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (quotes[i].cantidad_muestras < 1)
          {
            vm.message += ' Ingrese cantidad de muestras, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (quotes[i].id_tipo_muestreo < 1)
          {
            vm.message += ' Seleccione un tipo de muestreo, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (quotes[i].id_norma < 1)
          {
            vm.message += ' Seleccione una norma, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      }
      else
      {
        vm.message += ' No tiene relacionada ninguna solicitud';
        return false;
      }
      return true;
    }

    function isFormValid() {
      var validQuotes = false;
      vm.message = '';
      if (!DateUtilsService.isValidDate(new Date(vm.study.fecha)))
      {
        vm.message += ' Ingrese una fecha válida ';
        return false;
      }
      if (vm.study.id_cliente < 1)
      {
        vm.message += ' Seleccione un cliente ';
        return false;
      }
      validQuotes = isQuoteListValid();
      if (!validQuotes)
      {
        return false;
      }
      if (vm.study.id_origen_orden < 1)
      {
        vm.message += ' Seleccione un medio de solicitud de muestreo ';
        return false;
      }
      if (vm.study.ubicacion.length < 1)
      {
        vm.message += ' Ingrese una ubicación ';
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.study.id_status == 3 && vm.study.motivo_rechaza.length < 1)
        {
          vm.message += ' Debe escribir un motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.study.id_estudio > 0)
        {
          RestUtilsService
            .saveData(
              StudyService,
              vm.study,
              'estudio/estudios',
              'id_estudio'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.study.study.id_status < 2)
          {
            RestUtilsService
              .updateData(
                StudyService,
                vm.study,
                'estudio/estudios',
                'id_estudio'
              );
          }
        }
      }
    }
  }

  angular
    .module('sislabApp')
    .controller('StudyController',
      [
        '$scope', '$routeParams', 'TokenService',
        'RestUtilsService', 'ArrayUtilsService', 'DateUtilsService',
        'ClientService', 'MatrixService', 'SamplingTypeService',
        'NormService', 'OrderSourceService', 'StudyService',
        StudyController
      ]
    );


  // QuoteController.js
  /**
   * @name QuoteController
   * @constructor
   * @desc Controla la vista para capturar una Solicitud/Cotización
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} QuoteService - Proveedor de datos, Solicitud
   */
  function QuoteController($scope, $routeParams, TokenService,
    RestUtilsService, ArrayUtilsService, DateUtilsService,
    ParameterService, QuoteService) {
    var vm = this;
    vm.quote = QuoteService.query({quoteId: $routeParams.quoteId});
    vm.user = TokenService.getUserFromToken();
    vm.parameters = ParameterService.query();
    vm.allParametersSelected = false;
    vm.totalCost = 0;
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.totalParameter = totalParameter;
    vm.selectNormParameters = selectNormParameters;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;

    function totalParameter(){
      var i = 0, l = 0, t = 0;
      if (vm.parameters && vm.quote.cliente)
      {
        l = vm.parameters.length;
        for (i = 0; i < l; i += 1) {
          if (vm.parameters[i].selected)
          {
            t = t + parseInt(vm.parameters[i].precio, 10);
          }
        }
        t = t * vm.quote.cliente.tasa * vm.quote.cantidad_muestras;
        vm.totalCost = (Math.round(t * 100) / 100);
        vm.quote.total = vm.totalCost;
      }
      return vm.totalCost;
    }

    function selectNormParameters() {
      var i, l, j, m;
      l = vm.parameters.length;
      if (l > 0 && vm.quote.parametros)
      {
        for(i = 0; i < l; i += 1) {
          vm.parameters[i].selected = false;
          m = vm.quote.parametros.length;
          for (j = 0; j < m; j += 1) {
            if (vm.parameters[i].id_parametro == vm.quote.norma.parametros[j].id_parametro)
            {
              vm.parameters[i].selected = true;
              break;
            }
          }
        }
      }
    }

    function selectAllParameters() {
      var i, l, j, m;
      l = vm.parameters.length;
      vm.quote.allParametersSelected = !vm.quote.allParametersSelected;
      for(i = 0; i < l; i += 1) {
        vm.parameters[i].selected = vm.quote.allParametersSelected;
      }
    }

    function approveItem(item, user) {
      item.id_status = 2;
      item.status = 'Validado';
      item.id_usuario_valida = user.id;
      item.motivo_rechaza = '';
      item.fecha_valida = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function rejectItem(item, user) {
      item.id_status = 3;
      item.status = 'Rechazado';
      item.id_usuario_valida = user.id;
      item.fecha_rechaza = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function isFormValid() {
      vm.message = '';
      if (vm.quote.cuerpo_receptor.length > 0 && vm.quote.tipo_cuerpo.length < 1)
      {
        vm.message += ' Si selecciona un cuerpo receptor, debe especificar tipo de cuerpo';
        return false;
      }
      if (vm.quote.cuerpo_receptor.length < 1 && vm.quote.tipo_cuerpo.length > 0)
      {
        vm.message += ' Si selecciona un tipo de cuerpo, debe estar asociado a un cuerpo receptor';
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.quote.id_status == 3 && vm.quote.motivo_rechaza.length < 1)
        {
          vm.message += ' Debe escribir un motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.study.id_estudio > 0)
        {
          RestUtilsService
            .saveData(
              QuoteService,
              vm.quote,
              'muestreo/solicitudes',
              'id_solicitud'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.study.study.id_status < 2)
          {
            RestUtilsService
              .updateData(
                QuoteService,
                vm.quote,
                'muestreo/solicitudes',
                'id_solicitud'
              );
          }
        }
      }
    }
  }

  angular
    .module('sislabApp')
    .controller('QuoteController',
      [
        '$scope', '$routeParams', 'TokenService',
        'RestUtilsService', 'ArrayUtilsService', 'DateUtilsService',
        'ParameterService', 'QuoteService',
        QuoteController
      ]
    );


  // OrderController.js
  /**
   * @name OrderController
   * @constructor
   * @desc Controla la vista para capturar una Orden de muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes orden
   * @param {Object} MatrixService - Proveedor de datos, Tipos matriz
   * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
   * @param {Object} OrderService - Proveedor de datos, Órdenes de muestreo
   */
  function OrderController($scope, $routeParams, TokenService, OrderSourceService,
    MatrixService, SamplingSupervisorService, OrderService) {
    var vm = this;
    vm.order = OrderService.query({orderId: $routeParams.orderId});
    vm.user = TokenService.getUserFromToken();
    vm.orderSources = OrderSourceService.query();
    vm.matrices = MatrixService.query();
    vm.supervisors = SamplingSupervisorService.query();
    vm.parametersDetailVisible = false;

    vm.message = '';
    vm.isDataSubmitted = false;
    vm.toggleParametersDetail = toggleParametersDetail;

    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;

    function toggleParametersDetail() {
      vm.parametersDetailVisible = !vm.parametersDetailVisible;
    }

    function approveItem(item, user) {
      item.id_status = 2;
      item.status = 'Validado';
      item.id_usuario_valida = user.id;
      item.motivo_rechaza = '';
      item.fecha_valida = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function rejectItem(item, user) {
      item.id_status = 3;
      item.status = 'Rechazado';
      item.id_usuario_valida = user.id;
      item.fecha_rechaza = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function isFormValid() {
      //TODO validation
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.study.id_orden > 0)
        {
          RestUtilsService
            .saveData(
              OrderService,
              vm.order,
              'muestreo/ordenes',
              'id_orden'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.order.order.id_status < 2)
          {
            RestUtilsService
              .updateData(
                OrderService,
                vm.order,
                'muestreo/ordenes',
                'id_orden'
              );
          }
        }
      }
    }
  }

  angular
    .module('sislabApp')
    .controller('OrderController',
      [
        '$scope', '$routeParams', 'TokenService', 'OrderSourceService',
        'MatrixService', 'SamplingSupervisorService', 'OrderService',
        OrderController
      ]
    );


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
   * @param {Object} PointKindsService - Proveedor de datos, tipos Punto
   * @param {Object} DistrictService - Proveedor de datos, Municipios
   * @param {Object} CityService - Proveedor de datos, Localidades
   * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} ContainerKindsService - Proveedor de datos, Clases recipientes
   * @param {Object} ReactivesListService - Proveedor de datos, lista Reactivos
   * @param {Object} MaterialService - Proveedor de datos, Material
   * @param {Object} CoolerService - Proveedor de datos, lista Hieleras
   * @param {Object} PlanService - Proveedor de datos, Plan de muestreo
   */
  function PlanController($routeParams, TokenService, ArrayUtilsService,
    PlanObjectivesService, PointKindsService, DistrictService,
    CityService, SamplingSupervisorService, SamplingEmployeeService,
    PreservationService, ContainerKindsService, ReactivesListService,
    MaterialService, CoolerService, PlanService) {
    var vm = this;
    vm.plan = PlanService.query({planId: $routeParams.planId});
    vm.user = TokenService.getUserFromToken();
    vm.objectives = PlanObjectivesService.query();
    vm.pointKinds = PointKindsService.query();
    vm.districts = DistrictService.query();
    vm.cities = [];
    vm.samplingSupervisors = SamplingSupervisorService.query();
    vm.samplingEmployees = SamplingEmployeeService.query();
    vm.preservations = PreservationService.query();
    vm.reactives = ReactivesListService.query();
    vm.containers = ContainerKindsService.query();
    vm.materials = MaterialService.query();
    vm.coolers = CoolerService.query();

    vm.countSelectedItems = countSelectedItems;
    vm.selectDistrict = selectDistrict;
    vm.addPoints = addPoints;

    function countSelectedItems(collection) {
      return ArrayUtilsService.countSelectedItems(collection);
    }

    function selectDistrict() {
      vm.plan.id_municipio = parseInt(vm.plan.id_municipio);
      vm.cities = CityService.query({districtId: vm.plan.id_municipio});
    }

    function addPoints() {

    }
  }

  angular
    .module('sislabApp')
    .controller('PlanController',
      [
        '$routeParams', 'TokenService', 'ArrayUtilsService',
        'PlanObjectivesService', 'PointKindsService', 'DistrictService',
        'CityService', 'SamplingSupervisorService', 'SamplingEmployeeService',
        'PreservationService', 'ContainerKindsService', 'ReactivesListService',
        'MaterialService', 'CoolerService', 'PlanService',
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
   * @param {Object} PointService - Proveedor de datos, Puntos muestreo
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
    vm.cloudCovers = CloudService.query();
    vm.windDirections = WindService.query();
    vm.waveIntensities = WaveService.query();
    vm.samplingNorms = SamplingNormService.query();
    vm.points = PointService.query();
    vm.fieldParameters = FieldParameterService.query();
    vm.preservations = PreservationService.query();

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
    vm.receptionists = ReceptionistService.query();
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
   * @param {Object} ContainerKindsService - Proveedor de datos, Clases recipientes
   * @param {Object} CheckerService - Proveedor de datos, Responsables verificación
   * @param {Object} CustodyService - Proveedor de datos, Cadenas custodia
   */
  function CustodyController($routeParams, TokenService, ArrayUtilsService,
    PreservationService, ExpirationService, RequiredVolumeService,
    ContainerKindsService, CheckerService, CustodyService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.preservations = PreservationService.query();
    vm.expirations = ExpirationService.query();
    vm.volumes = RequiredVolumeService.query();
    vm.containers = ContainerKindsService.query();
    vm.checkers = CheckerService.query();
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
        'ContainerKindsService', 'CheckerService', 'CustodyService',
        CustodyController
      ]
    );
