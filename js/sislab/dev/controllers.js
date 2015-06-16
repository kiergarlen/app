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
        'id_orden':0, 'id_estudio':vm.study.id_estudio,
        'id_cliente':0, 'id_matriz':0,
        'id_tipo_muestreo':1, 'id_norma':0,
        'id_cuerpo_receptor':5, 'id_status':1,
        'id_usuario_captura':0, 'id_usuario_valida':0,
        'id_usuario_actualiza':0, 'cantidad_muestras':0,
        'costo_total':0, 'cuerpo_receptor':'',
        'tipo_cuerpo':'', 'fecha':'',
        'fecha_captura':'', 'fecha_valida':'',
        'fecha_actualiza':'', 'fecha_rechaza':'',
        'ip_captura':'', 'ip_valida':'',
        'ip_actualiza':'', 'host_captura':'',
        'host_valida':'', 'host_actualiza':'',
        'motivo_rechaza':'', 'comentarios':'',
        'activo':1
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
      vm.study.id_etapa = 2;
      ValidationService.approveItem(vm.study, vm.user);
    }

    function rejectItem() {
      vm.study.id_etapa = 1;
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
        if (vm.study.id_estudio < 1)
        {
          //vm.study.$save();
          RestUtilsService
            .saveData(
              StudyService,
              vm.study,
              'estudio/estudio'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.study.study.id_status != 2)
          {
            //vm.study.$update();
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
              'muestreo/solicitud'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.quote.quote.id_status !== 2)
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
      if (vm.order.planes)
      {
        vm.order.planes.push({
          'id_plan': 0,
          'id_estudio': vm.order.id_estudio,
          'id_orden': vm.order.id_orden, 'id_ubicacion': 1,
          'id_paquete': 1, 'id_objetivo_plan': 1,
          'id_norma_muestreo': 1, 'id_estado': 14,
          'id_municipio': 1, 'id_localidad': 1,
          'id_supervisor_muestreo': 0,
          'id_supervisor_entrega': 0, 'id_supervisor_recoleccion': 0,
          'id_supervisor_registro': 0, 'id_ayudante_entrega': 0,
          'id_ayudante_recoleccion': 0, 'id_ayudante_registro': 0,
          'id_responsable_calibracion': 0,
          'id_responsable_recipientes': 0,
          'id_responsable_reactivos': 0, 'id_responsable_material': 0,
          'id_responsable_hieleras': 0, 'id_status': 1,
          'id_usuario_captura': 0, 'id_usuario_valida': 0,
          'id_usuario_actualiza': 0, 'fecha': '',
          'fecha_probable': '', 'fecha_calibracion': '',
          'fecha_captura': '', 'fecha_valida': '',
          'fecha_actualiza': '', 'fecha_rechaza': '',
          'ip_captura': '', 'ip_valida': '',
          'ip_actualiza': '', 'host_captura': '',
          'host_valida': '', 'host_actualiza': '',
          'calle': '', 'numero': '',
          'colonia': '', 'codigo_postal': '',
          'telefono': '', 'contacto': '',
          'email': '', 'comentarios_ubicacion': '',
          'cantidad_puntos': 0, 'cantidad_equipos': 0,
          'cantidad_recipientes': 0, 'cantidad_reactivos': 0,
          'cantidad_hieleras': 0, 'frecuencia': 0,
          'objetivo_otro': '', 'motivo_rechaza': '',
          'comentarios': '', 'activo': 1
        });
      }
      else
      {
        vm.order.planes = [{
          'id_plan': 0,
          'id_estudio': vm.order.id_estudio,
          'id_orden': vm.order.id_orden, 'id_ubicacion': 1,
          'id_paquete': 1, 'id_objetivo_plan': 1,
          'id_norma_muestreo': 1, 'id_estado': 14,
          'id_municipio': 1, 'id_localidad': 1,
          'id_supervisor_muestreo': 0,
          'id_supervisor_entrega': 0, 'id_supervisor_recoleccion': 0,
          'id_supervisor_registro': 0, 'id_ayudante_entrega': 0,
          'id_ayudante_recoleccion': 0, 'id_ayudante_registro': 0,
          'id_responsable_calibracion': 0,
          'id_responsable_recipientes': 0,
          'id_responsable_reactivos': 0, 'id_responsable_material': 0,
          'id_responsable_hieleras': 0, 'id_status': 1,
          'id_usuario_captura': 0, 'id_usuario_valida': 0,
          'id_usuario_actualiza': 0, 'fecha': '',
          'fecha_probable': '', 'fecha_calibracion': '',
          'fecha_captura': '', 'fecha_valida': '',
          'fecha_actualiza': '', 'fecha_rechaza': '',
          'ip_captura': '', 'ip_valida': '',
          'ip_actualiza': '', 'host_captura': '',
          'host_valida': '', 'host_actualiza': '',
          'calle': '', 'numero': '',
          'colonia': '', 'codigo_postal': '',
          'telefono': '', 'contacto': '',
          'email': '', 'comentarios_ubicacion': '',
          'cantidad_puntos': 0, 'cantidad_equipos': 0,
          'cantidad_recipientes': 0, 'cantidad_reactivos': 0,
          'cantidad_hieleras': 0, 'frecuencia': 0,
          'objetivo_otro': '', 'motivo_rechaza': '',
          'comentarios': '', 'activo': 1
        }];
      }
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
          if (!plans[i].id_paquete)
          {
            vm.message = ' No hay Paquete de puntos ';
            return false;
          }
          if (plans[i].id_paquete < 1)
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
              'muestreo/orden'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.order.order.id_status !== 2)
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
  function PlanController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, PlanObjectivesService, DistrictService,
    CityService, SamplingEmployeeService, ContainerService,
    ReactiveService, MaterialService, CoolerService,
    SamplingInstrumentService, PlanService) {
    var vm = this;
    vm.plan = {};
    vm.user = TokenService.getUserFromToken();
    vm.objectives = PlanObjectivesService.get();
    vm.cities = [];
    vm.districts = [];
    vm.samplingEmployees = SamplingEmployeeService.get();
    vm.instruments = [];
    vm.containers = [];
    vm.reactives = [];
    vm.materials = [];
    vm.coolers = [];
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

    PlanService
      .query({planId: $routeParams.planId})
      .$promise
      .then(function success(response) {
        vm.plan = response;
        DistrictService
          .get()
          .$promise
          .then(function success(response) {
            vm.districts = response;
            if (vm.plan.id_municipio && vm.plan.id_municipio > 0) {
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
                if (vm.plan.id_localidad && vm.plan.id_localidad > 0) {
                  ArrayUtilsService.selectItemFromCollection(
                    vm.cities,
                    'id_localidad',
                    parseInt(vm.plan.id_localidad)
                  );
                }
              });
          });
        SamplingInstrumentService
          .get()
          .$promise
          .then(function success(response) {
            var i;
            var l;
            vm.instruments = response;
            l = vm.instruments.length;
            for (i = 0; i < l; i += 1) {
              vm.instruments[i].id_plan = vm.plan.id_plan;
            }
          });
        ContainerService
          .get()
          .$promise
          .then(function success(response) {
            var i;
            var l;
            vm.containers = response;
            l = vm.containers.length;
            for (i = 0; i < l; i += 1) {
              vm.containers[i].id_plan = vm.plan.id_plan;
            }
            console.log(vm.containers);
          });
        ReactiveService
          .get()
          .$promise
          .then(function success(response) {
            var i;
            var l;
            vm.reactives = response;
            l = vm.reactives.length;
            for (i = 0; i < l; i += 1) {
              vm.reactives[i].id_plan = vm.plan.id_plan;
            }
          });
        MaterialService
          .get()
          .$promise
          .then(function success(response) {
            vm.materials = response;
          });
        CoolerService
          .get()
          .$promise
          .then(function success(response) {
            vm.coolers = response;
          });
      });

    function selectDistrict() {
      vm.cities = CityService.query({
        districtId: parseInt(vm.plan.id_municipio)
      });
    }

    function selectInstruments() {
      var items = [];
      if (vm.instruments.length > 0 && vm.plan.instrumentos)
      {
        if (vm.plan.instrumentos.length > 0 && !vm.isInstrumentListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.instruments,
            vm.plan.instrumentos,
            'id_instrumento',
            [
              'selected'
            ]
          );
          vm.isInstrumentListLoaded = true;
        }
        else
        {
          vm.plan.instrumentos = [];
          vm.plan.instrumentos = ArrayUtilsService.selectItemsFromCollection(
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
            'id_recipiente',
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
              'folio',
              'valor'
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
      if (vm.plan.instrumentos.length < 1)
      {
        vm.message += ' Seleccione al menos un instrumento ';
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
        console.log(vm.plan);
        vm.isDataSubmitted = true;
        if (vm.plan.id_estudio > 0)
        {
          RestUtilsService
            .saveData(
              PlanService,
              vm.plan,
              'muestreo/plan'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.plan.plan.id_status !== 2)
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
      if (!DateUtilsService.isValidDate(new Date(vm.sheet.fecha_muestreo)))
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
      console.log(vm.sheet);
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.sheet.id_hoja < 1)
        {
          RestUtilsService
            .saveData(
              SheetService,
              vm.sheet,
              'recepcion/hoja'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.sheet.sheet.id_status !== 2)
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
      if (vm.reception.id_muestra_validacion < 1)
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
              'recepcion/recepcion'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.reception.reception.id_status !== 2)
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
              'recepcion/custodia'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.custody.custody.id_status !== 2)
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


  //SampleListController.js
  /**
   * @name SampleListController
   * @constructor
   * @desc Controla la vista para el listado de Muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} SampleService - Proveedor de datos, Muestras
   */
  function SampleListController($location, SampleService) {
    var vm = this;
    vm.samples = SampleService.get();
    vm.viewSample = viewSample;

    function viewSample(id) {
      $location.path('/inventario/muestra/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('SampleListController',
      [
        '$location', 'SampleService',
        SampleListController
      ]
    );

  //InstrumentListController.js
  /**
   * @name InstrumentListController
   * @constructor
   * @desc Controla la vista para el listado de Equipos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} InstrumentService - Proveedor de datos, Equipos
   */
  function InstrumentListController(InstrumentService) {
    var vm = this;
    vm.clients = InstrumentService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('InstrumentListController',
      [
        'InstrumentService',
        InstrumentListController
      ]
    );

  //ReactiveListController.js
  /**
   * @name ReactiveListController
   * @constructor
   * @desc Controla la vista para el listado de Reactivos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReactiveService - Proveedor de datos, Reactivos
   */
  function ReactiveListController(ReactiveService) {
    var vm = this;
    vm.pricesList = ReactiveService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ReactiveListController',
      [
        'ReactiveService',
        ReactiveListController
      ]
    );

  //ContainerListController.js
  /**
   * @name ContainerListController
   * @constructor
   * @desc Controla la vista para el listado de Recipientes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   */
  function ContainerListController(ContainerService) {
    var vm = this;
    vm.pricesList = ContainerService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ContainerListController',
      [
        'ContainerService',
        ContainerListController
      ]
    );

  //AnalysisListController.js
  /**
   * @name AnalysisListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Análisis
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} AnalysisService - Proveedor de datos, Análisis
   */
  function AnalysisListController(AnalysisService) {
    var vm = this;
    vm.analysisList = AnalysisService.get();

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
        'AnalysisService',
        AnalysisListController
      ]
    );

  //AnalysisController.js
  /**
   * @name AnalysisController
   * @constructor
   * @desc Controla la vista para seleccionar captura de Análisis
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} DepartmentService - Proveedor de datos, Áreas
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} AnalysisService - Proveedor de datos, Análisis
   */
  function AnalysisController(DepartmentService, ParameterService,
    AnalysisService) {
    var vm = this;
    vm.areas = DepartmentService.get();
    vm.parameters = ParameterService.get();
    vm.analysis = AnalysisService.get();

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

  //ReportListController.js
  /**
   * @name ReportListController
   * @constructor
   * @desc Controla la vista para el listado de Reportes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReportService - Proveedor de datos, Reportes
   */
  function ReportListController(ReportService) {
    var vm = this;
    vm.pricesList = ReportService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ReportListController',
      [
        'ReportService',
        ReportListController
      ]
    );

  //ReportController.js
  /**
   * @name ReportController
   * @constructor
   * @desc Controla la vista para captura de Reporte
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} ReportService - Proveedor de datos, Reporte
   */
  function ReportController($routeParams, ReportService) {
    var vm = this;
    vm.report = ReportService.get();

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

  //PointListController.js
  /**
   * @name PointListController
   * @constructor
   * @desc Controla la vista para el listado de Puntos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PointService - Proveedor de datos, Puntos
   */
  function PointListController(PointService) {
    var vm = this;
    vm.points = PointService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('PointListController',
      [
        'PointService',
        PointListController
      ]
    );

  //ClientListController.js
  /**
   * @name ClientListController
   * @constructor
   * @desc Controla la vista para el listado de Clientes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ClientService - Proveedor de datos, Cliente
   */
  function ClientListController(ClientService) {
    var vm = this;
    vm.clients = ClientService.get();
    vm.selectRow = selectRow;

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      console.log(itemId);
    }
  }
  angular
    .module('sislabApp')
    .controller('ClientListController',
      [
        'ClientService',
        ClientListController
      ]
    );

  //DepartmentListController.js
  /**
   * @name DepartmentListController
   * @constructor
   * @desc Controla la vista para el listado de Áreas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} DepartmentService - Proveedor de datos, Áreas
   */
  function DepartmentListController(DepartmentService) {
    var vm = this;
    vm.departments = DepartmentService.get();
  }
  angular
    .module('sislabApp')
    .controller('DepartmentListController',
      [
        'DepartmentService',
        DepartmentListController
      ]
    );

  //EmployeeListController.js
  /**
   * @name EmployeeListController
   * @constructor
   * @desc Controla la vista para el listado de Empleados
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} EmployeeService - Proveedor de datos, Empleados
   */
  function EmployeeListController(EmployeeService) {
    var vm = this;
    vm.employees = EmployeeService.get();
  }
  angular
    .module('sislabApp')
    .controller('EmployeeListController',
      [
        'EmployeeService',
        EmployeeListController
      ]
    );

  //NormListController.js
  /**
   * @name NormListController
   * @constructor
   * @desc Controla la vista para el listado de Normas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} NormService - Proveedor de datos, Normas
   */
  function NormListController(NormService) {
    var vm = this;
    vm.clients = NormService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('NormListController',
      [
        'NormService',
        NormListController
      ]
    );

  //ReferenceListController.js
  /**
   * @name ReferenceListController
   * @constructor
   * @desc Controla la vista para el listado de Referencias
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReferenceService - Proveedor de datos, Referencias
   */
  function ReferenceListController(ReferenceService) {
    var vm = this;
    vm.ReferencesList = ReferenceService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ReferenceListController',
      [
        'ReferenceService',
        ReferenceListController
      ]
    );

  //MethodListController.js
  /**
   * @name MethodListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Métodos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} MethodService - Proveedor de datos, Métodos
   */
  function MethodListController(MethodService) {
    var vm = this;
    vm.methodsList = MethodService.get();

    vm.selectRow = selectRow;
    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('MethodListController',
      [
        'MethodService',
        MethodListController
      ]
    );

  //PriceListController.js
  /**
   * @name PriceListController
   * @constructor
   * @desc Controla la vista para el listado de Precios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PriceService - Proveedor de datos, Precios
   */
  function PriceListController(PriceService) {
    var vm = this;
    vm.pricesList = PriceService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('PriceListController',
      [
        'PriceService',
        PriceListController
      ]
    );

  //UserListController.js
  /**
   * @name UserListController
   * @constructor
   * @desc Controla la vista para el listado de Usuarios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} UserService - Proveedor de datos, Usuarios
   */
  function UserListController (UserService) {
    var vm = this;
    vm.users = UserService.get();
  }
  angular
    .module('sislabApp')
    .controller('UserListController',
      [
        'UserService',
        UserListController
      ]
    );

  //ProfileController.js
  /**
   * @name ProfileController
   * @constructor
   * @desc Controla la vista para Perfil
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} UserProfileService - Proveedor de datos, Perfil de usuario
   */
  function ProfileController(UserProfileService) {
    var vm = this;
    vm.profile = UserProfileService.get();
  }
  angular
    .module('sislabApp')
    .controller('ProfileController',
      [
        'UserProfileService',
        ProfileController
      ]
    );

  //LogoutController.js
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

  //ClientDetailController.js
  /**
   * @name ClientDetailController
   * @constructor
   * @desc Controla la vista para con el detalle de un Cliente
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ClientService - Proveedor de datos, Clientes
   */
  function ClientDetailController($scope, ClientService) {
    var vm = this;
    vm.clientDetail = ClientService.get();
  }
  angular
    .module('sislabApp')
    .controller('ClientDetailController',
      [
        '$scope',
        'ClientService',
        ClientListController
      ]
    );
