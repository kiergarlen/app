(function() {
  'use strict';

  angular
    .module('siclabApp', [
      'ngRoute',
      'ngResource',
      'angular-jwt',
      'angular-storage',
      'mgcrea.ngStrap'
    ]
  );

  /**
   * @name config
   * @desc Configuración de AngularJS
   * @param {Object} $routeProvider - Proveedor, manejo de rutas de la applicación
   * @param {Object} $httpProvider - Proveedor, manejo de peticiones HTTP
   * @param {Object} jwtInterceptorProvider - Proveedor, manejo de interceptor para implentación de JWT
   */
  function config($routeProvider, $httpProvider, jwtInterceptorProvider) {
    $routeProvider
      .otherwise({
       redirectTo: '/sistema/login'
      }).
      when('/sistema/login', {
        templateUrl: 'partials/sistema/login.html',
        controller: 'LoginController',
        controllerAs: 'login'
      }).
      when('/main', {
        templateUrl: 'partials/sistema/main.html',
        controller: 'TasksController',
        controllerAs: 'tasks'
      }).
      when('/muestreo/solicitudes', {
        templateUrl: 'partials/muestreo/solicitudes.html',
        controller: 'QuoteListController',
        controllerAs: 'quoteList'
      }).
      when('/muestreo/solicitud', {
        templateUrl: 'partials/muestreo/solicitud.html',
        controller: 'QuoteController',
        controllerAs: 'quote'
      }).
      when('/muestreo/orden', {
        templateUrl: 'partials/muestreo/orden.html',
        controller: 'OrderController',
        controllerAs: 'order'
      }).
      when('/muestreo/plan', {
        templateUrl: 'partials/muestreo/plan.html',
        controller: 'PlanController',
        controllerAs: 'plan'
      }).
      when('/recepcion/campo', {
        templateUrl: 'partials/recepcion/campo.html',
        controller: 'FieldSheetController',
        controllerAs: 'fieldSheet'
      }).
      when('/recepcion/muestra', {
        templateUrl: 'partials/recepcion/muestra.html',
        controller: 'ReceptionController',
        controllerAs: 'reception'
      }).
      when('/recepcion/custodia', {
        templateUrl: 'partials/recepcion/custodia.html',
        controller: 'CustodyController',
        controllerAs: 'custody'
      }).
      when('/inventario/muestras', {
        templateUrl: 'partials/inventario/muestras.html',
        controller: 'SamplesListController',
        controllerAs: 'samplesList'
      }).
      when('/inventario/equipos', {
        templateUrl: 'partials/inventario/equipos.html',
        controller: 'InstrumentsListController',
        controllerAs: 'instrumentsList'
      }).
      when('/inventario/reactivos', {
        templateUrl: 'partials/inventario/reactivos.html',
        controller: 'ReactivesListController',
        controllerAs: 'reactivesList'
      }).
      when('/inventario/recipientes', {
        templateUrl: 'partials/inventario/recipientes.html',
        controller: 'ContainersListController',
        controllerAs: 'containersList'
      }).
      when('/analisis/consulta', {
        templateUrl: 'partials/analisis/consulta.html',
        controller: 'AnalysisListController',
        controllerAs: 'analysisList'
      }).
      when('/analisis/captura', {
        templateUrl: 'partials/analisis/captura.html',
        controller: 'AnalysisController',
        controllerAs: 'analysis'
      }).
      when('/reporte/consulta', {
        templateUrl: 'partials/reporte/reportes.html',
        controller: 'ReportsListController',
        controllerAs: 'reportsList'
      }).
      when('/reporte/validar', {
        templateUrl: 'partials/reporte/validar.html',
        controller: 'ReportApprovalController',
        controllerAs: 'reportApproval'
      }).
      when('/catalogo/puntos', {
        templateUrl: 'partials/catalogo/puntos.html',
        controller: 'PointsListController',
        controllerAs: 'pointsList'
      }).
      when('/catalogo/clientes', {
        templateUrl: 'partials/catalogo/clientes.html',
        controller: 'ClientsListController',
        controllerAs: 'clients'
      }).
      when('/catalogo/areas', {
        templateUrl: 'partials/catalogo/areas.html',
        controller: 'DepartmentsListController',
        controllerAs: 'departmentsList'
      }).
      when('/catalogo/empleados', {
        templateUrl: 'partials/catalogo/empleados.html',
        controller: 'EmployeesListController',
        controllerAs: 'employeesList'
      }).
      when('/catalogo/normas', {
        templateUrl: 'partials/catalogo/normas.html',
        controller: 'NormsListController',
        controllerAs: 'normsList'
      }).
      when('/catalogo/referencia', {
        templateUrl: 'partials/catalogo/referencia.html',
        controller: 'ReferencesListController',
        controllerAs: 'referencesList'
      }).
      when('/catalogo/metodos', {
        templateUrl: 'partials/catalogo/metodos.html',
        controller: 'MethodsListController',
        controllerAs: 'methodsList'
      }).
      when('/catalogo/precios', {
        templateUrl: 'partials/catalogo/precios.html',
        controller: 'PricesListController',
        controllerAs: 'pricesList'
      }).
      when('/sistema/usuarios', {
        templateUrl: 'partials/sistema/usuarios.html',
        controller: 'UsersListController',
        controllerAs: 'usersList'
      }).
      when('/sistema/perfil', {
        templateUrl: 'partials/sistema/perfil.html',
        controller: 'ProfileController',
        controllerAs: 'profile'
      }).
      when('/sistema/logout', {
        templateUrl: 'partials/sistema/logout.html',
        controller: 'LogoutController',
        controllerAs: 'logout'
      }).
      when('/catalogo/clientes/:clientId', {
        templateUrl: 'partials/catalogo/cliente.html',
        controller: 'ClientDetailController',
        controllerAs: 'clientDetail'
      })
    ;
  }

  angular
    .module('siclabApp')
    .config(
      [
        '$routeProvider', '$httpProvider', 'jwtInterceptorProvider',
        config
      ]
    );


  /**
   * @name siclabMenu
   * @desc Directiva para menú principal
   */
  function siclabMenu() {
    return {
      restrict: 'EA',
      require: '^ngModel',
      templateUrl: 'partials/sistema/menu.html'
    };
  }

  angular
    .module('siclabApp')
    .directive('siclabMenu', siclabMenu);

  /**
   * @name siclabBanner
   * @desc Directiva para banner superior
   */
  function siclabBanner() {
    return {
      restrict: 'EA',
      templateUrl: 'partials/sistema/banner.html'
    };
  }

  angular
    .module('siclabApp')
    .directive('siclabBanner', siclabBanner);

  /**
   * @name siclabFooter
   * @desc Directiva para pie de página
   */
  function siclabFooter() {
    return {
      restrict: 'EA',
      templateUrl: 'partials/sistema/footer.html'
    };
  }

  angular
    .module('siclabApp')
    .directive('siclabFooter', siclabFooter);


  /**
   * @name siclabBannerBottom
   * @desc Directiva para banner inferior
   */
  function siclabBannerBottom() {
    return {
      restrict: 'EA',
      templateUrl: 'partials/sistema/banner-bottom.html'
    };
  }

  angular
    .module('siclabApp')
    .directive('siclabBannerBottom', siclabBannerBottom);

  /**
   * @name MenuController
   * @constructor
   * @desc Controla la vista para el Menú principal
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} MenuService - Proveedor de datos, Menú
   */
  function MenuController($scope, MenuService) {
    $scope.menu = MenuService.query();
  }

  angular
    .module('siclabApp')
    .controller('MenuController',
      [
        '$scope',
        'MenuService',
        MenuController
      ]
    );

  /**
   * @name LoginController
   * @constructor
   * @desc Controla la vista para Login
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} $window - Manejo de objeto Window [AngularJS]
   * @param {Object} jwtHelper - Utilerías para JWT [angular-jwt]
   */
  function LoginController($scope, $http, $location, $window, jwtHelper) {
    var vm = this;
    vm.message = '';
    vm.user = {username: '', password: ''};
    vm.submit = submitMessage;
    vm.login = login;
    //console.log($window.localStorage.getItem('user-token'));

    function submitMessage(username, password) {
      $http({
        url: 'api/v1/login',
        method: 'POST',
        data: {
          username: username,
          password: password
        }
      }).then(function success(response) {
        var token = response.data || null;
        $window.localStorage.setItem('user-token', token);

        $location.path('main');

      }, function error(response) {
        if (response.status === 404) {
          //not found
        } else {
          //error
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
    .module('siclabApp')
    .controller('LoginController',
      [
        '$scope', '$http', '$location', '$window', 'jwtHelper',
        LoginController
      ]
    );

  /**
   * @name TasksController
   * @constructor
   * @desc Controla la vista para Bienvenida
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} TaskService - Proveedor de datos, Bienvenida
   */
  function TasksController(TaskService) {
    var vm = this;
    vm.welcome = TaskService.query();
  }

  angular
    .module('siclabApp')
    .controller('TasksController',
      [
        'TaskService',
        TasksController
      ]
    );

  /**
   * @name QuoteListController
   * @constructor
   * @desc Controla la vista para capturar una Solicitud/Cotización
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} QuoteListService - Proveedor de datos, lista de Cotizaciones
   */
  function QuoteListController(QuoteListService) {
    var vm = this;
    vm.quotes = QuoteListService.query();
    vm.selectRow = selectRow;
    vm.addNewQuote = addNewQuote;

    function selectRow() {
      //console.log($event);
    }

    function addNewQuote() {
      //$location.path('muestreo/solicitud');
    }
  }

  angular
    .module('siclabApp')
    .controller('QuoteListController',
      [
        'QuoteListService',
        QuoteListController
      ]
    );

  /**
   * @name QuoteController
   * @constructor
   * @desc Controla la vista para capturar una Solicitud/Cotización
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} ClientService - Proveedor de datos, Clientes
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} NormService - Proveedor de datos, Normas
   * @param {Object} SamplingTypeService - Proveedor de datos, Tipos muestreo
   * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
   */
  function QuoteController(ClientService, ParameterService, NormService,
    SamplingTypeService, QuoteService) {
    var vm = this;
    vm.clients = ClientService.query();
    vm.parameters = ParameterService.query();
    vm.norms = NormService.query();
    vm.samplingTypes = SamplingTypeService.query();
    vm.quote = QuoteService.query();
    vm.clientDetailVisible = false;
    vm.parametersDetailVisible = false;
    vm.allParametersSelected = false;
    vm.totalCost = 0;

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
      for (i; i < l; i += 1) {
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
        for (i; i < l; i += 1) {
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
    .module('siclabApp')
    .controller('QuoteController',
      [
        'ClientService', 'ParameterService', 'NormService',
        'SamplingTypeService', 'QuoteService',
        QuoteController
      ]
    );

  /**
   * @name OrderController
   * @constructor
   * @desc Controla la vista para capturar una Orden de muestreo
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes orden
   * @param {Object} MatrixService - Proveedor de datos, Tipos matriz
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
   * @param {Object} OrderService - Proveedor de datos, Orden muestreo
   */
  function OrderController(QuoteService, OrderSourceService,
    MatrixService, ParameterService, SamplingSupervisorService,
    OrderService) {
    var vm = this;
    vm.order = OrderService.query();
    vm.quote = QuoteService.query();
    vm.orderSources = OrderSourceService.query();
    vm.matrices = MatrixService.query();
    vm.supervisors = SamplingSupervisorService.query();
    vm.parameters = ParameterService.query();
    vm.parametersDetailVisible = false;

    vm.toggleParametersDetail = toggleParametersDetail;
    vm.selectOrderSource = selectOrderSource;
    vm.selectMatrix = selectMatrix;
    vm.selectSupervisor = selectSupervisor;
    vm.validateOrderForm = validateOrderForm;
    vm.submitOrderForm = submitOrderForm;

    function toggleParametersDetail() {
      vm.parametersDetailVisible = !vm.parametersDetailVisible;
    }

    function selectOrderSource(idSource) {
      var i = 0, l = vm.orderSources.length;
      vm.order.origen_orden = {};
      for (i; i < l; i += 1) {
        if (vm.orderSources[i].id_origen_orden == idSource)
        {
          vm.order.origen_orden = vm.orderSources[i];
          break;
        }
      }
      return vm.order.origen_orden;
    }

    function selectMatrix(idMatrix) {
      var i = 0, l = vm.matrices.length;
      vm.order.matriz = {};
      for (i; i < l; i += 1) {
        if (vm.matrices[i].id_matriz == idMatrix)
        {
          vm.order.matriz = vm.matrices[i];
          break;
        }
      }
      return vm.order.matriz;
    }

    function selectSupervisor(idSupervisor) {
      var i = 0, l = vm.supervisors.length;
      vm.order.id_supervisor_muestreo = {};
      for (i; i < l; i += 1) {
        if (vm.supervisors[i].id_id_supervisor_muestreo == idSupervisor)
        {
          vm.order.id_supervisor_muestreo = vm.supervisors[i];
          break;
        }
      }
      return vm.order.id_supervisor_muestreo;
    }

    function validateOrderForm() {

    }

    function submitOrderForm() {

    }
  }

  angular
    .module('siclabApp')
    .controller('OrderController',
      [
        'QuoteService','OrderSourceService','MatrixService',
        'ParameterService','SamplingSupervisorService','OrderService',
        OrderController
      ]
    );

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
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   * @param {Object} ReactivesListService - Proveedor de datos, lista Reactivos
   * @param {Object} MaterialService - Proveedor de datos, Material
   * @param {Object} CoolerService - Proveedor de datos, lista Hieleras
   * @param {Object} PlanService - Proveedor de datos, Plan muestreo
   */
  function PlanController(PlanObjectivesService, PointKindsService,
    DistrictService, CityService, SamplingSupervisorService,
    SamplingEmployeeService, PreservationService, ContainerService,
    ReactivesListService, MaterialService, CoolerService,
    PlanService) {
    var vm = this;
    vm.plan = PlanService.query();
    vm.objectives = PlanObjectivesService.query();
    vm.pointKinds = PointKindsService.query();
    vm.districts = DistrictService.query();
    vm.cities = CityService.query(vm.plan.id_municipio);
    vm.samplingSupervisors = SamplingSupervisorService.query();
    vm.samplingEmployees = SamplingEmployeeService.query();
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
        'SamplingEmployeeService', 'PreservationService', 'ContainerService',
        'ReactivesListService', 'MaterialService', 'CoolerService',
        'PlanService',
        PlanController
      ]
    );

  /**
   * @name FieldSheetController
   * @constructor
   * @desc Controla la vista para capturar la hoja de campo
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} CloudService - Proveedor de datos, Coberturas nubes
   * @param {Object} WindService - Proveedor de datos, Direcciones viento
   * @param {Object} WaveService - Proveedor de datos, Intensidades oleaje
   * @param {Object} SamplingNormService - Proveedor de datos, Normas muestreo
   * @param {Object} PointService - Proveedor de datos, Puntos muestreo
   * @param {Object} FieldParameterService - Proveedor de datos, Parámetros campo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} FieldSheetService - Proveedor de datos, Hojas de campo
   */
  function FieldSheetController(CloudService, WindService, WaveService,
    SamplingNormService, PointService, FieldParameterService,
    PreservationService, FieldSheetService) {
    var vm = this;
    vm.fieldSheet = FieldSheetService.query();
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
      for (i; i < l; i += 1) {
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
    .module('siclabApp')
    .controller('FieldSheetController',
      [
        'CloudService', 'WindService', 'WaveService',
        'SamplingNormService', 'PointService', 'FieldParameterService',
        'PreservationService', 'FieldSheetService',
        FieldSheetController
      ]
    );

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

  /**
   * @name SamplesListController
   * @constructor
   * @desc Controla la vista para consulta de Muestras
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('SamplesListController',
      [
        'SamplesListService',
        SamplesListController
      ]
    );

  /**
   * @name InstrumentsListController
   * @constructor
   * @desc Controla la vista para consulta de Equipos
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('InstrumentsListController',
      [
        'InstrumentsListService',
        InstrumentsListController
      ]
    );

  /**
   * @name ReactivesListController
   * @constructor
   * @desc Controla la vista para consulta de Reactivos
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('ReactivesListController',
      [
        'ReactivesListService',
        ReactivesListController
      ]
    );

  /**
   * @name ContainersListController
   * @constructor
   * @desc Controla la vista para consulta de Recipientes
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('ContainersListController',
      [
        'ContainersListService',
        ContainersListController
      ]
    );

  /**
   * @name AnalysisListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Análisis
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('AnalysisListController',
      [
        'AnalysisListService',
        AnalysisListController
      ]
    );

  /**
   * @name AnalysisController
   * @constructor
   * @desc Controla la vista para seleccionar captura de Análisis
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('AnalysisController',
      [
        'DepartmentService', 'ParameterService',
        'AnalysisService',
        AnalysisController
      ]
    );

  /**
   * @name ReportsListController
   * @constructor
   * @desc Controla la vista para consulta de Reportes
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('ReportsListController',
      [
        'ReportsListService',
        ReportsListController
      ]
    );

  /**
   * @name ReportApprovalController
   * @constructor
   * @desc Controla la vista para validación Reporte
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} ReportApprovalService - Proveedor de datos, validación Reporte
   */
  function ReportApprovalController(ReportApprovalService) {
    var vm = this;
    vm.reportApproval = ReportApprovalService.query();


    vm.validateReportApprovalForm = validateReportApprovalForm;
    vm.submitReportApprovalForm = submitReportApprovalForm;

    function validateReportApprovalForm() {

    }

    function submitReportApprovalForm() {

    }
  }

  angular
    .module('siclabApp')
    .controller('ReportApprovalController',
      [
        'ReportApprovalService',
        ReportApprovalController
      ]
    );

  /**
   * @name PointsListController
   * @constructor
   * @desc Controla la vista para consulta de Puntos
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('PointsListController',
      [
        'PointsListService',
        PointsListController
      ]
    );

  /**
   * @name ClientsListController
   * @constructor
   * @desc Controla la vista para el listado de Clientes
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} ClientService - Proveedor de datos, Cliente
   */
  function ClientsListController(ClientService) {
    var vm = this;
    vm.clients = ClientService.query();
  }

  angular
    .module('siclabApp')
    .controller('ClientsListController',
      [
        'ClientService',
        ClientsListController
      ]
    );

  /**
   * @name DepartmentsListController
   * @constructor
   * @desc Controla la vista para el listado de Áreas
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} DepartmentService - Proveedor de datos, Áreas
   */
  function DepartmentsListController(DepartmentService) {
    var vm = this;
    vm.departments = DepartmentService.query();
  }

  angular
    .module('siclabApp')
    .controller('DepartmentsListController',
      [
        'DepartmentService',
        DepartmentsListController
      ]
    );

  /**
   * @name EmployeesListController
   * @constructor
   * @desc Controla la vista para el listado de Empleados
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} EmployeeService - Proveedor de datos, Empleados
   */
  function EmployeesListController(EmployeeService) {
    var vm = this;
    vm.employees = EmployeeService.query();
  }

  angular
    .module('siclabApp')
    .controller('EmployeesListController',
      [
        'EmployeeService',
        EmployeesListController
      ]
    );

  /**
   * @name NormsListController
   * @constructor
   * @desc Controla la vista para consulta de Normas
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('NormsListController',
      [
        'NormsListService',
        NormsListController
      ]
    );

  /**
   * @name ReferencesListController
   * @constructor
   * @desc Controla la vista para consulta de Referencias
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('ReferencesListController',
      [
        'ReferencesListService',
        ReferencesListController
      ]
    );

  /**
   * @name MethodsListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Métodos
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('MethodsListController',
      [
        'MethodsListService',
        MethodsListController
      ]
    );

  /**
   * @name PricesListController
   * @constructor
   * @desc Controla la vista para consulta de Precios
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
    .module('siclabApp')
    .controller('PricesListController',
      [
        'PricesListService',
        PricesListController
      ]
    );

  /**
   * @name UsersListController
   * @constructor
   * @desc Controla la vista para el listado de Usuarios
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} UsersListService - Proveedor de datos, Usuarios
   */
  function UsersListController (UsersListService) {
    var vm = this;
    vm.users = UsersListService.query();
  }

  angular
    .module('siclabApp')
    .controller('UsersListController',
      [
        'UsersListService',
        UsersListController
      ]
    );

  /**
   * @name ProfileController
   * @constructor
   * @desc Controla la vista para Perfil
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} ProfileService - Proveedor de datos, Perfil
   */
  function ProfileController(ProfileService) {
    var vm = this;
    vm.profile = ProfileService.query();
  }

  angular
    .module('siclabApp')
    .controller('ProfileController',
      [
        'ProfileService',
        ProfileController
      ]
    );

  /**
   * @name LogoutController
   * @constructor
   * @desc Controla la vista para Logout
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} $window - Manejo de objeto Window [AngularJS]
   */
  function LogoutController($location, $window) {
    var vm = this;
    vm.logout = logout;

    function logout() {
      $window.localStorage.removeItem('user-token');
      $location.path('sistema/login');
    }
  }

  angular
    .module('siclabApp')
    .controller('LogoutController',
      [
        '$location', '$window',
        LogoutController
      ]
    );

  /**
   * @name ClientDetailController
   * @constructor
   * @desc Controla la vista para con el detalle de un Cliente
   * @this {Object} $scope - Contenedor para el modelo, AngularJS
   * @param {Object} ClientDetailService - Proveedor de datos, Detalle cliente
   */
  function ClientDetailController($scope, ClientDetailService) {
    var vm = this;
    vm.clientDetail = ClientDetailService.query();
  }

  angular
    .module('siclabApp')
    .controller('ClientDetailController',
      [
        '$scope',
        'ClientDetailService',
        ClientsListController
      ]
    );

  /**
   * @name MenuService
   * @constructor
   * @desc Proveedor de datos, Menú
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MenuService($resource, $http, $q) {
    return $resource('api/v1/menu', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('MenuService', [
      '$resource', '$http', '$q',
      MenuService
    ]
  );

  /**
   * @name TaskService
   * @constructor
   * @desc Proveedor de datos, Bienvenida
   * @param {Object} $resource- Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function TaskService($resource){
    return $resource('models/tasks.json', {}, {
      query: {method:'GET', params:{}, isArray:false}
    });
  }

  angular
    .module('siclabApp')
    .factory('TaskService', [
      '$resource',
      TaskService
    ]
  );

  /**
   * @name ClientService
   * @constructor
   * @desc Proveedor de datos, Cliente
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ClientService($resource) {
    return $resource('models/clients.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ClientService', [
      '$resource',
      ClientService
    ]
  );

  /**
   * @name ParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros análisis
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ParameterService($resource) {
    return $resource('models/parameters.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ParameterService', [
      '$resource',
      ParameterService
    ]
  );

  /**
   * @name NormService
   * @constructor
   * @desc Proveedor de datos, Normas referencia
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function NormService($resource) {
    return $resource('models/normas.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('NormService', [
      '$resource',
      NormService
    ]
  );

  /**
   * @name SamplingTypeService
   * @constructor
   * @desc Proveedor de datos, Tipo muestreo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingTypeService($resource) {
    return $resource('models/sampling/types.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingTypeService', [
      '$resource',
      SamplingTypeService
    ]
  );

  /**
   * @name QuoteService
   * @constructor
   * @desc Proveedor de datos, Cotizaciones
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function QuoteService($resource) {
    return $resource('models/quotes/1.json', {}, {
      query: {method:'GET', params:{}, isArray:false}
    });
  }

  angular
    .module('siclabApp')
    .factory('QuoteService', [
      '$resource',
      QuoteService
    ]
   );


  /**
   * @name OrderSourceService
   * @constructor
   * @desc Proveedor de datos, Orígenes orden
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrderSourceService($resource) {
    return $resource('models/order_sources.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('OrderSourceService', [
      '$resource',
      OrderSourceService
    ]
  );

  /**
   * @name MatrixService
   * @constructor
   * @desc Proveedor de datos, Matrices
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MatrixService($resource) {
    return $resource('models/matrices.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('MatrixService', [
      '$resource',
      MatrixService
    ]
  );

  /**
   * @name SamplingSupervisorService
   * @constructor
   * @desc Proveedor de datos, Supervisores muestreo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingSupervisorService($resource) {
    return $resource('models/sampling_supervisors.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingSupervisorService', [
      '$resource',
      SamplingSupervisorService
    ]
  );

  /**
   * @name OrderService
   * @constructor
   * @desc Proveedor de datos, Orden muestreo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrderService($resource) {
    return $resource('models/sampling/orders/1.json', {}, {
      query: {method:'GET', params:{}, isArray:false}
    });
  }

  angular
    .module('siclabApp')
    .factory('OrderService', [
      '$resource',
      OrderService
    ]
  );

  /**
   * @name PlanObjectivesService
   * @constructor
   * @desc Proveedor de datos, Objetivos plan
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlanObjectivesService($resource) {
    return $resource('models/plan_objectives.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('PlanObjectivesService', [
      '$resource',
      PlanObjectivesService
    ]
  );

  /**
   * @name PointKindsService
   * @constructor
   * @desc Proveedor de datos, tipos Punto
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointKindsService($resource) {
    return $resource('models/point_kinds.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('PointKindsService', [
      '$resource',
      PointKindsService
    ]
  );

  /**
   * @name DistrictService
   * @constructor
   * @desc Proveedor de datos, Municipios
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function DistrictService($resource) {
    return $resource('models/districts.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('DistrictService', [
      '$resource',
      DistrictService
    ]
  );

  /**
   * @name CityService
   * @constructor
   * @desc Proveedor de datos, Localidades
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CityService($resource) {
    return $resource('models/cities.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('CityService', [
      '$resource',
      CityService
    ]
  );

  /**
   * @name SamplingEmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados muestreo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingEmployeeService($resource) {
    return $resource('models/sampling_employees.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingEmployeeService', [
      '$resource',
      SamplingEmployeeService
    ]
  );

  /**
   * @name PreservationService
   * @constructor
   * @desc Proveedor de datos, Preservaciones
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PreservationService($resource) {
    return $resource('models/preservations.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('PreservationService', [
      '$resource',
      PreservationService
    ]
  );

  /**
   * @name ContainerService
   * @constructor
   * @desc Proveedor de datos, Recipientes
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ContainerService($resource) {
    return $resource('models/containers.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ContainerService', [
      '$resource',
      ContainerService
    ]
  );

  /**
   * @name ReactivesListService
   * @constructor
   * @desc Proveedor de datos, lista Reactivos
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReactivesListService($resource) {
    return $resource('models/reactives_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ReactivesListService', [
      '$resource',
      ReactivesListService
    ]
  );

  /**
   * @name MaterialService
   * @constructor
   * @desc Proveedor de datos, Materiales
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MaterialService($resource) {
    return $resource('models/materials.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('MaterialService', [
      '$resource',
      MaterialService
    ]
  );

  /**
   * @name CoolerService
   * @constructor
   * @desc Proveedor de datos, Hieleras
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CoolerService($resource) {
    return $resource('models/coolers.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('CoolerService', [
      '$resource',
      CoolerService
    ]
  );

  /**
   * @name PlanService
   * @constructor
   * @desc Proveedor de datos, Plan muestreo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlanService($resource) {
    return $resource('models/sampling/plans/1.json', {}, {
      query: {method:'GET', params:{}, isArray:false}
    });
  }

  angular
    .module('siclabApp')
    .factory('PlanService', [
      '$resource',
      PlanService
    ]
  );

  /**
   * @name CloudService
   * @constructor
   * @desc Proveedor de datos, Coberturas nubes
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CloudService($resource) {
    return $resource('models/clouds.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('CloudService', [
      '$resource',
      CloudService
    ]
  );

  /**
   * @name WindService
   * @constructor
   * @desc Proveedor de datos, Direcciones viento
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function WindService($resource) {
    return $resource('models/winds.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('WindService', [
      '$resource',
      WindService
    ]
  );

  /**
   * @name WaveService
   * @constructor
   * @desc Proveedor de datos, Intensidades oleaje
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function WaveService($resource) {
    return $resource('models/waves.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('WaveService', [
      '$resource',
      WaveService
    ]
  );

  /**
   * @name SamplingNormService
   * @constructor
   * @desc Proveedor de datos, Normas muestreo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingNormService($resource) {
    return $resource('models/sampling_norms.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingNormService', [
      '$resource',
      SamplingNormService
    ]
  );

  /**
   * @name PointService
   * @constructor
   * @desc Proveedor de datos, Puntos muestreo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointService($resource) {
    return $resource('models/points.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('PointService', [
      '$resource',
      PointService
    ]
  );

  /**
   * @name FieldParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros campo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function FieldParameterService($resource) {
    return $resource('models/field_parameters.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('FieldParameterService', [
      '$resource',
      FieldParameterService
    ]
  );

  /**
   * @name FieldSheetService
   * @constructor
   * @desc Proveedor de datos, Hojas campo
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function FieldSheetService($resource) {
    return $resource('models/field_sheets/1.json', {}, {
      query: {method:'GET', params:{}, isArray:false}
    });
  }

  angular
    .module('siclabApp')
    .factory('FieldSheetService', [
      '$resource',
      FieldSheetService
    ]
  );

  /**
   * @name ReceptionistService
   * @constructor
   * @desc Proveedor de datos, Recepcionistas
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReceptionistService($resource) {
    return $resource('models/receptionists.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ReceptionistService', [
      '$resource',
      ReceptionistService
    ]
  );

  /**
   * @name ReceptionService
   * @constructor
   * @desc Proveedor de datos, Recepción
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReceptionService($resource) {
    return $resource('models/sampling/samples/1.json', {}, {
      query: {method:'GET', params:{}, isArray:false}
    });
  }

  angular
    .module('siclabApp')
    .factory('ReceptionService', [
      '$resource',
      ReceptionService
    ]
  );

  /**
   * @name ExpirationService
   * @constructor
   * @desc Proveedor de datos, Vigencias
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ExpirationService($resource) {
    return $resource('models/expirations.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ExpirationService', [
      '$resource',
      ExpirationService
    ]
  );

  /**
   * @name RequiredVolumeService
   * @constructor
   * @desc Proveedor de datos, Volúmenes requeridos
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function RequiredVolumeService($resource) {
    return $resource('models/volumes.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('RequiredVolumeService', [
      '$resource',
      RequiredVolumeService
    ]
  );

  /**
   * @name CheckerService
   * @constructor
   * @desc Proveedor de datos, Responsables verificación
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CheckerService($resource) {
    return $resource('models/checkers.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('CheckerService', [
      '$resource',
      CheckerService
    ]
  );

  /**
   * @name CustodyService
   * @constructor
   * @desc Proveedor de datos, Cadenas custodia
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CustodyService($resource) {
    return $resource('models/custodies/100.json', {}, {
      query: {method:'GET', params:{}, isArray:false}
    });
  }

  angular
    .module('siclabApp')
    .factory('CustodyService', [
      '$resource',
      CustodyService
    ]
  );

  /**
   * @name SamplesListService
   * @constructor
   * @desc Proveedor de datos, lista Muestras
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplesListService($resource) {
    return $resource('models/samples_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplesListService', [
      '$resource',
      SamplesListService
    ]
  );

  /**
   * @name InstrumentsListService
   * @constructor
   * @desc Proveedor de datos, lista Equipos
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function InstrumentsListService($resource) {
    return $resource('models/instruments_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('InstrumentsListService', [
      '$resource',
      InstrumentsListService
    ]
  );

  /**
   * @name ContainersListService
   * @constructor
   * @desc Proveedor de datos, lista Recipients
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ContainersListService($resource) {
    return $resource('models/containers_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ContainersListService', [
      '$resource',
      ContainersListService
    ]
  );

  /**
   * @name AnalysisListService
   * @constructor
   * @desc Proveedor de datos, consulta de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function AnalysisListService($resource) {
    return $resource('models/analysis_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('AnalysisListService', [
      '$resource',
      AnalysisListService
    ]
  );

  /**
   * @name DepartmentService
   * @constructor
   * @desc Proveedor de datos, Áreas
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function DepartmentService($resource) {
    return $resource('models/areas.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('DepartmentService', [
      '$resource',
      DepartmentService
    ]
  );

  /**
   * @name AnalysisService
   * @constructor
   * @desc Proveedor de datos, selección de formato de captura de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function AnalysisService($resource) {
    return $resource('models/analysis_select.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('AnalysisService', [
      '$resource',
      AnalysisService
    ]
  );

  /**
   * @name ReportsListService
   * @constructor
   * @desc Proveedor de datos, lista Reportes
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReportsListService($resource) {
    return $resource('models/reports_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ReportsListService', [
      '$resource',
      ReportsListService
    ]
  );

  /**
   * @name ReportApprovalService
   * @constructor
   * @desc Proveedor de datos, validación Reporte
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReportApprovalService($resource) {
    return $resource('models/report.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ReportApprovalService', [
      '$resource',
      ReportApprovalService
    ]
  );

  /**
   * @name PointsListService
   * @constructor
   * @desc Proveedor de datos, lista Puntos
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointsListService($resource) {
    return $resource('models/points.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('PointsListService', [
      '$resource',
      PointsListService
    ]
  );

  /**
   * @name EmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function EmployeeService($resource) {
    return $resource('models/empleados.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('EmployeeService', [
      '$resource',
      EmployeeService
    ]
  );

  /**
   * @name NormsListService
   * @constructor
   * @desc Proveedor de datos, lista Normas
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function NormsListService($resource) {
    return $resource('models/norms_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('NormsListService', [
      '$resource',
      NormsListService
    ]
  );

  /**
   * @name ReferencesListService
   * @constructor
   * @desc Proveedor de datos, lista Referencias
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReferencesListService($resource) {
    return $resource('models/references_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ReferencesListService', [
      '$resource',
      ReferencesListService
    ]
  );

  /**
   * @name MethodsListService
   * @constructor
   * @desc Proveedor de datos, Métodos
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MethodsListService($resource) {
    return $resource('models/methods.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('MethodsListService', [
      '$resource',
      MethodsListService
    ]
  );

  /**
   * @name PricesListService
   * @constructor
   * @desc Proveedor de datos, lista Precios
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PricesListService($resource) {
    return $resource('models/prices_list.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('PricesListService', [
      '$resource',
      PricesListService
    ]
  );

  /**
   * @name UsersListService
   * @constructor
   * @desc Proveedor de datos, Usuarios
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function UsersListService($resource) {
    return $resource('models/users.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('UsersListService', [
      '$resource',
      UsersListService
    ]
  );

  /**
   * @name ProfileService
   * @constructor
   * @desc Proveedor de datos, Perfil
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ProfileService($resource) {
    return $resource('models/profile.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ProfileService', [
      '$resource',
      ProfileService
    ]
  );

  /**
   * @name QuoteListService
   * @constructor
   * @desc Proveedor de datos, lista de Cotizaciones
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function QuoteListService($resource) {
    return $resource('models/quotes/quotes.json', {}, {
      query: {method:'GET', params:{}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('QuoteListService', [
      '$resource',
      QuoteListService
    ]
  );

  /**
   * @name ClientDetailService
   * @constructor
   * @desc Proveedor de datos, Detalle cliente
   * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ClientDetailService($resource) {
    return $resource('models/clients/:clientId.json', {}, {
      query: {method:'GET', params:{clientId:'id_cliente'}, isArray:true}
    });
  }

  angular
    .module('siclabApp')
    .factory('ClientDetailService', [
      '$resource',
      ClientDetailService
    ]
  );

})();
