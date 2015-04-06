  //CONTROLLERS
  //LoginController.js
  /**
   * @name LoginController
   * @constructor
   * @desc Controla la vista para Login
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   */
  function LoginController($scope, TokenService) {
    var vm = this;
    vm.message = '';
    vm.user = {username: '', password: ''};
    vm.submitForm = submitForm;

    function submitForm() {
      vm.message = '';
      if (!$scope.loginForm.$valid)
      {
        vm.message = 'Ingrese usuario y/o contraseña';
        return;
      }
      vm.message = TokenService.authenticateUser(
        vm.user.username,
        vm.user.password
      );
    }
  }
  angular
    .module('sislabApp')
    .controller('LoginController',
      [
        '$scope', 'TokenService',
        LoginController
      ]
    );

  //MenuController.js
  /**
   * @name MenuController
   * @constructor
   * @desc Controla la directiva para el Menú principal
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} MenuService - Proveedor de datos, Menú
   */
  function MenuController(MenuService) {
    var vm = this;
    vm.menu = MenuService.get();
  }
  angular
    .module('sislabApp')
    .controller('MenuController',
      [
        'MenuService',
        MenuController
      ]
    );

  //TasksListController.js
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
    vm.userName = '';
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

  //StudiesListController.js
  /**
   * @name StudiesListController
   * @constructor
   * @desc Controla la vista para el listado de Estudios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudiesListController($location, StudyService) {
    var vm = this;
    vm.studies = StudyService.get();
    vm.addStudy = addStudy;
    vm.viewStudy = viewStudy;

    function addStudy() {
      $location.path('/estudio/estudio/0');
    }

    function viewStudy(id) {
      $location.path('/estudio/estudio/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('StudiesListController',
      [
        '$location', 'StudyService',
        StudiesListController
      ]
    );

  //StudyController.js
  /**
   * @name StudyController
   * @constructor
   * @desc Controla la vista para capturar un Estudio
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} ClientService - Proveedor de datos, Clientes
   * @param {Object} MatrixService - Proveedor de datos, Matrices
   * @param {Object} SamplingTypeService - Proveedor de datos, Tipos de muestreo
   * @param {Object} NormService - Proveedor de datos, Normas
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes de orden
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudyController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, ClientService, MatrixService,
    SamplingTypeService, NormService, OrderSourceService,
    StudyService) {
    var vm = this;
    vm.study = StudyService.query({studyId: $routeParams.studyId});
    vm.user = TokenService.getUserFromToken();
    vm.clients = ClientService.get();
    vm.matrices = MatrixService.get();
    vm.samplingTypes = SamplingTypeService.get();
    vm.norms = NormService.get();
    vm.orderSources = OrderSourceService.get();
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.selectClient = selectClient;
    vm.getScope = getScope;
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

    function getScope() {
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

    function removeQuote(event) {
      var field = '$$hashKey',
      quoteRow = ArrayUtilsService.extractItemFromCollection(
        vm.study.solicitudes,
        field,
        event[field]
      );
    }

    function approveItem() {
      ValidationService.approveItem(vm.study, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.study, vm.user);
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
          if (isNaN(quotes[i].cantidad_muestras) || quotes[i].cantidad_muestras < 1)
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
        vm.message += ' Agregue una solicitud ';
        return false;
      }
      return true;
    }

    function isFormValid() {
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
      if (!isQuoteListValid())
      {
        return isQuoteListValid();
      }
      if (vm.study.id_origen_orden < 1)
      {
        vm.message += ' Seleccione un medio de solicitud de muestreo ';
        return false;
      }
      if (vm.study.id_origen_orden == 1 || vm.study.id_origen_orden == 4)
      {
        if (vm.study.origen_descripcion.length < 1)
        {
          vm.message += ' Ingrese oficio o emergencia ';
          return false;
        }
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
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
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
              'estudio/estudio',
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
                'estudio/estudio',
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
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'ClientService', 'MatrixService',
        'SamplingTypeService', 'NormService', 'OrderSourceService',
        'StudyService',
        StudyController
      ]
    );

  //QuotesListController.js
  /**
   * @name QuotesListController
   * @constructor
   * @desc Controla la vista para el listado de Solicitudes/Cotizaciones
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} QuoteService - Proveedor de datos, Solicitud
   */
  function QuotesListController($location, QuoteService) {
    var vm = this;
    vm.quotes = QuoteService.get();
    vm.viewQuote = viewQuote;

    function viewQuote(id) {
      var itemId = parseInt(id);
      $location.path('/muestreo/solicitud/' + itemId);
    }
  }
  angular
    .module('sislabApp')
    .controller('QuotesListController',
      [
        '$location', 'QuoteService',
        QuotesListController
      ]
    );

  // QuoteController.js
  /**
   * @name QuoteController
   * @constructor
   * @desc Controla la vista para capturar una Solicitud
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} ParameterService - Proveedor de datos, Parámetros de análisis
   * @param {Object} QuoteService - Proveedor de datos, Solicitudes
   */
  function QuoteController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    ParameterService, QuoteService) {
    var vm = this;
    vm.quote = QuoteService.query({quoteId: $routeParams.quoteId});
    vm.user = TokenService.getUserFromToken();
    vm.parameters = ParameterService.get();
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

    function approveItem() {
      ValidationService.approveItem(vm.quote, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.quote, vm.user);
    }

    function isFormValid() {
      vm.message = '';
      if (vm.quote.cuerpo_receptor.length > 0 && vm.quote.tipo_cuerpo.length < 1)
      {
        vm.message += ' Ingrese tipo de cuerpo receptor';
        return false;
      }
      if (vm.quote.cuerpo_receptor.length < 1 && vm.quote.tipo_cuerpo.length > 0)
      {
        vm.message += ' Ingrese cuerpo receptor';
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.quote.id_status == 3 && vm.quote.motivo_rechaza.length < 1)
        {
          vm.message += ' Ingrese el motivo de rechazo de la Solicitud ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.quote.id_solicitud > 0)
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
          if (vm.user.level < 3 || vm.quote.quote.id_status < 2)
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
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'ParameterService', 'QuoteService',
        QuoteController
      ]
    );

  //OrdersListController.js
  /**
   * @name OrdersListController
   * @constructor
   * @desc Controla la vista para el listado de Órdenes muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} OrderService - Proveedor de datos, Órdenes de muestreo
   */
  function OrdersListController($location, OrderService) {
    var vm = this;
    vm.orders = OrderService.get();
    vm.viewOrder = viewOrder;

    function viewOrder(id) {
      $location.path('/muestreo/orden/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('OrdersListController',
      [
        '$location', 'OrderService',
        OrdersListController
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
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} PointPackageService - Proveedor de datos, Paquetes de puntos
   * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores de muestreo
   * @param {Object} OrderService - Proveedor de datos, Órdenes de muestreo
   */
  function OrderController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, PointPackageService, SamplingSupervisorService,
    OrderService) {
    var vm = this;
    vm.order = OrderService.query({orderId: $routeParams.orderId});
    vm.user = TokenService.getUserFromToken();
    vm.supervisors = SamplingSupervisorService.get();
    vm.packages = PointPackageService.get();
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.getScope = getScope;
    vm.addPlan = addPlan;
    vm.removePlan = removePlan;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;

    function getScope() {
      return vm;
    }

    function addPlan() {
      vm.order.planes.push({
        'id_plan':vm.order.planes.length + 1,
        'id_estudio':vm.order.id_estudio,
        'id_orden':vm.order.id_orden,
        'id_paquete_puntos':0,
        'id_supervisor_muestreo':0,
        'id_status':0,
        'fecha_probable':'',
        'activo':1
      });
    }

    function removePlan(event) {
      var field = '$$hashKey',
      quoteRow = ArrayUtilsService.extractItemFromCollection(
        vm.order.planes,
        field,
        event[field]
      );
    }

    function approveItem() {
      ValidationService.approveItem(vm.order, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.order, vm.user);
    }

    function isPlanListValid() {
      var i = 0,
      l = 0,
      plans = [];
      if (vm.order.planes && vm.order.planes.length > 0)
      {
        plans = vm.order.planes;
        l = plans.length;
        for (i = 0; i < l; i += 1) {
          if (plans[i].id_paquete_puntos < 1)
          {
            vm.message = ' Seleccione un Paquete de puntos ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (plans[i].id_supervisor_muestreo < 1)
          {
            vm.message = ' Seleccione un Responsable de muestreo ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (!DateUtilsService.isValidDate(new Date(plans[i].fecha_probable)))
          {
            vm.message = ' Ingrese fecha y hora válidas ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      }
      else
      {
        vm.message += ' Agregue un plan ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (!isPlanListValid())
      {
        return isPlanListValid();
      }
      if (vm.user.level < 3)
      {
        if (vm.order.id_status == 3 && vm.order.motivo_rechaza.length < 1)
        {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        if (vm.order.id_orden > 0)
        {
          RestUtilsService
            .saveData(
              OrderService,
              vm.order,
              'muestreo/orden',
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
                'muestreo/orden',
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
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'PointPackageService', 'SamplingSupervisorService',
        'OrderService',
        OrderController
      ]
    );

  //PlansListController.js
  /**
   * @name PlansListController
   * @constructor
   * @desc Controla la vista para el listado de Planes de muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} PlanService - Proveedor de datos, Planes de muestreo
   */
  function PlansListController($location, PlanService) {
    var vm = this;
    vm.plans = PlanService.get();
    vm.viewPlan = viewPlan;

    function viewPlan(id) {
      $location.path('/muestreo/plan/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('PlansListController',
      [
        '$location', 'PlanService',
        PlansListController
      ]
    );
