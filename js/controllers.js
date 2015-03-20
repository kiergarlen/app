  // CONTROLLERS
  // MenuController.js
  /**
   * @name MenuController
   * @constructor
   * @desc Controla la vista para el Menú principal
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} MenuService - Proveedor de datos, Menú
   */
  function MenuController($scope, MenuService) {
    $scope.menu = MenuService.query();
  }

  angular
    .module('sislabApp')
    .controller('MenuController',
      [
        '$scope',
        'MenuService',
        MenuController
      ]
    );

  // LoginController.js
  /**
   * @name LoginController
   * @constructor
   * @desc Controla la vista para Login
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   */
  function LoginController($scope, $http, $location,
    TokenService) {
    var vm = this;
    vm.message = '';
    vm.user = {username: '', password: ''};
    vm.submit = submit;
    vm.login = login;

    function submit(username, password) {
      $http({
        url: API_BASE_URL + 'login',
        method: 'POST',
        data: {
          username: username,
          password: password
        }
      }).then(function success(response) {
        var token = response.data || null;
        TokenService.setToken(token);
        $location.path('main');
      }, function error(response) {
        if (response.status === 404)
        {
          vm.message = 'Sin enlace al servidor';
        }
        else
        {
          vm.message = 'Error no especificado';
        }
      });
      return '';
    }

    function login() {
      vm.message = '';
      if (!$scope.loginForm.$valid)
      {
        vm.message = 'Debe ingresar usuario y/o contraseña';
        return;
      }
      vm.submit(
        vm.user.username,
        vm.user.password
      );
    }
  }

  angular
    .module('sislabApp')
    .controller('LoginController',
      [
        '$scope', '$http', '$location',
        'TokenService',
        LoginController
      ]
    );

  // TasksListController.js
  /**
   * @name TasksListController
   * @constructor
   * @desc Controla la vista para Tareas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} TasksListService - Proveedor de datos, Tareas
   */
  function TasksListController(TokenService, TasksListService) {
    var vm = this,
    userData;
    vm.userName = "";
    vm.tasks = {};

    if (TokenService.isAuthenticated())
    {
      userData = TokenService.getUserFromToken();
      vm.userName = userData.name;
      vm.tasks = TasksListService.query(userData.id);
    }
  }

  angular
    .module('sislabApp')
    .controller('TasksListController',
      [
        'TokenService', 'TasksListService',
        TasksListController
      ]
    );

  // QuotesListController.js
  /**
   * @name QuotesListController
   * @constructor
   * @desc Controla la vista para el listado de Solicitudes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} QuotesListService - Proveedor de datos, solicitudes
   */
  function QuotesListController($location, QuotesListService) {
    var vm = this;
    vm.quotes = QuotesListService.query();
    vm.addQuote = addQuote;
    vm.viewQuote = viewQuote;

    function addQuote() {
      $location.path('/muestreo/solicitud/0');
    }

    function viewQuote(id) {
      var itemId = parseInt(id);
      //var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/muestreo/solicitud/' + itemId);
    }
  }

  angular
    .module('sislabApp')
    .controller('QuotesListController',
      [
        '$location', 'QuotesListService',
        QuotesListController
      ]
    );

  // QuoteController.js
  /**
   * @name QuoteController
   * @constructor
   * @desc Controla la vista para capturar una Solicitud/Cotización
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ClientService - Proveedor de datos, Clientes
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} NormService - Proveedor de datos, Normas
   * @param {Object} SamplingTypeService - Proveedor de datos, Tipos muestreo
   * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
   */
  function QuoteController($routeParams, TokenService, ClientService,
    ParameterService, NormService, SamplingTypeService, QuoteService) {
    var vm = this;
    vm.clients = ClientService.query();
    vm.parameters = ParameterService.query();
    vm.norms = NormService.query();
    vm.samplingTypes = SamplingTypeService.query();
    vm.quote = QuoteService.query({quoteId: $routeParams.quoteId});
    vm.clientDetailVisible = false;
    vm.parametersDetailVisible = false;
    vm.allParametersSelected = false;
    vm.totalCost = 0;

    vm.user = TokenService.getUserFromToken();
    vm.toggleClientDetail = toggleClientDetail;
    vm.toggleParametersDetail = toggleParametersDetail;
    vm.selectClient = selectClient;
    vm.totalParameter = totalParameter;
    vm.selectNorm = selectNorm;
    vm.selectNormParameters = selectNormParameters;
    vm.selectAllParameters = selectAllParameters;
    vm.selectSamplingType = selectSamplingType;
    vm.submitQuoteForm = submitQuoteForm;

    function selectItemFromCollection(id, collection, field) {
      var i = 0,
      l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == id)
        {
          item = collection[i];
          break;
        }
      }
      return item;
    }

    function toggleClientDetail() {
      var id = vm.quote.id_cliente;
      vm.clientDetailVisible = (
        vm.quote.id_cliente > 0 &&
        vm.selectClient(id).cliente &&
        !vm.clientDetailVisible
      );
    }

    function toggleParametersDetail() {
      vm.parametersDetailVisible = !vm.parametersDetailVisible;
    }

    function selectClient() {
      vm.quote.cliente = selectItemFromCollection(
        vm.quote.id_cliente,
        vm.clients,
        'id_cliente'
      );
      return vm.quote.cliente;
    }

    function totalParameter(){
      var i = 0, l = 0, t = 0;
      if (vm.parameters)
      {
        l = vm.parameters.length;
        for (i = 0; i < l; i += 1) {
          if (vm.parameters[i].selected)
          {
            t = t + parseInt(vm.parameters[i].precio, 10);
          }
        }
        t = t * vm.quote.cliente.tasa;
        vm.totalCost = (Math.round(t * 100) / 100);
        vm.quote.total = vm.totalCost;
      }
      return vm.totalCost;
    }

    function selectNorm(idNorm) {
      var i, l;
      l = vm.norms.length;
      vm.quote.norma = {};
      vm.quote.parametros_seleccionados = [];
      vm.quote.allParametersSelected = false;
      for (i = 0; i < l; i += 1) {
        if (vm.norms[i].id_norma == idNorm)
        {
          vm.quote.norma = vm.norms[i];
          break;
        }
      }
      vm.selectNormParameters();
      return '';
    }

    function selectNormParameters() {
      var i, l, j, m;
      l = vm.parameters.length;
      for(i = 0; i < l; i += 1) {
        vm.parameters[i].selected = false;
        if (vm.quote.norma.parametros !== undefined)
        {
          m = vm.quote.norma.parametros.length;
          for (j = 0; j < m; j += 1) {
            if (vm.parameters[i].id_parametro ==
              vm.quote.norma.parametros[j].id_parametro)
            {
              vm.parameters[i].selected = true;
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

    function selectSamplingType() {
      var i, l;
      l = vm.samplingTypes.length;
      for (i = 0; i < l; i += 1) {
        vn.samplingTypes[i].selected =
        (vm.samplingTypes[i].id_tipo_muestreo ==
          vm.quote.id_tipo_muestreo);
      }
    }

    function submitQuoteForm() {

    }
  }

  angular
    .module('sislabApp')
    .controller('QuoteController',
      [
        '$routeParams', 'TokenService', 'ClientService', 'ParameterService',
        'NormService', 'SamplingTypeService', 'QuoteService',
        QuoteController
      ]
    );

  // OrdersListController.js
  /**
   * @name OrdersListController
   * @constructor
   * @desc Controla la vista para el listado de Órdenes de muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} OrdersListService - Proveedor de datos, órdenes
   */
  function OrdersListController($location, OrdersListService) {
    var vm = this;
    vm.orders = OrdersListService.query();
    vm.addOrder = addOrder;
    vm.selectRow = selectRow;

    function addOrder() {
      $location.path('/muestreo/orden/0');
    }

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/muestreo/orden/' + itemId);
    }
  }

  angular
    .module('sislabApp')
    .controller('OrdersListController',
      [
        '$location', 'OrdersListService',
        OrdersListController
      ]
    );

  // OrderController.js
  /**
   * @name OrderController
   * @constructor
   * @desc Controla la vista para capturar una Orden de muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes orden
   * @param {Object} MatrixService - Proveedor de datos, Tipos matriz
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
   * @param {Object} OrderService - Proveedor de datos, Orden muestreo
   */
  function OrderController($routeParams, OrderSourceService,
    MatrixService, SamplingSupervisorService,
    OrderService) {
    var vm = this;
    vm.order = OrderService.query({orderId: $routeParams.orderId});
    vm.orderSources = OrderSourceService.query();
    vm.matrices = MatrixService.query();
    vm.supervisors = SamplingSupervisorService.query();
    vm.parametersDetailVisible = false;

    vm.toggleParametersDetail = toggleParametersDetail;
    vm.validateOrderForm = validateOrderForm;
    vm.submitOrderForm = submitOrderForm;

    function toggleParametersDetail() {
      vm.parametersDetailVisible = !vm.parametersDetailVisible;
    }

    function validateOrderForm(form) {
      //TODO validation
      return form;
    }

    function submitOrderForm() {

    }
  }

  angular
    .module('sislabApp')
    .controller('OrderController',
      [
        '$routeParams', 'OrderSourceService',
        'MatrixService', 'SamplingSupervisorService',
        'OrderService',
        OrderController
      ]
    );

  // PlansListController.js
  /**
   * @name PlansListController
   * @constructor
   * @desc Controla la vista para el listado de Planes de muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} PlansListService - Proveedor de datos, planes
   */
  function PlansListController($location, PlansListService) {
    var vm = this;
    vm.plans = PlansListService.query();
    vm.addPlan = addPlan;
    vm.selectRow = selectRow;

    function addPlan() {
      $location.path('/muestreo/plan/0');
    }

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/muestreo/plan/' + itemId);
    }
  }

  angular
    .module('sislabApp')
    .controller('PlansListController',
      [
        '$location', 'PlansListService',
        PlansListController
      ]
    );

  // PlanController.js
  /**
   * @name PlanController
   * @constructor
   * @desc Controla la vista para capturar un Plan muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PlanObjectivesService - Proveedor de datos, Objetivos Plan muestreo
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
   * @param {Object} PlanService - Proveedor de datos, Plan muestreo
   */
  function PlanController($routeParams, PlanObjectivesService, PointKindsService,
    DistrictService, CityService, SamplingSupervisorService,
    SamplingEmployeeService, PreservationService, ContainerKindsService,
    ReactivesListService, MaterialService, CoolerService,
    PlanService) {
    var vm = this;
    vm.plan = PlanService.query({planId: $routeParams.planId});
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
    vm.addPoints = addPoints;

    vm.selectDistrict = selectDistrict;

    vm.countSelectedItems = countSelectedItems;

    function selectItemFromCollection(id, collection, field) {
      var i = 0,
      l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
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
      vm.plan.id_municipio = parseInt(vm.plan.id_municipio);
      vm.cities = CityService.query({districtId: vm.plan.id_municipio});
    }
  }

  angular
    .module('sislabApp')
    .controller('PlanController',
      [
        '$routeParams', 'PlanObjectivesService', 'PointKindsService',
        'DistrictService', 'CityService', 'SamplingSupervisorService',
        'SamplingEmployeeService', 'PreservationService', 'ContainerKindsService',
        'ReactivesListService', 'MaterialService', 'CoolerService',
        'PlanService',
        PlanController
      ]
    );

  // FieldSheetsListController.js
  /**
   * @name FieldSheetsListController
   * @constructor
   * @desc Controla la vista para el listado de Hojas de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} FieldSheetsListService - Proveedor de datos, Hojas de campo
   */
  function FieldSheetsListController($location, FieldSheetsListService) {
    var vm = this;
    vm.fieldSheets = FieldSheetsListService.query();
    vm.addFieldSheet = addFieldSheet;
    vm.selectRow = selectRow;

    function addFieldSheet() {
      $location.path('/recepcion/hoja/0');
    }

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/recepcion/hoja/' + itemId);
    }
  }

  angular
    .module('sislabApp')
    .controller('FieldSheetsListController',
      [
        '$location', 'FieldSheetsListService',
        FieldSheetsListController
      ]
    );


  // FieldSheetController.js
  /**
   * @name FieldSheetController
   * @constructor
   * @desc Controla la vista para capturar la hoja de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} CloudService - Proveedor de datos, Coberturas nubes
   * @param {Object} WindService - Proveedor de datos, Direcciones viento
   * @param {Object} WaveService - Proveedor de datos, Intensidades oleaje
   * @param {Object} SamplingNormService - Proveedor de datos, Normas muestreo
   * @param {Object} PointService - Proveedor de datos, Puntos muestreo
   * @param {Object} FieldParameterService - Proveedor de datos, Parámetros campo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} FieldSheetService - Proveedor de datos, Hojas de campo
   */
  function FieldSheetController($routeParams, CloudService, WindService,
    WaveService, SamplingNormService, PointService,
    FieldParameterService, PreservationService, FieldSheetService) {
    var vm = this;
    vm.fieldSheet = FieldSheetService.query({sheetId: $routeParams.sheetId});
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

    function selectItemFromCollection(id, collection, field) {
      var i = 0,
      l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == id)
        {
          item = collection[i];
          break;
        }
      }
      return item;
    }

    function averageFromArray(arr) {
      var i = 0,
      l = arr.length,
      sum = 0;
      if (l < 1)
      {
        return 0;
      }
      for (i; i < l; i++) {
        sum += parseFloat(arr[i]);
      }
      return Math.round((sum / l) * 1000 * 1000) / (1000 * 1000);
    }

    function tempAvg(){
      vm.temp = averageFromArray([
        vm.temp1,
        vm.temp2,
        vm.temp3
      ]);
      return vm.temp;
    }

    function tempAmbAvg(){
      vm.tempAmb = averageFromArray([
        vm.tempAmb1,
        vm.tempAmb2,
        vm.tempAmb3
      ]);
      return vm.tempAmb;
    }

    function phAvg() {
      vm.ph = averageFromArray([
        vm.ph1,
        vm.ph2,
        vm.ph3
      ]);
      return vm.ph;
    }

    function condAvg() {
      vm.cond = averageFromArray([
        vm.cond1,
        vm.cond2,
        vm.cond3
      ]);
      return vm.cond;
    }

    function odAvg() {
      vm.od = averageFromArray([
        vm.od1,
        vm.od2,
        vm.od3
      ]);
      return vm.od;
    }

    function crAvg() {
      vm.cr = averageFromArray([
        vm.cr1,
        vm.cr2,
        vm.cr3
      ]);
      return vm.cr;
    }

    function selectCloudCover(idCloud) {
      selectItemFromCollection(
        idCloud,'id_cobertura_nubes', vm.cloudCovers
      );
    }

    function selectWindDirection(idWind) {
      selectItemFromCollection(
        idWind,'id_direccion_viento', vm.windDirections
      );
    }

    function selectWaveIntensity(idWave) {
      selectItemFromCollection(
        idWave,'id_oleaje', vm.waveIntensities
      );
    }

    function selectSamplingNorm(idNorm) {
      selectItemFromCollection(
        idNorm,'id_metodo_muestreo', vm.samplingNorms
      );
    }

    function selectPoint(idPoint) {
      selectItemFromCollection(
        idPoint,'id_punto_muestreo', vm.points
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
        '$routeParams', 'CloudService', 'WindService',
        'WaveService', 'SamplingNormService', 'PointService',
        'FieldParameterService', 'PreservationService', 'FieldSheetService',
        FieldSheetController
      ]
    );

  // ReceptionsListController.js
  /**
   * @name ReceptionsListController
   * @constructor
   * @desc Controla la vista para el listado de Recepciones
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} ReceptionsListService - Proveedor de datos, Recepciones
   */
  function ReceptionsListController($location, ReceptionsListService) {
    var vm = this;
    vm.receptions = ReceptionsListService.query();
    vm.addReception = addReception;
    vm.selectRow = selectRow;

    function addReception() {
      $location.path('/recepcion/recepcion/0');
    }

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/recepcion/recepcion/' + itemId);
    }
  }

  angular
    .module('sislabApp')
    .controller('ReceptionsListController',
      [
        '$location', 'ReceptionsListService',
        ReceptionsListController
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
  function ReceptionController($routeParams, ReceptionistService, ReceptionService) {
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

  /**
   * @name CustodiesListController
   * @constructor
   * @desc Controla la vista para el listado de Cadenas de custodia
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} CustodiesListService - Proveedor de datos, Cadenas de custodia
   */
  function CustodiesListController($location, CustodiesListService) {
    var vm = this;
    vm.custodies = CustodiesListService.query();
    vm.addCustody = addCustody;
    vm.selectRow = selectRow;

    function addCustody() {
      $location.path('/recepcion/custodia/0');
    }

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/recepcion/custodia/' + itemId);
    }
  }

  angular
    .module('sislabApp')
    .controller('CustodiesListController',
      [
        '$location', 'CustodiesListService',
        CustodiesListController
      ]
    );

  // CustodyController.js
  /**
   * @name CustodyController
   * @constructor
   * @desc Controla la vista para capturar las Hojas de custodia
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} ExpirationService - Proveedor de datos, Vigencias
   * @param {Object} RequiredVolumeService - Proveedor de datos, Volúmenes requeridos
   * @param {Object} ContainerKindsService - Proveedor de datos, Clases recipientes
   * @param {Object} CheckerService - Proveedor de datos, Responsables verificación
   * @param {Object} CustodyService - Proveedor de datos, Cadenas custodia
   */
  function CustodyController($routeParams, PreservationService, ExpirationService,
    RequiredVolumeService, ContainerKindsService, CheckerService,
    CustodyService) {
    var vm = this;
    vm.preservations = PreservationService.query();
    vm.expirations = ExpirationService.query();
    vm.volumes = RequiredVolumeService.query();
    vm.containers = ContainerKindsService.query();
    vm.checkers = CheckerService.query();
    vm.custody = CustodyService.query({custodyId: $routeParams.custodyId});

    vm.selectChecker = selectChecker;

    vm.validateCustodyForm = validateCustodyForm;
    vm.submitCustodyForm = submitCustodyForm;

    function selectItemFromCollection(id, collection, field) {
      var i = 0, l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
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
    .module('sislabApp')
    .controller('CustodyController',
      [
        '$routeParams', 'PreservationService', 'ExpirationService',
        'RequiredVolumeService', 'ContainerKindsService', 'CheckerService',
        'CustodyService',
        CustodyController
      ]
    );

  // SamplesListController.js
  /**
   * @name SamplesListController
   * @constructor
   * @desc Controla la vista para consulta de Muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} SamplesListService - Proveedor de datos, lista Muestras
   */
  function SamplesListController(SamplesListService) {
    var vm = this;
    vm.pricesList = SamplesListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('SamplesListController',
      [
        'SamplesListService',
        SamplesListController
      ]
    );

  // InstrumentsListController.js
  /**
   * @name InstrumentsListController
   * @constructor
   * @desc Controla la vista para consulta de Equipos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} InstrumentsListService - Proveedor de datos, lista Equipos
   */
  function InstrumentsListController(InstrumentsListService) {
    var vm = this;
    vm.clients = InstrumentsListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('InstrumentsListController',
      [
        'InstrumentsListService',
        InstrumentsListController
      ]
    );

  // ReactivesListController.js
  /**
   * @name ReactivesListController
   * @constructor
   * @desc Controla la vista para consulta de Reactivos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReactivesListService - Proveedor de datos, lista Reactivos
   */
  function ReactivesListController(ReactivesListService) {
    var vm = this;
    vm.pricesList = ReactivesListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('ReactivesListController',
      [
        'ReactivesListService',
        ReactivesListController
      ]
    );

  // ContainersListController.js
  /**
   * @name ContainersListController
   * @constructor
   * @desc Controla la vista para consulta de Recipientes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ContainersListService - Proveedor de datos, lista Recipientes
   */
  function ContainersListController(ContainersListService) {
    var vm = this;
    vm.pricesList = ContainersListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('ContainersListController',
      [
        'ContainersListService',
        ContainersListController
      ]
    );

  // AnalysisListController.js
  /**
   * @name AnalysisListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Análisis
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} AnalysisListService - Proveedor de datos, Análisis
   */
  function AnalysisListController(AnalysisListService) {
    var vm = this;
    vm.analysisList = AnalysisListService.query();

    vm.selectRow = selectRow;
    function selectRow() {
      //TODO send to details view
      console.log('clicked in row');
    }
  }

  angular
    .module('sislabApp')
    .controller('AnalysisListController',
      [
        'AnalysisListService',
        AnalysisListController
      ]
    );

  // AnalysisController.js
  /**
   * @name AnalysisController
   * @constructor
   * @desc Controla la vista para seleccionar captura de Análisis
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} DepartmentService - Proveedor de datos, Áreas
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} AnalysisService - Proveedor de datos, selección de captura de Análisis
   */
  function AnalysisController(DepartmentService, ParameterService, AnalysisService) {
    var vm = this;
    vm.areas = DepartmentService.query();
    vm.parameters = ParameterService.query();
    vm.analysis = AnalysisService.query();

    vm.selectArea = selectArea;
    vm.selectParameter = selectParameter;

    vm.validateAnalysisForm = validateAnalysisForm;
    vm.submitAnalysisForm = submitAnalysisForm;

    function selectArea() {

    }

    function selectParameter() {

    }

    function validateAnalysisForm() {

    }

    function submitAnalysisForm() {

    }
  }

  angular
    .module('sislabApp')
    .controller('AnalysisController',
      [
        'DepartmentService', 'ParameterService',
        'AnalysisService',
        AnalysisController
      ]
    );

  // ReportsListController.js
  /**
   * @name ReportsListController
   * @constructor
   * @desc Controla la vista para consulta de Reportes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReportsListService - Proveedor de datos, lista Reportes
   */
  function ReportsListController(ReportsListService) {
    var vm = this;
    vm.pricesList = ReportsListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('ReportsListController',
      [
        'ReportsListService',
        ReportsListController
      ]
    );

  // ReportController.js
  /**
   * @name ReportController
   * @constructor
   * @desc Controla la vista para Reporte
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} ReportService - Proveedor de datos, Reporte
   */
  function ReportController($routeParams, ReportService) {
    var vm = this;
    vm.report = ReportService.query();

    vm.validateReportForm = validateReportForm;
    vm.submitReportForm = submitReportForm;

    function validateReportForm() {

    }

    function submitReportForm() {

    }
  }

  angular
    .module('sislabApp')
    .controller('ReportController',
      [
        'ReportService',
        ReportController
      ]
    );

  // PointsListController.js
  /**
   * @name PointsListController
   * @constructor
   * @desc Controla la vista para consulta de Puntos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PointsListService - Proveedor de datos, lista Puntos
   */
  function PointsListController(PointsListService) {
    var vm = this;
    vm.points = PointsListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('PointsListController',
      [
        'PointsListService',
        PointsListController
      ]
    );

  // ClientsListController.js
  /**
   * @name ClientsListController
   * @constructor
   * @desc Controla la vista para el listado de Clientes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ClientService - Proveedor de datos, Cliente
   */
  function ClientsListController(ClientService) {
    var vm = this;
    vm.clients = ClientService.query();
    vm.selectRow = selectRow;

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      console.log(itemId);
    }
  }

  angular
    .module('sislabApp')
    .controller('ClientsListController',
      [
        'ClientService',
        ClientsListController
      ]
    );

  // DepartmentsListController.js
  /**
   * @name DepartmentsListController
   * @constructor
   * @desc Controla la vista para el listado de Áreas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} DepartmentService - Proveedor de datos, Áreas
   */
  function DepartmentsListController(DepartmentService) {
    var vm = this;
    vm.departments = DepartmentService.query();
  }

  angular
    .module('sislabApp')
    .controller('DepartmentsListController',
      [
        'DepartmentService',
        DepartmentsListController
      ]
    );

  // EmployeesListController.js
  /**
   * @name EmployeesListController
   * @constructor
   * @desc Controla la vista para el listado de Empleados
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} EmployeeService - Proveedor de datos, Empleados
   */
  function EmployeesListController(EmployeeService) {
    var vm = this;
    vm.employees = EmployeeService.query();
  }

  angular
    .module('sislabApp')
    .controller('EmployeesListController',
      [
        'EmployeeService',
        EmployeesListController
      ]
    );

  // NormsListController.js
  /**
   * @name NormsListController
   * @constructor
   * @desc Controla la vista para consulta de Normas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} NormsListService - Proveedor de datos, lista Normas
   */
  function NormsListController(NormsListService) {
    var vm = this;
    vm.clients = NormsListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('NormsListController',
      [
        'NormsListService',
        NormsListController
      ]
    );

  // ReferencesListController.js
  /**
   * @name ReferencesListController
   * @constructor
   * @desc Controla la vista para consulta de Referencias
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReferencesListService - Proveedor de datos, lista Referencias
   */
  function ReferencesListController(ReferencesListService) {
    var vm = this;
    vm.ReferencesList = ReferencesListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('ReferencesListController',
      [
        'ReferencesListService',
        ReferencesListController
      ]
    );

  // MethodsListController.js
  /**
   * @name MethodsListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Métodos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} MethodsListService - Proveedor de datos, Métodos
   */
  function MethodsListController(MethodsListService) {
    var vm = this;
    vm.methodsList = MethodsListService.query();

    vm.selectRow = selectRow;
    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('MethodsListController',
      [
        'MethodsListService',
        MethodsListController
      ]
    );

  // PricesListController.js
  /**
   * @name PricesListController
   * @constructor
   * @desc Controla la vista para consulta de Precios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PricesListService - Proveedor de datos, lista Precios
   */
  function PricesListController(PricesListService) {
    var vm = this;
    vm.pricesList = PricesListService.query();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }

  angular
    .module('sislabApp')
    .controller('PricesListController',
      [
        'PricesListService',
        PricesListController
      ]
    );

  // UsersListController.js
  /**
   * @name UsersListController
   * @constructor
   * @desc Controla la vista para el listado de Usuarios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} UsersListService - Proveedor de datos, Usuarios
   */
  function UsersListController (UsersListService) {
    var vm = this;
    vm.users = UsersListService.query();
  }

  angular
    .module('sislabApp')
    .controller('UsersListController',
      [
        'UsersListService',
        UsersListController
      ]
    );

  // ProfileController.js
  /**
   * @name ProfileController
   * @constructor
   * @desc Controla la vista para Perfil
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} UserProfileService - Proveedor de datos, Perfil de usuario
   */
  function ProfileController(UserProfileService) {
    var vm = this;
    vm.profile = UserProfileService.query();
  }

  angular
    .module('sislabApp')
    .controller('ProfileController',
      [
        'UserProfileService',
        ProfileController
      ]
    );

  // LogoutController.js
  /**
   * @name LogoutController
   * @constructor
   * @desc Controla la vista para Logout
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} TokenService - Manejo de objeto Window [AngularJS]
   */
  function LogoutController($location, TokenService) {
    var vm = this;
    vm.logout = logout;

    function logout() {
      TokenService.clearToken();
      $location.path('sistema/login');
    }
  }

  angular
    .module('sislabApp')
    .controller('LogoutController',
      [
        '$location', 'TokenService',
        LogoutController
      ]
    );

  // ClientDetailController.js
  /**
   * @name ClientDetailController
   * @constructor
   * @desc Controla la vista para con el detalle de un Cliente
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ClientDetailService - Proveedor de datos, Detalle cliente
   */
  function ClientDetailController($scope, ClientDetailService) {
    var vm = this;
    vm.clientDetail = ClientDetailService.query();
  }

  angular
    .module('sislabApp')
    .controller('ClientDetailController',
      [
        '$scope',
        'ClientDetailService',
        ClientsListController
      ]
    );
