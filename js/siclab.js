(function() {
  'use strict';
  // ANGULAR MODULE SETTER
  angular
    .module('siclabApp', [
      'ngRoute',
      'ngResource',
      'ngAnimate',
      'angular-jwt',
      'mgcrea.ngStrap'
    ]
  );

  // DATA API URL
  var API_BASE_URL = 'api/v1/';

  // config.js
  /**
   * @name config
   * @desc Configuración de AngularJS
   * @param {Object} $routeProvider - Proveedor, manejo de rutas de la applicación
   * @param {Object} $httpProvider - Proveedor, manejo de peticiones HTTP
   * @param {Object} jwtInterceptorProvider - Proveedor, manejo de interceptor para implentación de JWT
   */
  function config($routeProvider, $httpProvider, jwtInterceptorProvider,
    $collapseProvider) {
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
        templateUrl: 'partials/sistema/tareas.html',
        controller: 'TasksListController',
        controllerAs: 'tasks'
      }).
      when('/muestreo/solicitudes', {
        templateUrl: 'partials/muestreo/solicitudes.html',
        controller: 'QuotesListController',
        controllerAs: 'quotes'
      }).
      when('/muestreo/solicitud/:quoteId', {
        templateUrl: 'partials/muestreo/solicitud.html',
        controller: 'QuoteController',
        controllerAs: 'quote'
      }).
      when('/muestreo/ordenes', {
        templateUrl: 'partials/muestreo/ordenes.html',
        controller: 'OrdersListController',
        controllerAs: 'orders'
      }).
      when('/muestreo/orden/:orderId', {
        templateUrl: 'partials/muestreo/orden.html',
        controller: 'OrderController',
        controllerAs: 'order'
      }).
      when('/muestreo/planes', {
        templateUrl: 'partials/muestreo/planes.html',
        controller: 'PlansListController',
        controllerAs: 'plans'
      }).
      when('/muestreo/plan/:planId', {
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
    angular.extend($collapseProvider.defaults, {
      startCollapsed: true
    });
  }

  angular
    .module('siclabApp')
    .config(
      [
        '$routeProvider', '$httpProvider', 'jwtInterceptorProvider',
        '$collapseProvider',
        config
      ]
    );

  // DIRECTIVES
  // siclabMenu.js
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

  // siclabBanner.js
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

  // siclabFooter.js
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

  // siclabBannerBottom.js
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
    .module('siclabApp')
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
   * @param {Object} $window - Manejo de objeto Window [AngularJS]
   * @param {Object} jwtHelper - Utilerías para JWT [angular-jwt]
   */
  function LoginController($scope, $http, $location,
    $window, jwtHelper) {
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
        $window.localStorage.setItem('siclab-token', token);
        $location.path('main');
      }, function error(response) {
        if (response.status === 404) {
          vm.message = 'Sin enlace al servidor';
        } else {
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
    .module('siclabApp')
    .controller('LoginController',
      [
        '$scope', '$http', '$location',
        '$window', 'jwtHelper',
        LoginController
      ]
    );

  // TasksListController.js
  /**
   * @name TasksListController
   * @constructor
   * @desc Controla la vista para Tareas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} TasksListService - Proveedor de datos, Tareas
   */
  function TasksListController($window, jwtHelper, TasksListService) {
    var vm = this,
    token,
    decodedJwt;
    vm.userName = "";
    vm.tasks = {};

    if ($window.localStorage.getItem('siclab-token'))
    {
      token = $window.localStorage.getItem('siclab-token');
      decodedJwt = token && jwtHelper.decodeToken(token);
      vm.userName = decodedJwt.nam;
      vm.tasks = TasksListService.query(decodedJwt.uid);
    }
  }

  angular
    .module('siclabApp')
    .controller('TasksListController',
      [
        '$window', 'jwtHelper', 'TasksListService',
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
    vm.selectRow = selectRow;

    function addQuote() {
      $location.path('/muestreo/solicitud/0');
    }

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/muestreo/solicitud/' + itemId);
    }
  }

  angular
    .module('siclabApp')
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
  function QuoteController($routeParams, ClientService, ParameterService,
    NormService, SamplingTypeService, QuoteService) {
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
    .module('siclabApp')
    .controller('QuoteController',
      [
        '$routeParams', 'ClientService', 'ParameterService',
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    vm.cities = CityService.query({cityId: vm.plan.id_municipio});
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
      vm.cities = CityService.query({cityId: vm.plan.id_municipio});
    }
  }

  angular
    .module('siclabApp')
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
    .module('siclabApp')
    .controller('FieldSheetController',
      [
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
    .module('siclabApp')
    .controller('ReceptionController',
      [
        'ReceptionistService', 'ReceptionService',
        ReceptionController
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
  function CustodyController(PreservationService, ExpirationService,
    RequiredVolumeService, ContainerKindsService, CheckerService,
    CustodyService) {
    var vm = this;
    vm.preservations = PreservationService.query();
    vm.expirations = ExpirationService.query();
    vm.volumes = RequiredVolumeService.query();
    vm.containers = ContainerKindsService.query();
    vm.checkers = CheckerService.query();
    vm.custody = CustodyService.query();

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
    .module('siclabApp')
    .controller('CustodyController',
      [
        'PreservationService', 'ExpirationService', 'RequiredVolumeService',
        'ContainerKindsService', 'CheckerService', 'CustodyService',
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
    .controller('ReportsListController',
      [
        'ReportsListService',
        ReportsListController
      ]
    );

  // ReportApprovalController.js
  /**
   * @name ReportApprovalController
   * @constructor
   * @desc Controla la vista para validación Reporte
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
    .module('siclabApp')
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
   * @param {Object} $window - Manejo de objeto Window [AngularJS]
   */
  function LogoutController($location, $window) {
    var vm = this;
    vm.logout = logout;

    function logout() {
      $window.localStorage.removeItem('siclab-token');
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
    .module('siclabApp')
    .controller('ClientDetailController',
      [
        '$scope',
        'ClientDetailService',
        ClientsListController
      ]
    );

  // SERVICES
  // TokenService.js
  /**
   * @name TokenService
   * @constructor
   * @desc Proveedor para manejo del token
   * @param {Object} $window - Acceso a Objeto Window [AngularJS]
   * @return {Object} Object - Métodos para manejo de token
   */
  function TokenService($window) {
    var tokenKey = 'siclab-token',
    storage = $window.localStorage,
    cachedToken;

    return {
      isAuthenticated: function isAuthenticated() {
        return !!getToken();
      },
      setToken: function setToken(token) {
        cachedToken = token;
        storage.setItem(tokenKey, token);
      },
      getToken: function getToken() {
        if (!cachedToken)
        {
          cachedToken = storage.getItem(tokenKey);
        }
        return cachedToken;
      },
      clearToken: function clearToken() {
        cachedToken = null;
        storage.removeItem(tokenKey);
      }
    };
  }

  angular
    .module('siclabApp')
    .factory('TokenService', [
      '$window'
    ]
  );



  // MenuService.js
  /**
   * @name MenuService
   * @constructor
   * @desc Proveedor de datos, Menú
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MenuService($resource, $window) {
    return $resource(API_BASE_URL + 'menu', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MenuService', [
      '$resource', '$window',
      MenuService
    ]
  );

  // TasksListService.js
  /**
   * @name TasksListService
   * @constructor
   * @desc Proveedor de datos, Tareas
   * @param {Object} $resource- Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function TasksListService($resource, $window){
    return $resource(API_BASE_URL + 'tasks', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('TasksListService', [
      '$resource', '$window',
      TasksListService
    ]
  );

  // ClientService.js
  /**
   * @name ClientService
   * @constructor
   * @desc Proveedor de datos, Cliente
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ClientService($resource, $window) {
    return $resource(API_BASE_URL + 'clients', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ClientService', [
      '$resource', '$window',
      ClientService
    ]
  );

  // ParameterService.js
  /**
   * @name ParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ParameterService($resource, $window) {
    return $resource(API_BASE_URL + 'parameters', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token': $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ParameterService', [
      '$resource', '$window',
      ParameterService
    ]
  );

  // NormService.js
  /**
   * @name NormService
   * @constructor
   * @desc Proveedor de datos, Normas referencia
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function NormService($resource, $window) {
    return $resource(API_BASE_URL + 'norms', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('NormService', [
      '$resource', '$window',
      NormService
    ]
  );

  // SamplingTypeService.js
  /**
   * @name SamplingTypeService
   * @constructor
   * @desc Proveedor de datos, Tipo muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingTypeService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/types', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingTypeService', [
      '$resource', '$window',
      SamplingTypeService
    ]
  );

  // QuoteService.js
  /**
   * @name QuoteService
   * @constructor
   * @desc Proveedor de datos, Cotizaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function QuoteService($resource, $window) {
    return $resource(API_BASE_URL + 'quotes/:quoteId', {}, {
      query: {
        method:'GET',
        params:{quoteId:'id_solicitud'},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('QuoteService', [
      '$resource', '$window',
      QuoteService
    ]
   );


  // OrderSourceService.js
  /**
   * @name OrderSourceService
   * @constructor
   * @desc Proveedor de datos, Orígenes orden
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrderSourceService($resource, $window) {
    return $resource(API_BASE_URL + 'order/sources', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('OrderSourceService', [
      '$resource', '$window',
      OrderSourceService
    ]
  );

  // MatrixService.js
  /**
   * @name MatrixService
   * @constructor
   * @desc Proveedor de datos, Matrices
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MatrixService($resource, $window) {
    return $resource(API_BASE_URL + 'matrices', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MatrixService', [
      '$resource', '$window',
      MatrixService
    ]
  );

  // SamplingSupervisorService.js
  /**
   * @name SamplingSupervisorService
   * @constructor
   * @desc Proveedor de datos, Supervisores muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingSupervisorService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/supervisors', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingSupervisorService', [
      '$resource', '$window',
      SamplingSupervisorService
    ]
  );

  // OrdersListService.js
  /**
   * @name OrdersListService
   * @constructor
   * @desc Proveedor de datos, lista de órdenes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrdersListService($resource, $window) {
    return $resource(API_BASE_URL + 'orders', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('OrdersListService', [
      '$resource', '$window',
      OrdersListService
    ]
  );

  // OrderService.js
  /**
   * @name OrderService
   * @constructor
   * @desc Proveedor de datos, Orden muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrderService($resource, $window) {
    return $resource(API_BASE_URL + 'orders/:orderId', {}, {
      query: {
        method:'GET',
        params:{orderId: 'id_orden'},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('OrderService', [
      '$resource', '$window',
      OrderService
    ]
  );

  // PlanObjectivesService.js
  /**
   * @name PlanObjectivesService
   * @constructor
   * @desc Proveedor de datos, Objetivos plan
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlanObjectivesService($resource, $window) {
    return $resource(API_BASE_URL + 'plan/objectives', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PlanObjectivesService', [
      '$resource', '$window',
      PlanObjectivesService
    ]
  );

  // PointKindsService.js
  /**
   * @name PointKindsService
   * @constructor
   * @desc Proveedor de datos, tipos Punto
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointKindsService($resource, $window) {
    return $resource(API_BASE_URL + 'point/kinds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PointKindsService', [
      '$resource', '$window',
      PointKindsService
    ]
  );

  // DistrictService.js
  /**
   * @name DistrictService
   * @constructor
   * @desc Proveedor de datos, Municipios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function DistrictService($resource, $window) {
    return $resource(API_BASE_URL + 'districts', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('DistrictService', [
      '$resource', '$window',
      DistrictService
    ]
  );

  // CityService.js
  /**
   * @name CityService
   * @constructor
   * @desc Proveedor de datos, Localidades
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CityService($resource, $window) {
    return $resource(API_BASE_URL + 'districts/cities/:districtId', {}, {
      query: {
        method:'GET',
        params:{districtId: 'id_municipio'},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CityService', [
      '$resource', '$window',
      CityService
    ]
  );

  // SamplingEmployeeService.js
  /**
   * @name SamplingEmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingEmployeeService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/employees', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingEmployeeService', [
      '$resource', '$window',
      SamplingEmployeeService
    ]
  );

  // PreservationService.js
  /**
   * @name PreservationService
   * @constructor
   * @desc Proveedor de datos, Preservaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PreservationService($resource, $window) {
    return $resource(API_BASE_URL + 'preservations', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PreservationService', [
      '$resource', '$window',
      PreservationService
    ]
  );

  // ContainerKindsService.js
  /**
   * @name ContainerKindsService
   * @constructor
   * @desc Proveedor de datos, Recipientes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ContainerKindsService($resource, $window) {
    return $resource(API_BASE_URL + 'containers/kinds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ContainerKindsService', [
      '$resource', '$window',
      ContainerKindsService
    ]
  );

  // ReactivesListService.js
  /**
   * @name ReactivesListService
   * @constructor
   * @desc Proveedor de datos, lista Reactivos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReactivesListService($resource, $window) {
    return $resource(API_BASE_URL + 'reactives', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReactivesListService', [
      '$resource', '$window',
      ReactivesListService
    ]
  );

  // MaterialService.js
  /**
   * @name MaterialService
   * @constructor
   * @desc Proveedor de datos, Materiales
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MaterialService($resource, $window) {
    return $resource(API_BASE_URL + 'materials', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MaterialService', [
      '$resource', '$window',
      MaterialService
    ]
  );

  // CoolerService.js
  /**
   * @name CoolerService
   * @constructor
   * @desc Proveedor de datos, Hieleras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CoolerService($resource, $window) {
    return $resource(API_BASE_URL + 'coolers', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CoolerService', [
      '$resource', '$window',
      CoolerService
    ]
  );

  // PlansListService.js
  /**
   * @name PlansListService
   * @constructor
   * @desc Proveedor de datos, lista de Planes muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlansListService($resource, $window) {
    return $resource(API_BASE_URL + 'plans', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PlansListService', [
      '$resource', '$window',
      PlansListService
    ]
  );

  // PlanService.js
  /**
   * @name PlanService
   * @constructor
   * @desc Proveedor de datos, Plan muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlanService($resource, $window) {
    return $resource(API_BASE_URL + 'plans/:planId', {}, {
      query: {
        method:'GET',
        params:{planId: 'id_plan'},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PlanService', [
      '$resource', '$window',
      PlanService
    ]
  );

  // CloudService.js
  /**
   * @name CloudService
   * @constructor
   * @desc Proveedor de datos, Coberturas nubes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CloudService($resource, $window) {
    return $resource(API_BASE_URL + 'clouds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CloudService', [
      '$resource', '$window',
      CloudService
    ]
  );

  // WindService.js
  /**
   * @name WindService
   * @constructor
   * @desc Proveedor de datos, Direcciones viento
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function WindService($resource, $window) {
    return $resource(API_BASE_URL + 'winds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('WindService', [
      '$resource', '$window',
      WindService
    ]
  );

  // WaveService.js
  /**
   * @name WaveService
   * @constructor
   * @desc Proveedor de datos, Intensidades oleaje
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function WaveService($resource, $window) {
    return $resource(API_BASE_URL + 'waves', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('WaveService', [
      '$resource', '$window',
      WaveService
    ]
  );

  // SamplingNormService.js
  /**
   * @name SamplingNormService
   * @constructor
   * @desc Proveedor de datos, Normas muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingNormService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/norms', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingNormService', [
      '$resource', '$window',
      SamplingNormService
    ]
  );

  // PointService.js
  /**
   * @name PointService
   * @constructor
   * @desc Proveedor de datos, Puntos muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointService($resource, $window) {
    return $resource(API_BASE_URL + 'points', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PointService', [
      '$resource', '$window',
      PointService
    ]
  );

  // FieldParameterService.js
  /**
   * @name FieldParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function FieldParameterService($resource, $window) {
    return $resource(API_BASE_URL + 'parameters/field', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('FieldParameterService', [
      '$resource', '$window',
      FieldParameterService
    ]
  );

  // FieldSheetService.js
  /**
   * @name FieldSheetService
   * @constructor
   * @desc Proveedor de datos, Hojas campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function FieldSheetService($resource, $window) {
    //return $resource(API_BASE_URL + 'fieldsheets/:fieldsheetId', {}, {
    return $resource('models/field_sheets/1.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('FieldSheetService', [
      '$resource', '$window',
      FieldSheetService
    ]
  );

  // ReceptionistService.js
  /**
   * @name ReceptionistService
   * @constructor
   * @desc Proveedor de datos, Recepcionistas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReceptionistService($resource, $window) {
    return $resource(API_BASE_URL + 'receptionists', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReceptionistService', [
      '$resource', '$window',
      ReceptionistService
    ]
  );

  // ReceptionService.js
  /**
   * @name ReceptionService
   * @constructor
   * @desc Proveedor de datos, Recepción
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReceptionService($resource, $window) {
    //return $resource(API_BASE_URL + 'receptions/:receptionId', {}, {
    return $resource('models/sampling/samples/1.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReceptionService', [
      '$resource', '$window',
      ReceptionService
    ]
  );

  // ExpirationService.js
  /**
   * @name ExpirationService
   * @constructor
   * @desc Proveedor de datos, Vigencias
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ExpirationService($resource, $window) {
    return $resource(API_BASE_URL + 'expirations', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ExpirationService', [
      '$resource', '$window',
      ExpirationService
    ]
  );

  // RequiredVolumeService.js
  /**
   * @name RequiredVolumeService
   * @constructor
   * @desc Proveedor de datos, Volúmenes requeridos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function RequiredVolumeService($resource, $window) {
    return $resource(API_BASE_URL + 'volumes', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('RequiredVolumeService', [
      '$resource', '$window',
      RequiredVolumeService
    ]
  );

  // CheckerService.js
  /**
   * @name CheckerService
   * @constructor
   * @desc Proveedor de datos, Responsables verificación
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CheckerService($resource, $window) {
    return $resource(API_BASE_URL + 'checkers', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CheckerService', [
      '$resource', '$window',
      CheckerService
    ]
  );

  // CustodyService.js
  /**
   * @name CustodyService
   * @constructor
   * @desc Proveedor de datos, Cadenas custodia
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CustodyService($resource, $window) {
    //return $resource(API_BASE_URL + 'custodies/:custodyId', {}, {
    return $resource('models/custodies/100.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CustodyService', [
      '$resource', '$window',
      CustodyService
    ]
  );

  // SamplesListService.js
  /**
   * @name SamplesListService
   * @constructor
   * @desc Proveedor de datos, lista Muestras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplesListService($resource, $window) {
    return $resource(API_BASE_URL + 'samples', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplesListService', [
      '$resource', '$window',
      SamplesListService
    ]
  );

  // InstrumentsListService.js
  /**
   * @name InstrumentsListService
   * @constructor
   * @desc Proveedor de datos, lista Equipos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function InstrumentsListService($resource, $window) {
    return $resource(API_BASE_URL + 'instruments', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('InstrumentsListService', [
      '$resource', '$window',
      InstrumentsListService
    ]
  );

  // ContainersListService.js
  /**
   * @name ContainersListService
   * @constructor
   * @desc Proveedor de datos, lista Recipients
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ContainersListService($resource, $window) {
    return $resource(API_BASE_URL + 'containers', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ContainersListService', [
      '$resource', '$window',
      ContainersListService
    ]
  );

  // AnalysisListService.js
  /**
   * @name AnalysisListService
   * @constructor
   * @desc Proveedor de datos, consulta de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function AnalysisListService($resource, $window) {
    return $resource(API_BASE_URL + 'analysis', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('AnalysisListService', [
      '$resource', '$window',
      AnalysisListService
    ]
  );

  // DepartmentService.js
  /**
   * @name DepartmentService
   * @constructor
   * @desc Proveedor de datos, Áreas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function DepartmentService($resource, $window) {
    return $resource(API_BASE_URL + 'areas', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('DepartmentService', [
      '$resource', '$window',
      DepartmentService
    ]
  );

  // AnalysisService.js
  /**
   * @name AnalysisService
   * @constructor
   * @desc Proveedor de datos, selección de formato de captura de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function AnalysisService($resource, $window) {
    return $resource(API_BASE_URL + 'analysis/selections', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('AnalysisService', [
      '$resource', '$window',
      AnalysisService
    ]
  );

  // ReportsListService.js
  /**
   * @name ReportsListService
   * @constructor
   * @desc Proveedor de datos, lista Reportes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReportsListService($resource, $window) {
    return $resource(API_BASE_URL + 'reports', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReportsListService', [
      '$resource', '$window',
      ReportsListService
    ]
  );

  // ReportApprovalService.js
  /**
   * @name ReportApprovalService
   * @constructor
   * @desc Proveedor de datos, validación Reporte
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReportApprovalService($resource, $window) {
    //return $resource(API_BASE_URL + 'reports/:reportId', {}, {
    return $resource('models/report.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReportApprovalService', [
      '$resource', '$window',
      ReportApprovalService
    ]
  );

  // PointsListService.js
  /**
   * @name PointsListService
   * @constructor
   * @desc Proveedor de datos, lista Puntos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointsListService($resource, $window) {
    return $resource(API_BASE_URL + 'points', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PointsListService', [
      '$resource', '$window',
      PointsListService
    ]
  );

  // EmployeeService.js
  /**
   * @name EmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function EmployeeService($resource, $window) {
    return $resource(API_BASE_URL + 'employees', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('EmployeeService', [
      '$resource', '$window',
      EmployeeService
    ]
  );

  // NormsListService.js
  /**
   * @name NormsListService
   * @constructor
   * @desc Proveedor de datos, lista Normas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function NormsListService($resource, $window) {
    return $resource(API_BASE_URL + 'norms', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('NormsListService', [
      '$resource', '$window',
      NormsListService
    ]
  );

  // ReferencesListService.js
  /**
   * @name ReferencesListService
   * @constructor
   * @desc Proveedor de datos, lista Referencias
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReferencesListService($resource, $window) {
    return $resource(API_BASE_URL + 'references', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReferencesListService', [
      '$resource', '$window',
      ReferencesListService
    ]
  );

  // MethodsListService.js
  /**
   * @name MethodsListService
   * @constructor
   * @desc Proveedor de datos, Métodos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MethodsListService($resource, $window) {
    return $resource(API_BASE_URL + 'methods', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MethodsListService', [
      '$resource', '$window',
      MethodsListService
    ]
  );

  // PricesListService.js
  /**
   * @name PricesListService
   * @constructor
   * @desc Proveedor de datos, lista Precios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PricesListService($resource, $window) {
    return $resource(API_BASE_URL + 'prices', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PricesListService', [
      '$resource', '$window',
      PricesListService
    ]
  );

  // UsersListService.js
  /**
   * @name UsersListService
   * @constructor
   * @desc Proveedor de datos, Usuarios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function UsersListService($resource, $window) {
    return $resource(API_BASE_URL + 'users', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('UsersListService', [
      '$resource', '$window',
      UsersListService
    ]
  );

  // UserProfileService.js
  /**
   * @name UserProfileService
   * @constructor
   * @desc Proveedor de datos, Perfil de usuario
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function UserProfileService($resource, $window) {
    //return $resource(API_BASE_URL + 'users/:userId', {}, {
    return $resource('models/profile.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('UserProfileService', [
      '$resource', '$window',
      UserProfileService
    ]
  );

  // QuotesListService.js
  /**
   * @name QuotesListService
   * @constructor
   * @desc Proveedor de datos, lista de Cotizaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function QuotesListService($resource, $window) {
    return $resource(API_BASE_URL + 'quotes', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('QuotesListService', [
      '$resource', '$window',
      QuotesListService
    ]
  );

  // ClientDetailService.js
  /**
   * @name ClientDetailService
   * @constructor
   * @desc Proveedor de datos, Detalle cliente
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ClientDetailService($resource, $window) {
    //return $resource(API_BASE_URL + 'clients/:clientId', {}, {
    return $resource('models/clients/:clientId.json', {}, {
      query: {
        method:'GET',
        params:{clientId:'id_cliente'},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ClientDetailService', [
      '$resource', '$window',
      ClientDetailService
    ]
  );

})();
