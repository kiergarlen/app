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
        String(TokenService.hashMessage(vm.user.password))
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

  //TaskListController.js
  /**
   * @name TaskListController
   * @constructor
   * @desc Controla la vista para Tareas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} TaskService - Proveedor de datos, Tareas
   */
  function TaskListController(TokenService, TaskService) {
    var vm = this,
    userData;
    vm.userName = '';
    vm.tasks = {};
    if (TokenService.isAuthenticated())
    {
      userData = TokenService.getUserFromToken();
      vm.userName = userData.name;
      vm.tasks = TaskService.get();
    }
  }
  angular
    .module('sislabApp')
    .controller('TaskListController',
      [
        'TokenService', 'TaskService',
        TaskListController
      ]
    );

  //StudyListController.js
  /**
   * @name StudyListController
   * @constructor
   * @desc Controla la vista para el listado de Estudios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudyListController($location, StudyService) {
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
    .controller('StudyListController',
      [
        '$location', 'StudyService',
        StudyListController
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
    vm.addOrder = addOrder;
    vm.removeOrder = removeOrder;
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

    function addOrder() {
      vm.study.ordenes.push({
        'id_orden':vm.study.ordenes.length + 1,
        'id_estudio':vm.study.id_estudio,
        'id_matriz':0,
        'cantidad_muestras':0,
        'id_tipo_muestreo':1,
        'id_norma':0
      });
    }

    function removeOrder(event) {
      var field = '$$hashKey',
      orderRow = ArrayUtilsService.extractItemFromCollection(
        vm.study.ordenes,
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

    function isOrderListValid() {
      var i = 0,
      l = 0,
      orders = [];
      if (vm.study.ordenes && vm.study.ordenes.length > 0)
      {
        orders = vm.study.ordenes;
        l = orders.length;
        for (i = 0; i < l; i += 1) {
          if (orders[i].id_matriz < 1)
          {
            vm.message += ' Seleccione una matriz, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (isNaN(orders[i].cantidad_muestras) || orders[i].cantidad_muestras < 1)
          {
            vm.message += ' Ingrese cantidad de muestras, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (orders[i].id_tipo_muestreo < 1)
          {
            vm.message += ' Seleccione un tipo de muestreo, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (orders[i].id_norma < 1)
          {
            vm.message += ' Seleccione una norma, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      }
      else
      {
        vm.message += ' Agregue una orden ';
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
      if (!isOrderListValid())
      {
        return isOrderListValid();
      }
      if (vm.study.id_origen_orden < 1)
      {
        vm.message += ' Seleccione un medio de orden de muestreo ';
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

  //QuoteListController.js
  /**
   * @name QuoteListController
   * @constructor
   * @desc Controla la vista para el listado de Solicitudes/Cotizaciones
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} QuoteService - Proveedor de datos, Solicitud
   */
  function QuoteListController($location, QuoteService) {
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
    .controller('QuoteListController',
      [
        '$location', 'QuoteService',
        QuoteListController
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
              'muestreo/solicitud',
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
                'muestreo/solicitud',
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

  //OrderListController.js
  /**
   * @name OrderListController
   * @constructor
   * @desc Controla la vista para el listado de Órdenes muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} OrderService - Proveedor de datos, Órdenes de muestreo
   */
  function OrderListController($location, OrderService) {
    var vm = this;
    vm.orders = OrderService.get();
    vm.viewOrder = viewOrder;

    function viewOrder(id) {
      $location.path('/muestreo/orden/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('OrderListController',
      [
        '$location', 'OrderService',
        OrderListController
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

  //PlanListController.js
  /**
   * @name PlanListController
   * @constructor
   * @desc Controla la vista para el listado de Planes de muestreo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} PlanService - Proveedor de datos, Planes de muestreo
   */
  function PlanListController($location, PlanService) {
    var vm = this;
    vm.plans = PlanService.get();
    vm.viewPlan = viewPlan;

    function viewPlan(id) {
      $location.path('/muestreo/plan/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('PlanListController',
      [
        '$location', 'PlanService',
        PlanListController
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
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} PlanObjectivesService - Proveedor de datos, Objetivos Plan de muestreo
   * @param {Object} DistrictService - Proveedor de datos, Municipios
   * @param {Object} CityService - Proveedor de datos, Localidades
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   * @param {Object} ReactiveService - Proveedor de datos, Reactivos
   * @param {Object} MaterialService - Proveedor de datos, Material
   * @param {Object} CoolerService - Proveedor de datos, Hieleras
   * @param {Object} SamplingInstrumentService - Proveedor de datos, Equipos de muestreo
   * @param {Object} PlanService - Proveedor de datos, Plan de muestreo
   */
  function PlanController($scope,$routeParams,TokenService,
    ValidationService,RestUtilsService,ArrayUtilsService,
    DateUtilsService,PlanObjectivesService,DistrictService,
    CityService,SamplingEmployeeService,ContainerService,
    ReactiveService,MaterialService,CoolerService,
    SamplingInstrumentService,PlanService) {
    var vm = this;
    vm.plan = PlanService.query({planId: $routeParams.planId});
    vm.user = TokenService.getUserFromToken();
    vm.objectives = PlanObjectivesService.get();
    vm.instruments = SamplingInstrumentService.get();
    vm.cities = [];
    vm.districts = [];
    vm.samplingEmployees = SamplingEmployeeService.get();
    vm.containers = ContainerService.get();
    vm.reactives = ReactiveService.get();
    vm.materials = MaterialService.get();
    vm.coolers = CoolerService.get();
    vm.isInstrumentListLoaded = false;
    vm.isContainerListLoaded = false;
    vm.isReactiveListLoaded = false;
    vm.isMaterialListLoaded = false;
    vm.isCoolerListLoaded = false;
    vm.isDataSubmitted = false;
    vm.selectDistrict = selectDistrict;
    vm.selectInstruments = selectInstruments;
    vm.selectContainers = selectContainers;
    vm.selectReactives = selectReactives;
    vm.selectMaterials = selectMaterials;
    vm.selectCoolers = selectCoolers;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
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
        if (vm.plan.equipos.length > 0 && !vm.isInstrumentListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.instruments,
            vm.plan.equipos,
            'id_equipo',
            [
              'selected'
            ]
          );
          vm.isInstrumentListLoaded = true;
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
        if (vm.plan.recipientes.length > 0 && !vm.isContainerListLoaded)
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
          vm.isContainerListLoaded = true;
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
        if (vm.plan.reactivos.length > 0 && !vm.isReactiveListLoaded)
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
          vm.isReactiveListLoaded = true;
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
        if (vm.plan.materiales.length > 0 && !vm.isMaterialListLoaded)
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
          vm.isMaterialListLoaded = true;
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
        if (vm.plan.hieleras.length > 0 && !vm.isCoolerListLoaded)
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
          vm.isCoolerListLoaded = true;
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
      ValidationService.approveItem(vm.plan, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.plan, vm.user);
    }

    function isInstrumentListValid() {
      if (vm.plan.id_responsable_calibracion < 1)
      {
        vm.message += ' Seleccione una Responsable de calibración ';
        return false;
      }
      if (!DateUtilsService.isValidDate(new Date(vm.plan.fecha_calibracion)))
      {
        vm.message += ' Ingrese una fecha válida de calibración ';
        return false;
      }
      if (vm.plan.equipos.length < 1)
      {
        vm.message += ' Seleccione al menos un equipo ';
        return false;
      }
      return true;
    }

    function isContainerListValid() {
      var i = 0,
      l = 0,
      containers = [];
      if (vm.plan.id_responsable_recipientes < 1)
      {
        vm.message += ' Seleccione una Responsable de preparación de recipientes ';
        return false;
      }
      if (vm.plan.recipientes && vm.plan.recipientes.length > 0)
      {
        containers = vm.plan.recipientes;
        l = containers.length;
        for (i = 0; i < l; i += 1) {
          if (isNaN(containers[i].cantidad) || containers[i].cantidad < 1)
          {
            vm.message += ' Ingrese cantidad de recipientes, para la preservación ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      }
      else
      {
        vm.message += ' Seleccione un recipiente ';
        return false;
      }
      return true;
    }

    function isReactiveListValid() {
      var i = 0,
      l = 0,
      reactives = [];
      if (vm.plan.id_responsable_reactivos < 1)
      {
        vm.message += ' Seleccione una Responsable de reactivos ';
        return false;
      }
      if (vm.plan.reactivos && vm.plan.reactivos.length > 0)
      {
        reactives = vm.plan.reactivos;
        l = reactives.length;
        for (i = 0; i < l; i += 1) {
          if (isNaN(reactives[i].cantidad) || reactives[i].cantidad < 1)
          {
            vm.message += ' Ingrese cantidad, para el reactivo ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (isNaN(reactives[i].lote) || reactives[i].lote < 1)
          {
            vm.message += ' Ingrese lote, para el reactivo ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      }
      else
      {
        vm.message += ' Seleccione un recipiente ';
        return false;
      }
      return true;
    }

    function isMaterialListValid() {
      var i = 0,
      l = 0,
      materials = [];
      if (vm.plan.id_responsable_material < 1)
      {
        vm.message += ' Seleccione una Responsable de preparación de material ';
        return false;
      }
      if (vm.plan.materiales.length < 1)
      {
        vm.message += ' Seleccione los materiales y equipos ';
        return false;
      }
      return true;
    }

    function isCoolerListValid() {
      var i = 0,
      l = 0,
      coolers = [];
      if (vm.plan.id_responsable_hieleras < 1)
      {
        vm.message += ' Seleccione una Responsable de hieleras ';
        return false;
      }
      if (vm.plan.hieleras.length < 1)
      {
        vm.message += ' Seleccione hieleras ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (vm.plan.id_objetivo_plan < 1)
      {
        vm.message += ' Seleccione un objetivo ';
        return false;
      }
      if (vm.plan.id_objetivo_plan == 5 && vm.plan.objetivo_otro.length < 1)
      {
        vm.message += ' Si selecciona otro objetivo debe ingresarlo ';
        return false;
      }
      if (vm.plan.calle.length < 1)
      {
        vm.message += ' Ingrese una calle o ubicación ';
        return false;
      }
      if (vm.plan.id_municipio < 1)
      {
        vm.message += ' Seleccione un municipio ';
        return false;
      }
      if (vm.plan.id_localidad < 1)
      {
        vm.message += ' Seleccione una localidad ';
        return false;
      }
      if (vm.plan.solicitud.id_tipo_muestreo > 1 && isNaN(vm.plab.frecuencia_muestreo))
      {
        vm.message += ' Seleccione una frecuencia de muestreo ';
        return false;
      }
      if (vm.plan.id_supervisor_entrega < 1)
      {
        vm.message += ' Seleccione un Responsable de muestreo ';
        return false;
      }
      if (vm.plan.id_ayudante_entrega < 1)
      {
        vm.message += ' Seleccione una Acompañante de muestreo ';
        return false;
      }
      if (vm.plan.id_supervisor_recolecion < 1)
      {
        vm.message += ' Seleccione un Responsable de recolección ';
        return false;
      }
      if (vm.plan.id_ayudante_recolecion < 1)
      {
        vm.message += ' Seleccione una Acompañante de recolección ';
        return false;
      }
      if (vm.plan.id_supervisor_registro < 1)
      {
        vm.message += ' Seleccione un Responsable de registro de resultados ';
        return false;
      }
      if (vm.plan.id_ayudante_registro < 1)
      {
        vm.message += ' Seleccione una Acompañante de registro de resultados ';
        return false;
      }
      if (!isInstrumentListValid)
      {
        return false;
      }
      if (!isContainerListValid)
      {
        return false;
      }
      if (!isReactiveListValid)
      {
        return false;
      }
      if (!isCoolerListValid)
      {
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.plan.id_status == 3 && vm.plan.motivo_rechaza.length < 1)
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
        console.log(vm.study);
        vm.isDataSubmitted = true;
        if (vm.plan.id_estudio > 0)
        {
          RestUtilsService
            .saveData(
              PlanService,
              vm.plan,
              'muestreo/plan',
              'id_plan'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.plan.plan.id_status < 2)
          {
            RestUtilsService
              .updateData(
                PlanService,
                vm.plan,
                'muestreo/plan',
                'id_plan'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('PlanController',
      [
        '$scope','$routeParams','TokenService',
        'ValidationService','RestUtilsService','ArrayUtilsService',
        'DateUtilsService','PlanObjectivesService','DistrictService',
        'CityService','SamplingEmployeeService','ContainerService',
        'ReactiveService','MaterialService','CoolerService',
        'SamplingInstrumentService','PlanService',
        PlanController
      ]
    );

  //SheetListController.js
  /**
   * @name SheetListController
   * @constructor
   * @desc Controla la vista para el listado de Hojas de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} SheetService - Proveedor de datos, Hoja de campo
   */
  function SheetListController($location, SheetService) {
    var vm = this;
    vm.sheets = SheetService.get();
    vm.viewSheet = viewSheet;

    function viewSheet(id) {
      $location.path('/recepcion/hoja/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('SheetListController',
      [
        '$location', 'SheetService',
        SheetListController
      ]
    );

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
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} SheetService - Proveedor de datos, Hojas de campo
   */
  function SheetController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, CloudService, WindService,
    WaveService, SamplingNormService, PreservationService,
    SheetService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.sheet = SheetService.query({sheetId: $routeParams.sheetId});
    vm.cloudCovers = CloudService.get();
    vm.windDirections = WindService.get();
    vm.waveIntensities = WaveService.get();
    vm.samplingNorms = SamplingNormService.get();
    vm.preservations = PreservationService.get();
    //SheetService
    //  .query({sheetId: $routeParams.sheetId})
    //  .$promise
    //  .then(function success(response) {
    //    vm.sheet = response;
    //  });
    vm.isPreservationListLoaded = false;
    vm.isDataSubmitted = false;
    vm.selectPreservations = selectPreservations;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
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
          vm.sheet.preservaciones = ArrayUtilsService
            .selectItemsFromCollection(
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

    function isResultListValid(sample, sampleResults) {
      var i = 0,
      l = 0,
      results = sampleResults.slice();
      l = results.length;
      for (i = 0; i < l; i += 1) {
        if (results[i].valor_texto.length > 0)
        {
          if (results[i].id_tipo_valor == 2 && results[i].valor_texto.length < 2)
          {
            vm.message += ' Ingrese un valor para el parámetro ';
            vm.message += results[i].parametro + ' ';
            vm.message += sample.punto + ' ';
            return false;
          }
          if (results[i].id_tipo_valor == 1 && isNaN(results[i].valor))
          {
            vm.message += ' Ingrese un valor numérico para el parámetro ';
            vm.message += results[i].parametro + ' ';
            vm.message += sample.punto + ' ';
            return false;
          }
        }
      }
      return true;
    }

    function isSampleListValid() {
      var i = 0,
      l = 0,
      samples = [];
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
          isResultListValid(samples[i], samples[i].resultados);
        }
      }
      else
      {
        vm.message += ' Sin resultados ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (vm.sheet.id_norma_muestreo < 1)
      {
        vm.message += ' Seleccione una Norma de referencia ';
        return false;
      }
      if (!DateUtilsService.isValidDate(new Date(vm.sheet.fecha_inicio)))
      {
        vm.message += ' Ingrese una fecha/hora de muestreo válida ';
        return false;
      }
      if (!isSampleListValid())
      {
        return false;
      }
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
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.sheet.id_hoja < 1)
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
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'CloudService', 'WindService',
        'WaveService', 'SamplingNormService', 'PreservationService',
        'SheetService',
        SheetController
      ]
    );

  //ReceptionListController.js
  /**
   * @name ReceptionListController
   * @constructor
   * @desc Controla la vista para el listado de Recepciones
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
   */
  function ReceptionListController($location, ReceptionService) {
    var vm = this;
    vm.receptions = ReceptionService.get();
    vm.viewReception = viewReception;

    function viewReception(id) {
      $location.path('/recepcion/recepcion/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('ReceptionListController',
      [
        '$location', 'ReceptionService',
        ReceptionListController
      ]
    );

  // ReceptionController.js
  /**
   * @name ReceptionController
   * @constructor
   * @desc Controla la vista para capturar la recepción de muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
   */
  function ReceptionController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, SamplingEmployeeService, ReceptionService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.receptionists = SamplingEmployeeService.get();
    vm.reception = ReceptionService.query({receptionId: $routeParams.receptionId});
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;

      /*
    vm.selectSample = selectSample;
    function selectSample() {
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
      */

    function approveItem() {
      ValidationService.approveItem(vm.reception, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.reception, vm.user);
    }

    function isFormValid() {
      vm.message = '';
      if (!DateUtilsService.isValidDate(new Date(vm.reception.hoja.fecha_muestreo)))
      {
        vm.message += ' Ingrese una fecha/hora de muestreo válida ';
        return false;
      }
      if (!DateUtilsService.isValidDate(new Date(vm.reception.hoja.fecha_recibe)))
      {
        vm.message += ' Ingrese una fecha/hora de recepción válida ';
        return false;
      }
      if (vm.reception.id_recepcionista < 1)
      {
        vm.message += ' Seleccione un responsable de la recepción ';
        return false;
      }
      if (vm.reception.muestras.length < 1)
      {
        vm.message += ' Confirme la recepción de al menos una muestra ';
        return false;
      }
      if (vm.reception.id_validacion_muestra < 1)
      {
        vm.message += ' Selececcione una muestra a verificar ';
        return false;
      }
      if (vm.reception.validacion_preservaciones.length < 1)
      {
        vm.message += ' Seleccione al menos una preservación ';
        return false;
      }
      if (vm.reception.validacion_contenedores.length < 1)
      {
        vm.message += ' Seleccione al menos un tipo de análisis ';
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.reception.id_status == 3 && vm.reception.motivo_rechaza.length < 1)
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
        if (vm.reception.id_recepcion < 1)
        {
          RestUtilsService
            .saveData(
              ReceptionService,
              vm.reception,
              'recepcion/recepcion',
              'id_recepcion'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.reception.reception.id_status < 2)
          {
            RestUtilsService
              .updateData(
                ReceptionService,
                vm.reception,
                'recepcion/recepcion',
                'id_recepcion'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('ReceptionController',
      [
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService','SamplingEmployeeService', 'ReceptionService',
        ReceptionController
      ]
    );

  /**
   * @name CustodyListController
   * @constructor
   * @desc Controla la vista para el listado de Cadenas de custodia
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} CustodyService - Proveedor de datos, Cadenas de custodia
   */
  function CustodyListController($location, CustodyService) {
    var vm = this;
    vm.custodies = CustodyService.get();
    vm.viewCustody = viewCustody;

    function viewCustody(id) {
      $location.path('/recepcion/custodia/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('CustodyListController',
      [
        '$location', 'CustodyService',
        CustodyListController
      ]
    );

  // CustodyController.js
  /**
   * @name CustodyController
   * @constructor
   * @desc Controla la vista para capturar las Hojas de custodia
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} CustodyService - Proveedor de datos, Cadenas de custodia
   */
  function CustodyController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, CustodyService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.custody = CustodyService.query({custodyId: $routeParams.custodyId});
    vm.isDataSubmitted = false;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;

    function approveItem() {
      ValidationService.approveItem(vm.custody, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.custody, vm.user);
    }

    function isFormValid() {
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.custody.id_custodia < 1)
        {
          RestUtilsService
            .saveData(
              CustodyService,
              vm.custody,
              'recepcion/custodia',
              'id_custodia'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.custody.custody.id_status < 2)
          {
            RestUtilsService
              .updateData(
                CustodyService,
                vm.custody,
                'recepcion/custodia',
                'id_custodia'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('CustodyController',
      [
        '$scope', '4routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'CustodyService',
        CustodyController
      ]
    );