
/*global angular, CryptoJS*/
(function(window, document, undefined) {
  'use strict';
  //app.js
  //DATA API URL
  var API_BASE_URL = 'api/v1/';

  //ANGULAR MODULE SETTER
  angular
    .module('sislabApp', [
      'ngRoute',
      'ngResource',
      'ngAnimate',
      'angular-jwt',
      'mgcrea.ngStrap'
    ]
  );

  //config.js
  /**
   * @name config
   * @desc Configuración de AngularJS
   * @param {Object} $routeProvider - Proveedor, manejo de rutas de la applicación
   * @param {Object} $httpProvider - Proveedor, manejo de peticiones HTTP
   * @param {Object} jwtInterceptorProvider - Proveedor, intercepción de JWT
   * @param {Object} $collapseProvider - Proveedor, Angular-strap Collapse
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
        controller: 'TaskListController',
        controllerAs: 'tasks'
      }).
      when('/estudio/estudio', {
        templateUrl: 'partials/estudio/estudios.html',
        controller: 'StudyListController',
        controllerAs: 'studies'
      }).
      when('/estudio/estudio/:studyId', {
        templateUrl: 'partials/estudio/estudio.html',
        controller: 'StudyController',
        controllerAs: 'study'
      }).
      when('/muestreo/solicitud', {
        templateUrl: 'partials/muestreo/solicitudes.html',
        controller: 'QuoteListController',
        controllerAs: 'quotes'
      }).
      when('/muestreo/solicitud/:quoteId', {
        templateUrl: 'partials/muestreo/solicitud.html',
        controller: 'QuoteController',
        controllerAs: 'quote'
      }).
      when('/muestreo/orden', {
        templateUrl: 'partials/muestreo/ordenes.html',
        controller: 'OrderListController',
        controllerAs: 'orders'
      }).
      when('/muestreo/orden/:orderId', {
        templateUrl: 'partials/muestreo/orden.html',
        controller: 'OrderController',
        controllerAs: 'order'
      }).
      when('/muestreo/plan', {
        templateUrl: 'partials/muestreo/planes.html',
        controller: 'PlanListController',
        controllerAs: 'plans'
      }).
      when('/muestreo/plan/:planId', {
        templateUrl: 'partials/muestreo/plan.html',
        controller: 'PlanController',
        controllerAs: 'plan'
      }).
      when('/recepcion/hoja', {
        templateUrl: 'partials/recepcion/hojas.html',
        controller: 'SheetListController',
        controllerAs: 'sheets'
      }).
      when('/recepcion/hoja/:sheetId', {
        templateUrl: 'partials/recepcion/hoja.html',
        controller: 'SheetController',
        controllerAs: 'sheet'
      }).
      when('/recepcion/recepcion', {
        templateUrl: 'partials/recepcion/recepciones.html',
        controller: 'ReceptionListController',
        controllerAs: 'receptions'
      }).
      when('/recepcion/recepcion/:receptionId', {
        templateUrl: 'partials/recepcion/recepcion.html',
        controller: 'ReceptionController',
        controllerAs: 'reception'
      }).
      when('/recepcion/trabajo', {
        templateUrl: 'partials/recepcion/trabajos.html',
        controller: 'JobListController',
        controllerAs: 'jobs'
      }).
      when('/recepcion/trabajo/:jobId', {
        templateUrl: 'partials/recepcion/trabajo.html',
        controller: 'JobController',
        controllerAs: 'job'
      }).
      when('/recepcion/custodia', {
        templateUrl: 'partials/recepcion/custodias.html',
        controller: 'CustodyListController',
        controllerAs: 'custodies'
      }).
      when('/recepcion/custodia/:custodyId', {
        templateUrl: 'partials/recepcion/custodia.html',
        controller: 'CustodyController',
        controllerAs: 'custody'
      }).
      when('/analisis/fisico', {
        templateUrl: 'partials/analisis/fisicos.html',
        controller: 'PhysAnalysisListController',
        controllerAs: 'physAnalysisList'
      }).
      when('/analisis/metal', {
        templateUrl: 'partials/analisis/metales.html',
        controller: 'MetalAnalysisListController',
        controllerAs: 'metalAnalysisList'
      }).
      when('/analisis/biologico', {
        templateUrl: 'partials/analisis/biologicos.html',
        controller: 'BioAnalysisListController',
        controllerAs: 'bioAnalysisList'
      }).
      when('/analisis/fisico/:analysisId', {
        templateUrl: 'partials/analisis/fisico.html',
        controller: 'physAnalysisController',
        controllerAs: 'physAnalysis'
      }).
      when('/analisis/metal/:analysisId', {
        templateUrl: 'partials/analisis/metal.html',
        controller: 'metalAnalysisController',
        controllerAs: 'metalAnalysis'
      }).
      when('/analisis/biologico/:analysisId', {
        templateUrl: 'partials/analisis/biologico.html',
        controller: 'bioAnalysisController',
        controllerAs: 'bioAnalysis'
      }).
      when('/reporte/reporte', {
        templateUrl: 'partials/reporte/reportes.html',
        controller: 'ReportListController',
        controllerAs: 'reports'
      }).
      when('/reporte/reporte/:reportId', {
        templateUrl: 'partials/reporte/reporte.html',
        controller: 'ReportController',
        controllerAs: 'report'
      }).
      when('/inventario/muestra', {
        templateUrl: 'partials/inventario/muestras.html',
        controller: 'SampleListController',
        controllerAs: 'samples'
      }).
      when('/inventario/muestra/:sampleId', {
        templateUrl: 'partials/inventario/muestra.html',
        controller: 'SampleController',
        controllerAs: 'sample'
      }).
      when('/inventario/equipo', {
        templateUrl: 'partials/inventario/equipos.html',
        controller: 'InstrumentListController',
        controllerAs: 'instrumentsList'
      }).
      when('/inventario/reactivo', {
        templateUrl: 'partials/inventario/reactivos.html',
        controller: 'ReactiveListController',
        controllerAs: 'reactivesList'
      }).
      when('/inventario/recipiente', {
        templateUrl: 'partials/inventario/recipientes.html',
        controller: 'ContainerListController',
        controllerAs: 'containersList'
      }).
      when('/catalogo/punto', {
        templateUrl: 'partials/catalogo/puntos.html',
        controller: 'PointListController',
        controllerAs: 'pointsList'
      }).
      when('/catalogo/cliente', {
        templateUrl: 'partials/catalogo/clientes.html',
        controller: 'ClientListController',
        controllerAs: 'clients'
      }).
      when('/catalogo/cliente/:clientId', {
        templateUrl: 'partials/catalogo/cliente.html',
        controller: 'ClientDetailController',
        controllerAs: 'clientDetail'
      }).
      when('/catalogo/area', {
        templateUrl: 'partials/catalogo/areas.html',
        controller: 'AreaListController',
        controllerAs: 'areas'
      }).
      when('/catalogo/empleado', {
        templateUrl: 'partials/catalogo/empleados.html',
        controller: 'EmployeeListController',
        controllerAs: 'employeesList'
      }).
      when('/catalogo/norma', {
        templateUrl: 'partials/catalogo/normas.html',
        controller: 'NormListController',
        controllerAs: 'normsList'
      }).
      when('/catalogo/referencia', {
        templateUrl: 'partials/catalogo/referencia.html',
        controller: 'ReferenceListController',
        controllerAs: 'referencesList'
      }).
      when('/catalogo/metodo', {
        templateUrl: 'partials/catalogo/metodos.html',
        controller: 'MethodListController',
        controllerAs: 'methodsList'
      }).
      when('/catalogo/precio', {
        templateUrl: 'partials/catalogo/precios.html',
        controller: 'PriceListController',
        controllerAs: 'pricesList'
      }).
      when('/sistema/usuario', {
        templateUrl: 'partials/sistema/usuarios.html',
        controller: 'UserListController',
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
      })
    ;
    angular.extend($collapseProvider.defaults, {
      startCollapsed: true
    });
  }
  angular
    .module('sislabApp')
    .config(
      [
        '$routeProvider', '$httpProvider', 'jwtInterceptorProvider',
        '$collapseProvider',
        config
      ]
    );

  // DIRECTIVES
  //sislabMenu.js
  /**
   * @name sislabMenu
   * @desc Directiva para menú principal
   */
  function sislabMenu() {
    return {
      restrict: 'EA',
      require: '^ngModel',
      templateUrl: 'partials/sistema/menu.html',
      controller: 'MenuController',
      controllerAs: 'menu'
    };
  }
  angular
    .module('sislabApp')
    .directive('sislabMenu', sislabMenu);

  //sislabBanner.js
  /**
   * @name sislabBanner
   * @desc Directiva para banner superior
   */
  function sislabBanner() {
    return {
      restrict: 'EA',
      templateUrl: 'partials/sistema/banner.html'
    };
  }
  angular
    .module('sislabApp')
    .directive('sislabBanner', sislabBanner);

  //sislabFooter.js
  /**
   * @name sislabFooter
   * @desc Directiva para pie de página
   */
  function sislabFooter() {
    return {
      restrict: 'EA',
      templateUrl: 'partials/sistema/footer.html'
    };
  }
  angular
    .module('sislabApp')
    .directive('sislabFooter', sislabFooter);

  //sislabBannerBottom.js
  /**
   * @name sislabBannerBottom
   * @desc Directiva para banner inferior
   */
  function sislabBannerBottom() {
    return {
      restrict: 'EA',
      templateUrl: 'partials/sistema/banner-bottom.html'
    };
  }
  angular
    .module('sislabApp')
    .directive('sislabBannerBottom', sislabBannerBottom);

  //CONTROLLERS
  //LoginController.js
  /**
   * @name LoginController
   * @constructor
   * @desc Controla la vista para Login
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $http - Manejo de peticiones HTTP
   * @param {Object} $location - Manejo de URL
   * @param {Object} TokenService - Proveedor para manejo del token
   */
  function LoginController($scope, TokenService) {
    var vm = this;
    vm.message = '';
    vm.user = {username: '', password: ''};
    vm.submitForm = submitForm;

    function submitForm() {
      vm.message = '';
      if (!$scope.loginForm.$valid) {
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} TaskService - Proveedor de datos, Tareas
   */
  function TaskListController(TokenService, TaskService) {
    var vm = this;
    var userData;
    vm.userName = '';
    vm.tasks = {};
    if (TokenService.isAuthenticated()) {
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $window - Acceso a Objeto Window
   * @param {Object} $location - Manejo de URL
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudyListController($window, $location, TokenService,
    RestUtilsService, StudyService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.studies = StudyService.get();
    vm.addStudy = addStudy;
    vm.removeStudy = removeStudy;
    vm.viewStudy = viewStudy;

    function addStudy() {
      $location.path('/estudio/estudio/0');
    }

    function removeStudy(item) {
      if (vm.user.level < 3 && item.id_status != 2) {
        item.activo = 0;
        RestUtilsService
          .updateData(
            StudyService,
            item,
            'estudio/estudio',
            'id_estudio'
          );
        $window.location.reload();
      }
    }

    function viewStudy(id) {
      $location.path('/estudio/estudio/' + parseInt(id, 10));
    }
  }
  angular
    .module('sislabApp')
    .controller('StudyListController',
      [
        '$window', '$location', 'TokenService',
        'RestUtilsService', 'StudyService',
        StudyListController
      ]
    );

  //StudyController.js
  /**
   * @name StudyController
   * @constructor
   * @desc Controla la vista para capturar un Estudio
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
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
   * @param {Object} LocationService -  Proveedor de datos, Ubicación
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudyController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, ClientService, MatrixService,
    SamplingTypeService, NormService, OrderSourceService,
    LocationService, StudyService) {
    var vm = this;
    vm.study = StudyService.query({studyId: $routeParams.studyId});
    vm.user = TokenService.getUserFromToken();
    vm.clients = ClientService.get();
    vm.matrices = MatrixService.get();
    vm.samplingTypes = SamplingTypeService.get();
    vm.norms = NormService.get();
    vm.orderSources = OrderSourceService.get();
    vm.locations = LocationService.get();
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
        'tipo_cuerpo':'', 'fecha':null,
        'fecha_captura':null, 'fecha_valida':null,
        'fecha_actualiza':null, 'fecha_rechaza':null,
        'ip_captura':'', 'ip_valida':'',
        'ip_actualiza':'', 'host_captura':'',
        'host_valida':'', 'host_actualiza':'',
        'motivo_rechaza':'', 'comentarios':'',
        'activo':1
      });
    }

    function removeOrder(event) {
      var field = '$$hashKey';
      ArrayUtilsService.extractItemFromCollection(
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
      var i = 0;
      var l = 0;
      var orders = [];
      if (vm.study.ordenes && vm.study.ordenes.length > 0) {
        orders = vm.study.ordenes;
        l = orders.length;
        for (i = 0; i < l; i += 1) {
          if (orders[i].id_matriz < 1) {
            vm.message += ' Seleccione una matriz, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (isNaN(orders[i].cantidad_muestras) || orders[i].cantidad_muestras < 1) {
            vm.message += ' Ingrese cantidad de muestras, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (orders[i].id_tipo_muestreo < 1) {
            vm.message += ' Seleccione un tipo de muestreo, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (orders[i].id_norma < 1) {
            vm.message += ' Seleccione una norma, para la orden ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      } else {
        vm.message += ' Agregue una orden ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (!DateUtilsService.isValidDate(new Date(vm.study.fecha))) {
        vm.message += ' Ingrese una fecha válida ';
        return false;
      }
      if (vm.study.id_cliente < 1) {
        vm.message += ' Seleccione un cliente ';
        return false;
      }
      if (!isOrderListValid()) {
        return isOrderListValid();
      }
      if (vm.study.id_origen_orden < 1) {
        vm.message += ' Seleccione un medio de orden de muestreo ';
        return false;
      }
      if (vm.study.id_origen_orden == 1 || vm.study.id_origen_orden == 4) {
        if (vm.study.origen_descripcion.length < 1) {
          vm.message += ' Ingrese oficio o emergencia ';
          return false;
        }
      }
      if (vm.study.ubicacion.length < 1) {
        vm.message += ' Ingrese una ubicación ';
        return false;
      }
      if (vm.user.level < 3) {
        if (vm.study.id_status == 3 && vm.study.motivo_rechaza.length < 1) {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted) {
        vm.isDataSubmitted = true;
        if (vm.study.id_estudio < 1) {
          //vm.study.$save();
          RestUtilsService
            .saveData(
              StudyService,
              vm.study,
              'estudio/estudio'
            );
        } else {
          if (vm.user.level < 3 || vm.study.id_status != 2) {
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
        'LocationService', 'StudyService',
        StudyController
      ]
    );

  //OrderListController.js
  /**
   * @name OrderListController
   * @constructor
   * @desc Controla la vista para el listado de Órdenes muestreo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} OrderService - Proveedor de datos, Órdenes de muestreo
   */
  function OrderListController($location, OrderService) {
    var vm = this;
    vm.orders = OrderService.get();
    vm.viewOrder = viewOrder;

    function viewOrder(id) {
      $location.path('/muestreo/orden/' + parseInt(id, 10));
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

  //OrderController.js
  /**
   * @name OrderController
   * @constructor
   * @desc Controla la vista para capturar una Orden de muestreo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} StudyService - Proveedor de datos, Estudios
   * @param {Object} WaterBodyService - Proveedor de datos, Cuerpo de agua
   * @param {Object} LocationService - Proveedor de datos, Ubicación
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes de orden
   * @param {Object} LocationPackagesService - Proveedor de datos, Paquetes por Ubicación
   * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores de muestreo
   * @param {Object} OrderService - Proveedor de datos, Órdenes de muestreo
   */
  function OrderController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, StudyService, WaterBodyService,
    LocationService, OrderSourceService, LocationPackagesService,
    SamplingSupervisorService, OrderService) {
    var vm = this;
    vm.order = {};
    vm.study = {};
    vm.location = '';
    vm.source = '';
    vm.user = TokenService.getUserFromToken();
    vm.supervisors = SamplingSupervisorService.get();
    vm.bodies = WaterBodyService.get();
    vm.packages = [];

    vm.message = '';
    vm.isDataSubmitted = false;
    vm.getScope = getScope;
    vm.addPlan = addPlan;
    vm.removePlan = removePlan;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;
    OrderService
      .query({orderId: $routeParams.orderId})
      .$promise
      .then(function success(response) {
        vm.order = response;
        StudyService
          .query({studyId: vm.order.id_estudio})
          .$promise
          .then(function success(response) {
            vm.study = response;
            LocationService
              .query({locationId: vm.study.id_ubicacion})
              .$promise
              .then(function success(response) {
                vm.location = response.ubicacion;
              });
            OrderSourceService
              .query({sourceId: vm.study.id_origen_orden})
              .$promise
              .then(function success(response) {
                vm.source = response.origen_orden;
              });
            LocationPackagesService
              .query({locationId: vm.study.id_ubicacion})
              .$promise
              .then(function success(response) {
                vm.packages = response;
              });
          });
      });

    function getScope() {
      return vm;
    }

    function addPlan() {
      var blankPlan = {
        'id_plan': 0,
        'id_estudio': vm.order.id_estudio,
        'id_orden': vm.order.id_orden, 'id_ubicacion': 1,
        'id_paquete': 1, 'id_objetivo_plan': 1,
        'id_norma_muestreo': 1, 'id_estado': 14,
        'id_municipio': 14001, 'id_localidad': 1400100001,
        'id_supervisor_muestreo': 13,
        'id_supervisor_entrega': 13, 'id_supervisor_recoleccion': 13,
        'id_supervisor_registro': 13, 'id_ayudante_entrega': 13,
        'id_ayudante_recoleccion': 13, 'id_ayudante_registro': 13,
        'id_responsable_calibracion': 13,
        'id_responsable_recipientes': 13,
        'id_responsable_reactivos': 13, 'id_responsable_material': 13,
        'id_responsable_hieleras': 13, 'id_status': 1,
        'id_usuario_captura': 0, 'id_usuario_valida': 0,
        'id_usuario_actualiza': 0, 'fecha': null,
        'fecha_probable': null, 'fecha_calibracion': null,
        'fecha_captura': null, 'fecha_valida': null,
        'fecha_actualiza': null, 'fecha_rechaza': null,
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
      };
      if (vm.order.planes) {
        vm.order.planes.push(blankPlan);
      } else {
        vm.order.planes = [blankPlan];
      }
    }

    function removePlan(event) {
      var field = '$$hashKey';
      return ArrayUtilsService.extractItemFromCollection(
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
      var i = 0;
      var l = 0;
      var plans = [];
      if (vm.order.planes && vm.order.planes.length > 0) {
        plans = vm.order.planes;
        l = plans.length;
        for (i = 0; i < l; i += 1) {
          if (!plans[i].id_paquete) {
            vm.message = ' No hay Paquete de puntos ';
            return false;
          }
          if (plans[i].id_paquete < 1) {
            vm.message = ' Seleccione un Paquete de puntos ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (plans[i].id_supervisor_muestreo < 1) {
            vm.message = ' Seleccione un Responsable de muestreo ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (!DateUtilsService.isValidDate(new Date(plans[i].fecha_probable))) {
            vm.message = ' Ingrese fecha y hora válidas ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      } else {
        vm.message += ' Agregue un plan ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (!isPlanListValid()) {
        return isPlanListValid();
      }
      if (vm.user.level < 3) {
        if (vm.order.id_status == 3 && vm.order.motivo_rechaza.length < 1) {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted) {
        if (vm.order.id_orden > 0) {
          RestUtilsService
            .saveData(
              OrderService,
              vm.order,
              'muestreo/orden'
            );
        } else {
          if (vm.user.level < 3 || vm.order.id_status !== 2) {
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
        'DateUtilsService', 'StudyService', 'WaterBodyService',
        'LocationService', 'OrderSourceService',
        'LocationPackagesService', 'SamplingSupervisorService',
        'OrderService',
        OrderController
      ]
    );

  //PlanListController.js
  /**
   * @name PlanListController
   * @constructor
   * @desc Controla la vista para el listado de Planes de muestreo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} PlanService - Proveedor de datos, Planes de muestreo
   */
  function PlanListController($location, PlanService) {
    var vm = this;
    vm.plans = PlanService.get();
    vm.viewPlan = viewPlan;

    function viewPlan(id) {
      $location.path('/muestreo/plan/' + parseInt(id, 10));
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

  //PlanController.js
  /**
   * @name PlanController
   * @constructor
   * @desc Controla la vista para capturar un Plan de muestreo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} StudyService - Proveedor de datos, Estudios
   * @param {Object} LocationService - Proveedor de datos, Ubicación
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes de orden
   * @param {Object} PlanObjectiveService - Proveedor de datos, Objetivos Plan
   * @param {Object} DistrictService - Proveedor de datos, Municipios
   * @param {Object} CityService - Proveedor de datos, Localidades
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} ReactiveService - Proveedor de datos, Reactivos
   * @param {Object} MaterialService - Proveedor de datos, Material
   * @param {Object} CoolerService - Proveedor de datos, Hieleras
   * @param {Object} SamplingInstrumentService - Proveedor de datos, Equipos muestreo
   * @param {Object} PlanService - Proveedor de datos, Plan de muestreo
   */
  function PlanController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, StudyService, LocationService,
    OrderSourceService, PlanObjectiveService, DistrictService,
    CityService, SamplingEmployeeService, PreservationService,
    ReactiveService, MaterialService, CoolerService,
    SamplingInstrumentService, PlanService) {
    var vm = this;
    vm.plan = {};
    vm.study = {};
    vm.user = TokenService.getUserFromToken();
    vm.objectives = PlanObjectiveService.get();
    vm.cities = [];
    vm.districts = [];
    vm.samplingEmployees = SamplingEmployeeService.get();
    vm.instruments = [];
    vm.preservations = [];
    vm.reactives = [];
    vm.materials = [];
    vm.coolers = [];
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.isInstrumentListLoaded = false;
    vm.isPreservationListLoaded = false;
    vm.isContainerListLoaded = false;
    vm.isReactiveListLoaded = false;
    vm.isMaterialListLoaded = false;
    vm.isCoolerListLoaded = false;
    vm.isAllMaterialsListSelected = false;
    vm.selectDistrict = selectDistrict;
    vm.selectInstruments = selectInstruments;
    vm.selectPreservations = selectPreservations;
    vm.selectReactives = selectReactives;
    vm.selectMaterials = selectMaterials;
    vm.selectCoolers = selectCoolers;
    vm.selectAllMaterials = selectAllMaterials;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;

    PlanService
      .query({planId: $routeParams.planId})
      .$promise
      .then(function success(response) {
        vm.plan = response;
        LocationService
          .query({locationId: vm.plan.id_ubicacion})
          .$promise
          .then(function success(response) {
            vm.location = response.ubicacion;
          });
        StudyService
          .query({studyId: vm.plan.id_estudio})
          .$promise
            .then(function success(response) {
              vm.study = response;
              OrderSourceService
                .query({sourceId: vm.study.id_origen_orden})
                .$promise
                .then(function success(response) {
                  vm.source = response.origen_orden;
                });
            });
        DistrictService
          .get()
          .$promise
          .then(function success(response) {
            vm.districts = response;
            if (vm.plan.id_municipio && vm.plan.id_municipio > 0) {
              ArrayUtilsService.selectItemFromCollection(
                vm.districts,
                'id_municipio',
                parseInt(vm.plan.id_municipio, 10)
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
                    parseInt(vm.plan.id_localidad, 10)
                  );
                }
              });
          });
        SamplingInstrumentService
          .get()
          .$promise
          .then(function success(response) {
            var i = 0;
            var l = 0;
            vm.instruments = response;
            vm.isInstrumentListLoaded = true;
            l = vm.instruments.length;
            for (i = 0; i < l; i += 1) {
              vm.instruments[i].id_plan_instrumento = 0;
              vm.instruments[i].id_plan = vm.plan.id_plan;
              vm.instruments[i].bitacora = '';
              vm.instruments[i].folio = '';
              vm.instruments[i].selected = false;
            }
            ArrayUtilsService.seItemsFromReference(
              vm.instruments,
              vm.plan.instrumentos,
              'id_instrumento',
              [
                'id_plan_instrumento',
                'bitacora',
                'folio',
                'selected'
              ]
            );
          });
        PreservationService
          .get()
          .$promise
          .then(function success(response) {
            var i;
            var l;
            vm.preservations = response;
            vm.isPreservationListLoaded = true;
            l = vm.preservations.length;
            for (i = 0; i < l; i += 1) {
              vm.preservations[i].id_plan_preservacion = 0;
              vm.preservations[i].id_plan = vm.plan.id_plan;
              vm.preservations[i].selected = false;
            }
            ArrayUtilsService.seItemsFromReference(
              vm.preservations,
              vm.plan.preservaciones,
              'id_preservacion',
              [
                'id_plan_preservacion',
                'id_plan',
                'id_preservacion',
                'selected'
              ]
            );
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
              vm.reactives[i].id_plan_reactivo = 0;
              vm.reactives[i].id_plan = vm.plan.id_plan;
            }
            ArrayUtilsService.seItemsFromReference(
              vm.reactives,
              vm.plan.reactivos,
              'id_reactivo',
              [
                'id_plan_reactivo',
                'id_plan',
                'lote',
                'folio',
                'valor',
                'selected'
              ]
            );
          });
        MaterialService
          .get()
          .$promise
          .then(function success(response) {
            var i;
            var l;
            vm.materials = response;
            l = vm.materials.length;
            for (i = 0; i < l; i += 1) {
              vm.materials[i].id_plan_material = 0;
              vm.materials[i].id_plan = vm.plan.id_plan;
            }
            ArrayUtilsService.seItemsFromReference(
              vm.materials,
              vm.plan.materiales,
              'id_material',
              [
                'id_plan_material',
                'id_plan',
                'selected'
              ]
            );
          });
        CoolerService
          .get()
          .$promise
          .then(function success(response) {
            var i;
            var l;
            vm.coolers = response;
            l = vm.coolers.length;
            for (i = 0; i < l; i += 1) {
              vm.coolers[i].id_plan_hielera = 0;
              vm.coolers[i].id_plan = vm.plan.id_plan;
            }
            ArrayUtilsService.seItemsFromReference(
              vm.coolers,
              vm.plan.hieleras,
              'id_hielera',
              [
                'id_plan_hielera',
                'id_plan',
                'selected'
              ]
            );
          });
      });

    function selectDistrict() {
      vm.cities = CityService.query({
        districtId: parseInt(vm.plan.id_municipio, 10)
      });
    }

    function selectInstruments() {
      if (vm.isInstrumentListLoaded) {
        vm.plan.instrumentos = [];
        vm.plan.instrumentos = ArrayUtilsService.selectItemsFromCollection(
          vm.instruments,
          'selected',
          true
        ).slice();
      }
    }

    function selectPreservations() {
      if (vm.isPreservationListLoaded) {
        vm.plan.preservaciones = [];
        vm.plan.preservaciones = ArrayUtilsService.selectItemsFromCollection(
          vm.preservations,
          'selected',
          true
        ).slice();
      }
    }

    function selectReactives() {
      if (vm.reactives.length > 0 && vm.plan.reactivos) {
        if (vm.plan.reactivos.length > 0 && !vm.isReactiveListLoaded) {
          ArrayUtilsService.seItemsFromReference(
            vm.reactives,
            vm.plan.reactivos,
            'id_reactivo',
            [
              'id_plan_reactivo',
              'id_plan',
              'lote',
              'folio',
              'valor',
              'selected'
            ]
          );
          vm.isReactiveListLoaded = true;
        } else {
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
      if (vm.materials.length > 0 && vm.plan.materiales) {
        if (vm.plan.materiales.length > 0 && !vm.isMaterialListLoaded) {
          ArrayUtilsService.seItemsFromReference(
            vm.materials,
            vm.plan.materiales,
            'id_material',
            [
              'id_plan_material',
              'id_plan',
              'selected'
            ]
          );
          vm.isMaterialListLoaded = true;
        } else {
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
      if (vm.coolers.length > 0 && vm.plan.hieleras) {
        if (vm.plan.hieleras.length > 0 && !vm.isCoolerListLoaded) {
          ArrayUtilsService.seItemsFromReference(
            vm.coolers,
            vm.plan.hieleras,
            'id_hielera',
            [
              'id_plan_hielera',
              'id_plan',
              'selected'
            ]
          );
          vm.isCoolerListLoaded = true;
        } else {
          vm.plan.hieleras = [];
          vm.plan.hieleras = ArrayUtilsService.selectItemsFromCollection(
            vm.coolers,
            'selected',
            true
          ).slice();
        }
      }
    }

    function selectAllMaterials() {
      var i = 0;
      var l = 0;
      if (vm.materials && vm.materials.length > 0) {
        l = vm.materials.length;
        vm.isAllMaterialsListSelected = !vm.isAllMaterialsListSelected;
        for (i = 0; i < l; i += 1) {
          vm.materials[i].selected = vm.isAllMaterialsListSelected;
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
      var i = 0;
      var l = vm.plan.instrumentos.length;
      var instrument = {};
      if (vm.plan.id_responsable_calibracion < 1) {
        vm.message += ' Seleccione una Responsable de calibración ';
        return false;
      }
      if (!DateUtilsService.isValidDate(new Date(vm.plan.fecha_calibracion))) {
        vm.message += ' Ingrese una fecha válida de calibración ';
        return false;
      }
      if (vm.plan.instrumentos.length < 1) {
        vm.message += ' Seleccione al menos un instrumento ';
        return false;
      } else {
        for (i = 0; i < l; i += 1) {
          instrument = vm.plan.instrumentos[i];
          if (instrument.bitacora.length < 1) {
            vm.message += ' Ingrese la bitácora del equipo ';
            vm.message += '' + instrument.inventario;
            return false;
          }
          if (instrument.folio.length < 1) {
            vm.message += ' Ingrese el folio del equipo ';
            vm.message += '' + instrument.inventario;
            return false;
          }
        }
      }
      return true;
    }

    function isContainerListValid() {
      var i = 0;
      var l = 0;
      var containers = [];
      if (vm.plan.id_responsable_recipientes < 1) {
        vm.message += ' Seleccione un Responsable de preparación de recipientes ';
        return false;
      }
      if (vm.plan.recipientes && vm.plan.recipientes.length > 0) {
        containers = vm.plan.recipientes;
        l = containers.length;
        for (i = 0; i < l; i += 1) {
          if (isNaN(containers[i].cantidad) || containers[i].cantidad < 1) {
            vm.message += ' Ingrese cantidad de recipientes, para la preservación ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      } else {
        vm.message += ' Seleccione un recipiente ';
        return false;
      }
      return true;
    }

    function isReactiveListValid() {
      var i = 0;
      var l = 0;
      var reactives = [];
      if (vm.plan.id_responsable_reactivos < 1) {
        vm.message += ' Seleccione una Responsable de reactivos ';
        return false;
      }
      if (vm.plan.reactivos && vm.plan.reactivos.length > 0) {
        reactives = vm.plan.reactivos;
        l = reactives.length;
        for (i = 0; i < l; i += 1) {
          if (isNaN(reactives[i].cantidad) || reactives[i].cantidad < 1) {
            vm.message += ' Ingrese cantidad, para el reactivo ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (isNaN(reactives[i].lote) || reactives[i].lote < 1) {
            vm.message += ' Ingrese lote, para el reactivo ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      } else {
        vm.message += ' Seleccione un recipiente ';
        return false;
      }
      return true;
    }

    function isMaterialListValid() {
      if (vm.plan.id_responsable_material < 1) {
        vm.message += ' Seleccione una Responsable de preparación de material ';
        return false;
      }
      if (vm.plan.materiales.length < 1) {
        vm.message += ' Seleccione los materiales y equipos ';
        return false;
      }
      return true;
    }

    function isCoolerListValid() {
      if (vm.plan.id_responsable_hieleras < 1) {
        vm.message += ' Seleccione una Responsable de hieleras ';
        return false;
      }
      if (vm.plan.hieleras.length < 1) {
        vm.message += ' Seleccione hieleras ';
        return false;
      }
      return true;
    }

    function isGeneralDataValid() {
      if (vm.plan.id_objetivo_plan < 1) {
        vm.message += ' Seleccione un objetivo ';
        return false;
      }
      if (vm.plan.id_objetivo_plan == 5 && vm.plan.objetivo_otro.length < 1) {
        vm.message += ' Si selecciona otro objetivo debe ingresarlo ';
        return false;
      }
      if (!DateUtilsService.isValidDate(new Date(vm.plan.fecha))) {
        vm.message += ' Ingrese una fecha válida de muestreo ';
        return false;
      }
      if (vm.plan.orden.id_tipo_muestreo > 1) {
        if (isNaN(vm.plan.frecuencia) || vm.plan.frecuencia < 1) {
          vm.message += ' Seleccione una frecuencia de muestreo ';
          return false;
        }
      }
      if (vm.plan.calle.length < 1) {
        vm.message += ' Ingrese una calle o ubicación aproximada ';
        return false;
      }
      if (vm.plan.id_municipio < 1) {
        vm.message += ' Seleccione un municipio ';
        return false;
      }
      if (vm.plan.id_localidad < 1) {
        vm.message += ' Seleccione una localidad ';
        return false;
      }
      return true;
    }

    function isSupervisorListValid() {
      if (vm.plan.id_supervisor_entrega < 1) {
        vm.message += ' Seleccione un Responsable de muestreo ';
        return false;
      }
      if (vm.plan.id_ayudante_entrega < 1) {
        vm.message += ' Seleccione una Acompañante de muestreo ';
        return false;
      }
      if (vm.plan.id_supervisor_recolecion < 1) {
        vm.message += ' Seleccione un Responsable de recolección ';
        return false;
      }
      if (vm.plan.id_ayudante_recolecion < 1) {
        vm.message += ' Seleccione una Acompañante de recolección ';
        return false;
      }
      if (vm.plan.id_supervisor_registro < 1) {
        vm.message += ' Seleccione un Responsable de registro de resultados ';
        return false;
      }
      if (vm.plan.id_ayudante_registro < 1) {
        vm.message += ' Seleccione una Acompañante de registro de resultados ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (!isGeneralDataValid()) {
        return false;
      }
      if (!isSupervisorListValid()) {
        return false;
      }
      if (!isInstrumentListValid) {
        return false;
      }
      if (!isContainerListValid) {
        return false;
      }
      if (!isReactiveListValid) {
        return false;
      }
      if (!isCoolerListValid) {
        return false;
      }
      if (vm.user.level < 3) {
        if (vm.plan.id_status == 3 && vm.plan.motivo_rechaza.length < 1) {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted) {
        vm.isDataSubmitted = true;
        if (vm.plan.id_estudio > 0) {
          RestUtilsService
            .saveData(
              PlanService,
              vm.plan,
              'muestreo/plan'
            );
        } else {
          if (vm.user.level < 3 || vm.plan.id_status !== 2) {
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
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'StudyService', 'LocationService',
        'OrderSourceService', 'PlanObjectiveService', 'DistrictService',
        'CityService', 'SamplingEmployeeService', 'PreservationService',
        'ReactiveService', 'MaterialService', 'CoolerService',
        'SamplingInstrumentService', 'PlanService',
        PlanController
      ]
    );

  //SheetListController.js
  /**
   * @name SheetListController
   * @constructor
   * @desc Controla la vista para el listado de Hojas de campo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} SheetService - Proveedor de datos, Hoja de campo
   */
  function SheetListController($location, SheetService) {
    var vm = this;
    vm.sheets = SheetService.get();
    vm.viewSheet = viewSheet;

    function viewSheet(id) {
      $location.path('/recepcion/hoja/' + parseInt(id, 10));
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

  //SheetController.js
  /**
   * @name SheetController
   * @constructor
   * @desc Controla la vista para capturar la hoja de campo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} CloudService - Proveedor de datos, Cobertura nubes
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
    vm.sheet = {};
    vm.cloudCovers = CloudService.get();
    vm.windDirections = WindService.get();
    vm.waveIntensities = WaveService.get();
    vm.samplingNorms = SamplingNormService.get();
    vm.preservations = [];
    vm.message = '';
    vm.isPreservationListLoaded = false;
    vm.isDataSubmitted = false;
    vm.selectPreservations = selectPreservations;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;

    SheetService
      .query({sheetId: $routeParams.sheetId})
      .$promise
      .then(function success(response) {
        vm.sheet = response;
        PreservationService
          .get()
          .$promise
          .then(function success(response) {
            var i;
            var l;
            vm.preservations = response;
            l = vm.preservations.length;
            for (i = 0; i < l; i += 1) {
              vm.preservations[i].id_hoja_preservacion = 0;
              vm.preservations[i].id_hoja = vm.sheet.id_hoja;
              vm.preservations[i].cantidad = 0;
              vm.preservations[i].preservado = 0;
              vm.preservations[i].activo = 0;
              vm.preservations[i].selected = false;
            }
          });
      });

    function selectPreservations() {
      if (vm.preservations.length > 0 && vm.sheet.preservaciones) {
        if (vm.sheet.preservaciones.length > 0 && !vm.isPreservationListLoaded) {
          ArrayUtilsService.seItemsFromReference(
            vm.preservations,
            vm.sheet.preservaciones,
            'id_preservacion',
            [
              'id_hoja_preservacion',
              'id_hoja',
              'cantidad',
              'preservado',
              'activo',
              'selected'
            ]
          );
          vm.isPreservationListLoaded = true;
        } else {
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
      var i = 0;
      var l = 0;
      var results = sampleResults.slice();
      l = results.length;
      for (i = 0; i < l; i += 1) {
        if (results[i].valor.length > 0) {
          if (results[i].id_tipo_valor == 1 && isNaN(results[i].valor)) {
            vm.message += ' Ingrese un valor numérico para el parámetro ';
            vm.message += results[i].param + ' ';
            vm.message += ' (' + sample.punto.punto + ')';
            return false;
          }
          if (results[i].id_tipo_valor == 2 && results[i].valor.length < 2) {
            vm.message += ' Ingrese un valor para el parámetro ';
            vm.message += results[i].param + ' ';
            vm.message += ' (' + sample.punto.punto + ')';
            return false;
          }
        }
      }
      return true;
    }

    function isSampleListValid() {
      var i = 0;
      var l = 0;
      var samples = [];
      if (vm.sheet.muestras && vm.sheet.muestras.length > 0) {
        samples = vm.sheet.muestras;
        l = samples.length;
        for (i = 0; i < l; i += 1) {
          if (!DateUtilsService.isValidDate(samples[i].fecha_muestreo)) {
            vm.message += ' Ingrese una fecha/hora válida para la muestra en ';
            vm.message += samples[i].punto.punto + ' ';
            vm.message += ' (Ver fila ' + (i + 1) + ')';
            return false;
          }
          samples[i].fecha_muestreo = new Date(samples[i].fecha_muestreo);
          if (!isResultListValid(samples[i], samples[i].resultados)) {
            return false;
          }
        }
      } else {
        vm.message += ' Sin muestras ';
        return false;
      }
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (!DateUtilsService.isValidDate(vm.sheet.fecha_muestreo)) {
        vm.message += ' Ingrese una fecha/hora de muestreo válida ';
        return false;
      }
      vm.sheet.fecha_muestreo = DateUtilsService.dateToIso(
        new Date(vm.sheet.fecha_muestreo)
      );
      if (!DateUtilsService.isValidDate(vm.sheet.fecha_entrega)) {
        vm.message += ' Ingrese una fecha/hora de entrega válida ';
        return false;
      }
      vm.sheet.fecha_muestreo = DateUtilsService.dateToIso(
        new Date(vm.sheet.fecha_entrega)
      );
      if (!isSampleListValid()) {
        return false;
      }
      if (vm.sheet.id_nube < 1) {
        vm.message += ' Seleccione una cobertura de nubes ';
        return false;
      }
      if (vm.sheet.id_direccion_corriente < 1) {
        vm.message += ' Seleccione una dirección de corriente ';
        return false;
      }
      if (vm.sheet.id_oleaje < 1) {
        vm.message += ' Seleccione una intensidad del oleaje ';
        return false;
      }
      if (vm.sheet.preservaciones.length < 1) {
        vm.message += ' Seleccione al menos un tipo de preservación ';
        return false;
      }
      if (vm.user.level < 3) {
        if (vm.sheet.id_status == 3 && vm.sheet.motivo_rechaza.length < 1) {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted) {
        vm.isDataSubmitted = true;
        if (vm.sheet.id_hoja < 1) {
          RestUtilsService
            .saveData(
              SheetService,
              vm.sheet,
              'recepcion/hoja'
            );
        } else {
          if (vm.user.level < 3 || vm.sheet.id_status !== 2) {
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
   */
  function ReceptionListController($location, ReceptionService) {
    var vm = this;
    vm.receptions = ReceptionService.get();
    vm.viewReception = viewReception;

    function viewReception(id) {
      $location.path('/recepcion/recepcion/' + parseInt(id, 10));
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

  //ReceptionController.js
  /**
   * @name ReceptionController
   * @constructor
   * @desc Controla la vista para capturar la recepción de muestras
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} SheetSampleService - Proveedor de datos, Muestras por Hoja de campo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} ReceivingAreaService - Proveedor de datos, Áreas receptoras
   * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
   */
  function ReceptionController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, SamplingEmployeeService, SheetSampleService,
    PreservationService, ReceivingAreaService, ReceptionService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.reception = {};
    vm.receptionists = SamplingEmployeeService.get();
    vm.samples = [];
    vm.preservations = [];
    vm.areas = [];
    vm.jobs = [];
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.selectPreservations = selectPreservations;
    vm.selectAreas = selectAreas;
    vm.selectJobs = selectJobs;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;

    ReceptionService
      .query({receptionId: $routeParams.receptionId})
      .$promise
      .then(function success(response) {
        vm.reception = response;
        SheetSampleService
          .query({sheetId: vm.reception.id_hoja})
          .$promise
          .then(function success(response) {
            var i = 0;
            var l = 0;
            vm.samples = response;
            l = vm.samples.length;
            for (i = 0; i < l; i += 1) {
              vm.samples[i].id_recepcion = $routeParams.receptionId;
              vm.samples[i].selected = false;
              vm.samples[i].punto = {};
            }
            ArrayUtilsService.seItemsFromReference(
              vm.samples,
              vm.reception.muestras,
              'id_muestra',
              [
                'id_recepcion_muestra',
                'id_recepcion',
                'punto',
                'selected'
              ]
            );
          });
        PreservationService
          .get()
          .$promise
          .then(function success(response) {
            var i = 0;
            var l = 0;
            vm.preservations = response;
            l = vm.preservations.length;
            for (i = 0; i < l; i += 1) {
              vm.preservations[i].id_recepcion_preservacion = 0;
              vm.preservations[i].id_recepcion = vm.reception.id_recepcion;
              vm.preservations[i].cantidad = 0;
              vm.preservations[i].activo = 0;
              vm.preservations[i].selected = false;
            }
            ArrayUtilsService.seItemsFromReference(
              vm.preservations,
              vm.reception.preservaciones,
              'id_preservacion',
              [
                'id_recepcion_preservacion',
                'id_recepcion',
                'cantidad',
                'activo',
                'selected'
              ]
            );
          });
        ReceivingAreaService
          .get()
          .$promise
          .then(function success(response) {
            var i = 0;
            var l = 0;
            vm.areas = response;
            l = vm.areas.length;
            for (i = 0; i < l; i += 1) {
              vm.areas[i].id_recepcion_area = 0;
              vm.areas[i].id_recepcion = vm.reception.id_recepcion;
              vm.areas[i].id_muestra = 0;
              vm.areas[i].volumen = false;
              vm.areas[i].vigencia = false;
              vm.areas[i].recipiente = false;
              vm.areas[i].activo = 0;
              vm.jobs[i] = {
                id_recepcion_trabajo: 0,
                id_recepcion: vm.reception.id_recepcion,
                id_trabajo: 0,
                id_area: vm.areas[i].id_area,
                area: vm.areas[i].area,
                fecha_entrega: null,
                activo: 0,
                selected: false
              };
            }
            ArrayUtilsService.seItemsFromReference(
              vm.areas,
              vm.reception.areas,
              'id_area',
              [
                'id_recepcion_area',
                'id_muestra',
                'volumen',
                'vigencia',
                'recipiente',
                'activo'
              ]
            );
            ArrayUtilsService.seItemsFromReference(
              vm.jobs,
              vm.reception.trabajos,
              'id_area',
              [
                'id_recepcion_trabajo',
                'id_recepcion',
                'id_trabajo',
                'fecha_entrega',
                'activo',
                'selected'
              ]
            );
          });
      });

    function approveItem() {
      ValidationService.approveItem(vm.reception, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.reception, vm.user);
    }

    function isFormValid() {
      vm.message = '';
      if (!DateUtilsService.isValidDate(new Date(vm.reception.fecha_entrega))) {
        vm.message += ' Ingrese una fecha/hora de entrega válida ';
        return false;
      }
      vm.reception.fecha_entrega = DateUtilsService.dateToIso(
        new Date(vm.reception.fecha_entrega)
      );
      if (!DateUtilsService.isValidDate(new Date(vm.reception.fecha_recibe))) {
        vm.message += ' Ingrese una fecha/hora de recepción válida ';
        return false;
      }
      vm.reception.fecha_recibe = DateUtilsService.dateToIso(
        new Date(vm.reception.fecha_recibe)
      );
      if (vm.reception.id_recepcionista < 1) {
        vm.message += ' Seleccione un responsable de la recepción ';
        return false;
      }
      if (vm.reception.muestras.length < 1) {
        vm.message += ' Confirme la recepción de una muestra ';
        return false;
      }
      if (vm.reception.id_muestra_validacion < 1) {
        vm.message += ' Seleccione una muestra a verificar ';
        return false;
      }
      if (vm.reception.areas.length < 1) {
        vm.message += ' Seleccione al menos un tipo de análisis ';
        return false;
      }
      if (vm.reception.trabajos.length < 1) {
        vm.message += ' Asigne al menos una Orden de Trabajo ';
        return false;
      }
      if (vm.user.level < 3) {
        if (vm.reception.id_status == 3 && vm.reception.motivo_rechaza.length < 1) {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function selectPreservations() {
      vm.reception.preservaciones = [];
      vm.reception.preservaciones = ArrayUtilsService
      .selectItemsFromCollection(
        vm.preservations,
        'selected',
        true
      ).slice();
    }

    function selectAreas() {
      vm.reception.areas = [];
      var i = 0;
      var l = 0;
      var viewArea = {};
      l = vm.areas.length;
      for (i = 0; i < l; i += 1) {
        viewArea = vm.areas[i];
        if (viewArea.volumen || viewArea.vigencia || viewArea.recipiente) {
          vm.reception.areas.push(viewArea);
        }
      }
    }

    function selectJobs() {
      vm.reception.trabajos = [];
      vm.reception.trabajos = ArrayUtilsService
      .selectItemsFromCollection(
        vm.jobs,
        'selected',
        true
      ).slice();
    }

    function submitForm() {
      vm.selectPreservations();
      vm.selectAreas();
      vm.selectJobs();

      if (isFormValid() && !vm.isDataSubmitted) {
        vm.isDataSubmitted = true;
        if (vm.reception.id_recepcion < 1) {
          RestUtilsService
            .saveData(
              ReceptionService,
              vm.reception,
              'recepcion/recepcion'
            );
        } else {
          if (vm.user.level < 3 || vm.reception.id_status !== 2) {
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
        'DateUtilsService', 'SamplingEmployeeService', 'SheetSampleService',
        'PreservationService', 'ReceivingAreaService', 'ReceptionService',
        ReceptionController
      ]
    );

  //JobListController.js
  /**
   * @name JobListController
   * @constructor
   * @desc Controla la vista para el listado de Órdenes de Trabajo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ReceivingAreaService - Proveedor de datos, Áreas receptoras
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} UserJobsService - Proveedor de datos, Órdenes de Trabajo (Usuario)
   */
  function JobListController($location, TokenService, ReceivingAreaService,
    ArrayUtilsService, UserJobsService) {
    var vm = this;
    vm.jobs = [];
    vm.areas = [];
    vm.user = TokenService.getUserFromToken();
    vm.viewJob = viewJob;

    UserJobsService
      .query({userId: 0})
      .$promise
      .then(function success(response) {
        vm.jobs = response;
        ReceivingAreaService
          .get()
          .$promise
          .then(function success(response) {
            var i = 0;
            var l = 0;
            vm.areas = response;
            l = vm.jobs.length;
            for (i = 0; i < l; i += 1) {
              vm.jobs[i].area = "";
            }
            ArrayUtilsService.seItemsFromReference(
              vm.jobs,
              vm.areas,
              'id_area',
              [
                'area'
              ]
            );
          });
      });

    function viewJob(id) {
      $location.path('/recepcion/trabajo/' + parseInt(id, 10));
    }
  }
  angular
    .module('sislabApp')
    .controller('JobListController',
      [
        '$location', 'TokenService', 'ReceivingAreaService',
        'ArrayUtilsService', 'UserJobsService',
        JobListController
      ]
    );

  //JobController.js
  /**
   * @name JobController
   * @constructor
   * @desc Controla la vista para capturar las Órdenes de Trabajo
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} JobService - Proveedor de datos, Órdenes de Trabajo
   */
  function JobController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, JobService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.job = JobService.query({jobId: $routeParams.jobId});
    vm.isDataSubmitted = false;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;

    function approveItem() {
      ValidationService.approveItem(vm.job, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.job, vm.user);
    }

    function isFormValid() {
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted) {
        vm.isDataSubmitted = true;
        if (vm.job.id_trabajo < 1) {
          RestUtilsService
            .saveData(
              JobService,
              vm.job,
              'recepcion/trabajo'
            );
        } else {
          if (vm.user.level < 3 || vm.job.id_status !== 2) {
            RestUtilsService
              .updateData(
                JobService,
                vm.job,
                'recepcion/trabajo',
                'id_trabajo'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('JobController',
      [
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'JobService',
        JobController
      ]
    );

  //CustodyListController.js
  /**
   * @name CustodyListController
   * @constructor
   * @desc Controla la vista para el listado de Cadenas de custodia
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} CustodyService - Proveedor de datos, Cadenas de custodia
   */
  function CustodyListController($location, CustodyService) {
    var vm = this;
    vm.custodies = CustodyService.get();
    vm.viewCustody = viewCustody;

    function viewCustody(id) {
      $location.path('/recepcion/custodia/' + parseInt(id, 10));
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

  //CustodyController.js
  /**
   * @name CustodyController
   * @constructor
   * @desc Controla la vista para capturar las Cadenas de custodia
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} StorageService - Proveedor de datos, Almacenamientos
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   * @param {Object} ContainerLogService - Proveedor de datos, Bitácoras de Recipiente
   * @param {Object} CustodyParameterService - Proveedor de datos, Parámetros por Custodia
   * @param {Object} CustodyService - Proveedor de datos, Cadenas de custodia
   */
  function CustodyController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, StorageService, ContainerService,
    ContainerLogService, CustodyParameterService, CustodyService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.custody = CustodyService.query({custodyId: $routeParams.custodyId});
    vm.storages = StorageService.get();
    vm.parameters = [];
    vm.containerId = 0;
    vm.logEntry = {};
    vm.logEntries = [];
    vm.getBlankLog = getBlankLog;
    vm.blankLog = getBlankLog();
    vm.viewLog = viewLog;
    vm.openAddLog = openAddLog;
    vm.submitLog = submitLog;
    vm.isLogVisible = false;
    vm.isDataSubmitted = false;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;

    CustodyParameterService
      .query({custodyId: $routeParams.custodyId})
      .$promise
      .then(function success(response) {
        vm.parameters = response;
    });

    function viewLog(containerId) {
      vm.isLogVisible = false;
      vm.message = "";
      vm.logEntries = [];
      ContainerLogService
        .query({containerId: containerId})
        .$promise
        .then(function success(response) {
          if (response.length > 0) {
            vm.logEntries = response;
            vm.isLogVisible = true;
          } else {
            vm.message = " No hay entradas en la bitácora de este recipiente";
          }
      });
    }

    function getBlankLog() {
      return {
        id_historial_recipiente: 0,
        id_custodia: 0,
        id_muestra: 0,
        id_recipiente: 0,
        id_parametro: 0,
        id_usuario_captura: 0,
        id_usuario_actualiza: 0,
        volumen: 0,
        fecha_captura: null,
        fecha_actualiza: null,
        ip_captura: '',
        ip_actualiza: '',
        host_captura: '',
        host_actualiza: '',
        activo: 1
      };
    }

    function openAddLog(container) {
      vm.getBlankLog();
      vm.blankLog.id_custodia = vm.custody.id_custodia;
      vm.blankLog.id_muestra = container.id_muestra;
      vm.blankLog.id_recipiente = container.id_recipiente;
      vm.blankLog.id_usuario_captura = vm.user.id;
      vm.isLogVisible = true;
    }

    function submitLog() {
      if (vm.validateLog() && vm.isLogSubmitted) {
        console.log(vm.blankLog);
        // vm.isLogSubmitted = true;
        // RestUtilsService
        //   .saveData(
        //     ContainerLogService,
        //     vm.blankLog,
        //     'recepcion/custodia'
        //   );
      }
    }

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
      if (isFormValid() && !vm.isDataSubmitted) {
        vm.isDataSubmitted = true;
        if (vm.custody.id_custodia < 1) {
          RestUtilsService
            .saveData(
              CustodyService,
              vm.custody,
              'recepcion/custodia'
            );
        } else {
          if (vm.user.level < 3 || vm.custody.id_status !== 2) {
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
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'StorageService', 'ContainerService',
        'ContainerLogService', 'CustodyParameterService', 'CustodyService',
        CustodyController
      ]
    );

  /**
   * @name PhysAnalysisListController
   * @constructor
   * @desc Controla la vista para el listado de Análisis Fisicoquímicos
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} PhysAnalysisService - Proveedor de datos, Análisis Fisicoquímicos
   */
  function PhysAnalysisListController($location, PhysAnalysisService) {
    var vm = this;
    vm.analysisList = PhysAnalysisService.get();
    vm.viewAnalysis = viewAnalysis;

    function viewAnalysis(id) {
      $location.path('/analisis/fisico/' + parseInt(id, 10));
    }
  }
  angular
    .module('sislabApp')
    .controller('PhysAnalysisListController',
      [
        '$location', 'PhysAnalysisService',
        PhysAnalysisListController
      ]
    );

  /**
   * @name MetalAnalysisListController
   * @constructor
   * @desc Controla la vista para el listado de Análisis de Metales Pesados
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} MetalAnalysisService - Proveedor de datos, Análisis de Metales Pesados
   */
  function MetalAnalysisListController($location, MetalAnalysisService) {
    var vm = this;
    vm.analysisList = MetalAnalysisService.get();
    vm.viewAnalysis = viewAnalysis;

    function viewAnalysis(id) {
      $location.path('/analisis/metal/' + parseInt(id, 10));
    }
  }
  angular
    .module('sislabApp')
    .controller('MetalAnalysisListController',
      [
        '$location', 'MetalAnalysisService',
        MetalAnalysisListController
      ]
    );

  /**
   * @name BioAnalysisListController
   * @constructor
   * @desc Controla la vista para el listado de Análisis de Microbiológicos
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} BioAnalysisService - Proveedor de datos, Análisis Microbiológicos
   */
  function BioAnalysisListController($location, BioAnalysisService) {
    var vm = this;
    vm.analysisList = BioAnalysisService.get();
    vm.viewAnalysis = viewAnalysis;

    function viewAnalysis(id) {
      $location.path('/analisis/metal/' + parseInt(id, 10));
    }
  }
  angular
    .module('sislabApp')
    .controller('BioAnalysisListController',
      [
        '$location', 'BioAnalysisService',
        BioAnalysisListController
      ]
    );

  //SampleListController.js
  /**
   * @name SampleListController
   * @constructor
   * @desc Controla la vista para el listado de Muestras
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} SampleService - Proveedor de datos, Muestras
   */
  function SampleListController($location, TokenService, SampleService) {
    var vm = this;
    vm.samples = SampleService.get();
    vm.user = TokenService.getUserFromToken();
    vm.viewSample = viewSample;

    function viewSample(id) {
      $location.path('/inventario/muestra/' + parseInt(id, 10));
    }
  }
  angular
    .module('sislabApp')
    .controller('SampleListController',
      [
        '$location', 'TokenService', 'SampleService',
        SampleListController
      ]
    );

  //SampleController.js
  /**
   * @name SampleController
   * @constructor
   * @desc Controla la vista para capturar las Cadenas de custodia
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} SampleService - Proveedor de datos, Muestras
   */
  function SampleController($scope, $routeParams, TokenService,
    SampleService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.sample = SampleService.query({sampleId: $routeParams.sampleId});
  }
  angular
    .module('sislabApp')
    .controller('SampleController',
      [
        '$scope', '$routeParams', 'TokenService',
        'SampleService',
        SampleController
      ]
    );

  //InstrumentListController.js
  /**
   * @name InstrumentListController
   * @constructor
   * @desc Controla la vista para el listado de Equipos
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   */
  function ContainerListController(ContainerService) {
    var vm = this;
    vm.containers = ContainerService.get();
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} AnalysisService - Proveedor de datos, Análisis
   */
  function AnalysisListController(AnalysisService) {
    var vm = this;
    vm.analysisList = AnalysisService.get();

    vm.selectRow = selectRow;
    function selectRow() {
      //TODO send to details view
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} AreaService - Proveedor de datos, Áreas
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} AnalysisService - Proveedor de datos, Análisis
   */
  function AnalysisController(AreaService, ParameterService,
    AnalysisService) {
    var vm = this;
    vm.areas = AreaService.get();
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
        'AreaService', 'ParameterService',
        'AnalysisService',
        AnalysisController
      ]
    );

  //ReportListController.js
  /**
   * @name ReportListController
   * @constructor
   * @desc Controla la vista para el listado de Reportes
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} ClientService - Proveedor de datos, Cliente
   */
  function ClientListController(ClientService) {
    var vm = this;
    vm.clients = ClientService.get();
    vm.selectRow = selectRow;

    function selectRow(e) {
      return e.currentTarget.id.split('Id')[1];
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

  //AreaListController.js
  /**
   * @name AreaListController
   * @constructor
   * @desc Controla la vista para el listado de Áreas
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} AreaService - Proveedor de datos, Áreas
   */
  function AreaListController(AreaService) {
    var vm = this;
    vm.areas = AreaService.get();
  }
  angular
    .module('sislabApp')
    .controller('AreaListController',
      [
        'AreaService',
        AreaListController
      ]
    );

  //EmployeeListController.js
  /**
   * @name EmployeeListController
   * @constructor
   * @desc Controla la vista para el listado de Empleados
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
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
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $routeParams - Proveedor de parámetros de ruta
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ProfileService - Proveedor de datos, Perfil de usuario
   */
  function ProfileController($scope, $routeParams, TokenService,
    ProfileService) {
    var vm = this;
    vm.plan = {};
    vm.user = TokenService.getUserFromToken();
    vm.profile = ProfileService.query({userId: $routeParams.userId});
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.submitForm = submitForm;

    function isFormValid() {
      vm.message = '';
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted) {
        vm.isDataSubmitted = true;
        if (vm.profile.id_usuario > 0 && vm.user.level < 3) {
          RestUtilsService
            .saveData(
              PlanService,
              vm.profile,
              'sistema/perfil'
            );
        } else {
          if (vm.user.level < 3) {
            RestUtilsService
              .updateData(
                PlanService,
                vm.profile,
                'sistema/perfil',
                'id_usuario'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('ProfileController',
      [
        '$scope', '$routeParams', 'TokenService',
        'ProfileService',
        ProfileController
      ]
    );

  //LogoutController.js
  /**
   * @name LogoutController
   * @constructor
   * @desc Controla la vista para Logout
   * @this {Object} $scope - Contenedor para el modelo
   * @param {Object} $location - Manejo de URL
   * @param {Object} TokenService - Manejo de objeto Window
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
   * @this {Object} $scope - Contenedor para el modelo
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

  //SERVICES
  //ArrayUtilsService.js
  /**
   * @name ArrayUtilsService
   * @constructor
   * @desc Proveedor para manejo de arreglos
   * @return {ArrayUtilsService} ArrayUtils - Métodos para manejo de arreglos
   */
  function ArrayUtilsService() {
    var ArrayUtils = {};

    ArrayUtils.selectItemFromCollection = selectItemFromCollection;
    ArrayUtils.selectItemsFromCollection = selectItemsFromCollection;
    ArrayUtils.extractItemFromCollection = extractItemFromCollection;
    ArrayUtils.seItemsFromReference = seItemsFromReference;
    ArrayUtils.countSelectedItems = countSelectedItems;
    ArrayUtils.averageFromValues = averageFromValues;

    /**
     * @function selectItemFromCollection
     * @desc Obtiene un ítem de un Array, coincidiendo una propiedad y su valor
     * @param {Array} collection - Array de ítems a seleccionar
     * @param {String} field - Nombre de la propiedad a coincidir
     * @param {Object} value - Valor de la propiedad a coincidir
     * @return {Object} item - Ítem seleccionado
     */
    function selectItemFromCollection(collection, field, value) {
      var i = 0;
      var l = collection.length;
      var item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value) {
          item = collection[i];
          break;
        }
      }
      return item;
    }

    /**
     * @function selectItemsFromCollection
     * @desc Obtiene los ítems de un Array, coincidiendo una propiedad y su valor
     * @param {Array} collection - Array de ítems a seleccionar
     * @param {String} field - Nombre de la propiedad a coincidir
     * @param {Object} value - Valor de la propiedad a coincidir
     * @return {Array} items - Array de ítems seleccionados
     */
    function selectItemsFromCollection(collection, field, value) {
      var i = 0;
      var l = collection.length;
      var items = [];
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value) {
          items.push(collection[i]);
        }
      }
      return items;
    }

    /**
     * @function extractItemFromCollection
     * @desc Extrae un ítem de un Array, coincidiendo el valor de una propiedad
     * @param {Array} collection - Array de origen
     * @param {String} field - Nombre de la propiedad a coincidir
     * @param {Object} value - Valor de la propiedad a coincidir
     * @return {Object} item - Ítem extraído
     */
    function extractItemFromCollection(collection, field, value) {
      var i = 0;
      var l = collection.length;
      var item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value) {
          item = collection.splice(i, 1);
          break;
        }
      }
      return item;
    }

    /**
     * @function seItemsFromReference
     * @desc Cambia las propiedades de ítem de un Array desde otro Array de referencia
     * @param {Array} collection - Array de ítems a modificar
     * @param {Array} reference - Array de referencia
     * @param {String} matchField - Nombre de la propiedad a coincidir
     * @param {Array} fields - Nombres de las propiedades a cambiar
     * @return {Object} item - Ítem seleccionado
     */
    function seItemsFromReference(collection, reference, matchField, fields) {
      var i;
      var l;
      var j;
      var m;
      var k;
      var n;
      var field = '';
      l = collection.length;
      n = fields.length;
      for (i = 0; i < l; i += 1) {
        if (reference !== undefined) {
          m = reference.length;
          for (j = 0; j < m; j += 1) {
            if (collection[i][matchField] == reference[j][matchField]) {
              for (k = 0; k < n; k += 1) {
                field = fields[k];
                collection[i][field] = reference[j][field];
              }
            }
          }
        }
      }
      return collection;
    }

    /**
     * @function countSelectedItems
     * @desc Cuenta los objetos de un Array con valor true de la propiedad selected
     * @param {Array} collection - Array de ítems a extraer
     * @return {Number} count - Cantidad de objetos que cumplen la condición
     */
    function countSelectedItems(collection) {
      var i;
      var l;
      var count = 0;
      if (!collection) {
        return 0;
      }
      l = collection.length;
      for (i = 0; i < l; i += 1) {
        if (collection[i].selected) {
          count += 1;
        }
      }
      return count;
    }

    /**
     * @function averageFromValues
     * @desc Calcula el promedio de los valores numéricos de un Array
     * @param {Array} collection - Array de valores a promediar
     * @return {Number} avg - Cantidad de objetos que cumplen la condición
     */
    function averageFromValues(collection) {
      var i = 0;
      var l = collection.length;
      var sum = 0;
      var avg = 0;
      if (l > 0) {
        for (i = 0; i < l; i++) {
          sum += parseFloat(collection[i]);
        }
        avg = Math.round((sum / l) * 1000 * 1000) / (1000 * 1000);
      }
      return avg;
    }

    return ArrayUtils;
  }
  angular
    .module('sislabApp')
    .factory('ArrayUtilsService',
      [
        ArrayUtilsService
      ]
    );

  //DateUtilsService.js
  /**
   * @name DateUtilsService
   * @constructor
   * @desc Proveedor para manejo de fechas
   * @return {DateUtilsService} DateUtils - Métodos para manejo de fechas
   */
  function DateUtilsService() {
    var DateUtils = {};

    DateUtils.padNumber = padNumber;
    DateUtils.dateToIso = dateToIso;
    DateUtils.isValidDate = isValidDate;

    /**
     * @function padNumber
     * @desc Agrega ceros a un número, devuelve una cadena de la longitud dada
     * @param {Number} number - Número a procesar
     * @param {Number} plces - longitud mínima de la cadena
     * @return {Object} paddedNumber - cadena de la longitud dada
     */
    function padNumber(number, places) {
      var paddedNumber = String(number);
      var i = 0;
      var l = paddedNumber.length;
      var padding = '';
      if (l < places) {
        l = places - l;
        for (i = 0; i < l; i += 1) {
          padding += '0';
        }
        return [
          padding,
          paddedNumber
        ].join('');
      }
      return paddedNumber;
    }

    /**
     * @function dateToIso
     * @desc Convierte una fecha local a una cadena con formato ISO 8601
     * @param {Date} date - Fecha a convertir
     * @return {String} - Cadena de fecha con formato ISO 8601
     */
    function dateToIso(date) {
      return [
        date.getFullYear(),
        '-',
        padNumber(date.getMonth() + 1, 2),
        '-',
        padNumber(date.getDate(), 2),
        'T',
        padNumber(date.getHours(), 2),
        ':',
        padNumber(date.getMinutes(), 2),
        ':',
        padNumber(date.getSeconds(), 2),
        '.',
        (date.getMilliseconds() / 1000).toFixed(3).slice(2, 5),
        (date.getTimezoneOffset() / 60 > -1) ? '-' : '+',
        padNumber(date.getTimezoneOffset() / 60, 2),
        ':00'
      ].join('');
    }

    /**
     * @function isValidDate
     * @desc Determina si la fecha dada es válida
     * @param {Date} date - Fecha a evaluar
     * @return {Boolean} - Resultado de la evaluación
     */
    function isValidDate(date) {
      if (Object.prototype.toString.call(date) !== '[object Date]') {
        return false;
      }
      return !isNaN(date.getTime());
    }

    return DateUtils;
  }
  angular
    .module('sislabApp')
    .factory('DateUtilsService',
      [
        DateUtilsService
      ]
    );

  //RestUtilsService.js
  /**
   * @name RestUtilsService
   * @constructor
   * @desc Proveedor para manejo de servicios REST
   * @return {RestUtilsService} RestUtils - Métodos para manejo de REST
   */
  function RestUtilsService($resource, $location) {
    var RestUtils = {};

    RestUtils.saveData = saveData;
    RestUtils.updateData = updateData;

    /**
     * @function saveData
     * @desc Envía los datos vía POST para generar un nuevo recurso en el servicio
     * @param {Object} service - Proveedor de datos a usar
     * @param {String} data - JSON a enviar al servicio
     * @param {String} returnPath - Ruta de la vista a desplegar, éxito
     */
    function saveData(service, data, returnPath) {
      service
        .save(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          $location.path(returnPath);
          return response;
        }, function error(response) {
          if (response.status === 404) {
            return 'Recurso no encontrado';
          } else {
            return 'Error no especificado';
          }
        });
    }

    /**
     * @function updateData
     * @desc Envía los datos vía POST para actualizar un recurso en el servicio
     * @param {Object} service - Proveedor de datos a usar
     * @param {String} data - JSON a enviar al servicio
     * @param {String} returnPath - Ruta de la vista a desplegar, éxito
     * @param {String} itemIdName - Nombre del identificador del recurso
     */
    function updateData(service, data, returnPath, itemIdName) {
      service
        .update(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          //$location.path(returnPath + '/' + response[itemIdName]);
          $location.path(returnPath);
          return response;
        }, function error(response) {
          if (response.status === 404) {
            return 'Recurso no encontrado';
          } else {
            return 'Error no especificado';
          }
        });
    }

    return RestUtils;
  }
  angular
    .module('sislabApp')
    .factory('RestUtilsService',
      [
        '$resource', '$location',
        RestUtilsService
      ]
    );

  //TokenService.js
  /**
   * @name TokenService
   * @constructor
   * @desc Proveedor para manejo del token
   * @param {Object} $window - Acceso a Objeto Window
   * @param {Object} jwtHelper - Acceso a utilerías de token [Angular-jwt]
   * @return {TokenService} Token - Métodos para manejo de token
   */
  function TokenService($window, $http, $location, jwtHelper) {
    var tokenKey = 'sislab-token';
    var storage = $window.localStorage;
    var cachedToken;
    var Token = {};

    Token.hashMessage = hashMessage;
    Token.authenticateUser = authenticateUser;
    Token.isAuthenticated = isAuthenticated;
    Token.setToken = setToken;
    Token.getToken = getToken;
    Token.clearToken = clearToken;
    Token.decodeToken = decodeToken;
    Token.getUserFromToken = getUserFromToken;

    /**
     * @function hashMessage
     * @desc Codifica un mensaje usando SHA-256
     * @param {String} message - Mensaje a codificar
     * @return {String} - Mensaje codificado
     */
    function hashMessage(message) {
      return CryptoJS.SHA256(message);
    }

    /**
     * @function authenticateUser
     * @desc Envía los datos del usuario al servicio de autenticación
     * @param {String} username - Nombre de usuario
     * @param {String} password - Contraseña del usuario
     */
    function authenticateUser(username, password) {
      $http({
        url: API_BASE_URL + 'login',
        method: 'POST',
        data: {
          username: username,
          password: password
        }
      }).then(function success(response) {
        var token = response.data || null;
        setToken(token);
        $location.path('main');
      }, function error(response) {
        if (response.status === 404) {
          return 'Sin enlace al servidor';
        } else {
          return 'Error no especificado';
        }
      });
    }

    /**
     * @function isAuthenticated
     * @desc Indica si el usuario está autenticado, por la presencia del token
     * @return {Boolean} - Presencia del token
     */
    function isAuthenticated() {
      return !!getToken();
    }

    /**
     * @function setToken
     * @desc Almacena el token
     * @param {Object} token - Token de autenticación
     */
    function setToken(token) {
      cachedToken = token;
      storage.setItem(tokenKey, token);
    }

    /**
     * @function getToken
     * @desc Obtiene el token
     * @return {Object} cachedToken - Token de autenticación
     */
    function getToken() {
      if (!cachedToken) {
        cachedToken = storage.getItem(tokenKey);
      }
      return cachedToken;
    }

    /**
     * @function clearToken
     * @desc Elimina el token
     */
    function clearToken() {
      cachedToken = null;
      storage.removeItem(tokenKey);
    }

    /**
     * @function decodeToken
     * @desc Decodifica el token
     * @return {Object} - Token decodificado
     */
    function decodeToken() {
      var token = getToken();
      return token && jwtHelper.decodeToken(token);
    }

    /**
     * @function getUserFromToken
     * @desc Obtiene datos del usuario del token decodificado
     * @return {Object} userData - Datos del usuario
     */
    function getUserFromToken() {
      var decodedJwt;
      var userData;
      if (isAuthenticated()) {
        decodedJwt = decodeToken();
        userData = {
          name: decodedJwt.nam,
          id: decodedJwt.uid,
          level: decodedJwt.ulv,
          role: decodedJwt.uro,
          area: decodedJwt.uar
        };
      }
      return userData;
    }

    return Token;
  }
  angular
    .module('sislabApp')
    .factory('TokenService',
      [
        '$window', '$http', '$location', 'jwtHelper',
        TokenService
      ]
    );

  //ValidationService.js
  /**
   * @name ValidationService
   * @constructor
   * @desc Proveedor para manejo de validación
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @return {ArrayUtilsService} ArrayUtils - Métodos para manejo de validación
   */
  function ValidationService(DateUtilsService) {
    var Validation = {};

    Validation.approveItem = approveItem;
    Validation.rejectItem = rejectItem;

    function approveItem(item, user) {
      item.id_status = 2;
      item.id_usuario_valida = user.id;
      item.motivo_rechaza = '';
      item.fecha_valida = DateUtilsService.dateToIso(new Date());
    }

    function rejectItem(item, user) {
      item.id_status = 3;
      item.id_usuario_valida = user.id;
      item.fecha_rechaza = DateUtilsService.dateToIso(new Date());
    }

    return Validation;
  }
  angular
    .module('sislabApp')
    .factory('ValidationService',
      [
        'DateUtilsService',
        ValidationService
      ]
    );

  //MenuService.js
  /**
   * @name MenuService
   * @constructor
   * @desc Proveedor de datos, Menú
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MenuService($resource, TokenService) {
    return $resource(API_BASE_URL + 'menu', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('MenuService',
      [
        '$resource', 'TokenService',
        MenuService
      ]
    );

  //TaskService.js
  /**
   * @name TaskService
   * @constructor
   * @desc Proveedor de datos, Tareas
   * @param {Object} $resource- Acceso a recursos HTTP, AngularJS
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function TaskService($resource, TokenService) {
    return $resource(API_BASE_URL + 'tasks', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('TaskService',
      [
        '$resource', 'TokenService',
        TaskService
      ]
    );

  //StudyService.js
  /**
   * @name StudyService
   * @constructor
   * @desc Proveedor de datos, Estudios
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function StudyService($resource, TokenService) {
    return $resource(API_BASE_URL + 'studies/:studyId', {}, {
      query: {
        method: 'GET',
        params: {studyId: 'id_estudio'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('StudyService',
      [
        '$resource', 'TokenService',
        StudyService
      ]
    );

  //OrderService.js
  /**
   * @name OrderService
   * @constructor
   * @desc Proveedor de datos, Órdenes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function OrderService($resource, TokenService) {
    return $resource(API_BASE_URL + 'orders/:orderId', {}, {
      query: {
        method: 'GET',
        params: {orderId: 'id_orden'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('OrderService',
      [
        '$resource', 'TokenService',
        OrderService
      ]
    );

  //PlanService.js
  /**
   * @name PlanService
   * @constructor
   * @desc Proveedor de datos, Planes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PlanService($resource, TokenService) {
    return $resource(API_BASE_URL + 'plans/:planId', {}, {
      query: {
        method: 'GET',
        params: {planId: 'id_plan'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PlanService',
      [
        '$resource', 'TokenService',
        PlanService
      ]
    );

  //SheetService.js
  /**
   * @name SheetService
   * @constructor
   * @desc  Proveedor de datos, Hojas de campo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SheetService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sheets/:sheetId', {}, {
      query: {
        method: 'GET',
        params: {sheetId: 'id_hoja'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SheetService',
      [
        '$resource', 'TokenService',
        SheetService
      ]
    );

  //ReceptionService.js
  /**
   * @name ReceptionService
   * @constructor
   * @desc Proveedor de datos, Recepciones de muestras
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReceptionService($resource, TokenService) {
    return $resource(API_BASE_URL + 'receptions/:receptionId', {}, {
      query: {
        method: 'GET',
        params: {receptionId: 'id_recepcion'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReceptionService',
      [
        '$resource', 'TokenService',
        ReceptionService
      ]
    );

  //JobService.js
  /**
   * @name JobService
   * @constructor
   * @desc Proveedor de datos, Órdenes de Trabajo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function JobService($resource, TokenService) {
    return $resource(API_BASE_URL + 'jobs/:jobId', {}, {
      query: {
        method: 'GET',
        params: {jobId: 'id_trabajo'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('JobService',
      [
        '$resource', 'TokenService',
        JobService
      ]
    );

  //UserJobsService.js
  /**
   * @name UserJobsService
   * @constructor
   * @desc Proveedor de datos, Órdenes de Trabajo (Usuario)
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function UserJobsService($resource, TokenService) {
    return $resource(API_BASE_URL + 'jobs/user/:userId', {}, {
      // get: {
      //   method: 'GET',
      //   params: {},
      //   isArray: true,
      //   headers: {
      //     'Auth-Token': TokenService.getToken()
      //   }
      // },
      query: {
        method: 'GET',
        params: {userId: 'id_usuario'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('UserJobsService',
      [
        '$resource', 'TokenService',
        UserJobsService
      ]
    );

  //CustodyService.js
  /**
   * @name CustodyService
   * @constructor
   * @desc Proveedor de datos, Cadenas de custodia
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CustodyService($resource, TokenService) {
    return $resource(API_BASE_URL + 'custodies/:custodyId', {}, {
      query: {
        method: 'GET',
        params: {custodyId: 'id_custodia'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('CustodyService',
      [
        '$resource', 'TokenService',
        CustodyService
      ]
    );

  //PhysAnalysisService.js
  /**
   * @name PhysAnalysisService
   * @constructor
   * @desc Proveedor de datos, Análisis Fisicoquímicos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PhysAnalysisService($resource, TokenService) {
    return $resource(API_BASE_URL + 'analysis/physical/:analysisId', {}, {
      query: {
        method: 'GET',
        params: {analysisId: 'id_analisis'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PhysAnalysisService',
      [
        '$resource', 'TokenService',
        PhysAnalysisService
      ]
    );

  //MetalAnalysisService.js
  /**
   * @name MetalAnalysisService
   * @constructor
   * @desc Proveedor de datos, Análisis de Metales Pesados
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MetalAnalysisService($resource, TokenService) {
    return $resource(API_BASE_URL + 'analysis/metal/:analysisId', {}, {
      query: {
        method: 'GET',
        params: {analysisId: 'id_analisis'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('MetalAnalysisService',
      [
        '$resource', 'TokenService',
        MetalAnalysisService
      ]
    );

  //BioAnalysisService.js
  /**
   * @name BioAnalysisService
   * @constructor
   * @desc Proveedor de datos, Análisis Microbiológicos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function BioAnalysisService($resource, TokenService) {
    return $resource(API_BASE_URL + 'analysis/biological/:analysisId', {}, {
      query: {
        method: 'GET',
        params: {analysisId: 'id_analisis'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('BioAnalysisService',
      [
        '$resource', 'TokenService',
        BioAnalysisService
      ]
    );

  //ClientService.js
  /**
   * @name ClientService
   * @constructor
   * @desc Proveedor de datos, Cliente
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ClientService($resource, TokenService) {
    return $resource(API_BASE_URL + 'clients', {}, {
      query: {
        method: 'GET',
        params: {clientId: 'id_cliente'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ClientService',
      [
        '$resource', 'TokenService',
        ClientService
      ]
    );

  //PointService.js
  /**
   * @name PointService
   * @constructor
   * @desc Proveedor de datos, Puntos muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointService($resource, TokenService) {
    return $resource(API_BASE_URL + 'points', {}, {
      query: {
        method: 'GET',
        params: {pointId: 'id_punto'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PointService',
      [
        '$resource', 'TokenService',
        PointService
      ]
    );

  //PackagePointsService.js
  /**
   * @name PackagePointsService
   * @constructor
   * @desc Proveedor de datos, Puntos de muestreo por paquete
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PackagePointsService($resource, TokenService) {
    return $resource(API_BASE_URL + 'packages/points/:packageId', {}, {
      get: {
        method: 'GET',
        params: {packageId: 'id_paquete_punto'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PackagePointsService',
      [
        '$resource', 'TokenService',
        PackagePointsService
      ]
    );

  //ParameterService.js
  /**
   * @name ParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros de análisis
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ParameterService($resource, TokenService) {
    return $resource(API_BASE_URL + 'parameters', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ParameterService',
      [
        '$resource', 'TokenService',
        ParameterService
      ]
    );

  //CustodyParameterService.js
  /**
   * @name CustodyParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros por Custodia
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CustodyParameterService($resource, TokenService) {
    return $resource(API_BASE_URL + 'parameters/custodies/:custodyId', {}, {
      query: {
        method: 'GET',
        params: {custodyId: 'id_custodia'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('CustodyParameterService',
      [
        '$resource', 'TokenService',
        CustodyParameterService
      ]
    );

  //NormService.js
  /**
   * @name NormService
   * @constructor
   * @desc Proveedor de datos, Normas referencia
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function NormService($resource, TokenService) {
    return $resource(API_BASE_URL + 'norms', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('NormService',
      [
        '$resource', 'TokenService',
        NormService
      ]
    );

  //SamplingTypeService.js
  /**
   * @name SamplingTypeService
   * @constructor
   * @desc Proveedor de datos, Tipos de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingTypeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/types', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SamplingTypeService',
      [
        '$resource', 'TokenService',
        SamplingTypeService
      ]
    );

  //OrderSourceService.js
  /**
   * @name OrderSourceService
   * @constructor
   * @desc Proveedor de datos, Orígenes de orden
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function OrderSourceService($resource, TokenService) {
    return $resource(API_BASE_URL + 'order/sources/:sourceId', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      query: {
        method: 'GET',
        params: {sourceId: 'id_origen_orden'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('OrderSourceService',
      [
        '$resource', 'TokenService',
        OrderSourceService
      ]
    );

  //MatrixService.js
  /**
   * @name MatrixService
   * @constructor
   * @desc Proveedor de datos, Matrices
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MatrixService($resource, TokenService) {
    return $resource(API_BASE_URL + 'matrices', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('MatrixService',
      [
        '$resource', 'TokenService',
        MatrixService
      ]
    );

  //PackageService.js
  /**
   * @name PackageService
   * @constructor
   * @desc Proveedor de datos, Paquetes de puntos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PackageService($resource, TokenService) {
    return $resource(API_BASE_URL + 'packages', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PackageService',
      [
        '$resource', 'TokenService',
        PackageService
      ]
    );

  //LocationPackagesService.js
  /**
   * @name LocationPackagesService
   * @constructor
   * @desc Proveedor de datos, Paquetes por Ubicación
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function LocationPackagesService($resource, TokenService) {
    return $resource(API_BASE_URL + 'packages/location/:locationId', {}, {
      query: {
        method: 'GET',
        params: {locationId: 'id_ubicacion'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('LocationPackagesService',
      [
        '$resource', 'TokenService',
        LocationPackagesService
      ]
    );

  //SamplingSupervisorService.js
  /**
   * @name SamplingSupervisorService
   * @constructor
   * @desc Proveedor de datos, Supervisores de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingSupervisorService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/supervisors', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SamplingSupervisorService',
      [
        '$resource', 'TokenService',
        SamplingSupervisorService
      ]
    );

  //PlanObjectiveService.js
  /**
   * @name PlanObjectiveService
   * @constructor
   * @desc Proveedor de datos, Objetivos de Plan
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PlanObjectiveService($resource, TokenService) {
    return $resource(API_BASE_URL + 'plan/objectives', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PlanObjectiveService',
      [
        '$resource', 'TokenService',
        PlanObjectiveService
      ]
    );

  //PointKindsService.js
  /**
   * @name PointKindsService
   * @constructor
   * @desc Proveedor de datos, tipos Punto
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointKindsService($resource, TokenService) {
    return $resource(API_BASE_URL + 'point/kinds', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PointKindsService',
      [
        '$resource', 'TokenService',
        PointKindsService
      ]
    );

  //DistrictService.js
  /**
   * @name DistrictService
   * @constructor
   * @desc Proveedor de datos, Municipios
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function DistrictService($resource, TokenService) {
    return $resource(API_BASE_URL + 'districts', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('DistrictService',
      [
        '$resource', 'TokenService',
        DistrictService
      ]
    );

  //CityService.js
  /**
   * @name CityService
   * @constructor
   * @desc Proveedor de datos, Localidades
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CityService($resource, TokenService) {
    return $resource(API_BASE_URL + 'districts/cities/:districtId', {}, {
      query: {
        method: 'GET',
        params: {districtId: 'id_municipio'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('CityService',
      [
        '$resource', 'TokenService',
        CityService
      ]
    );

  //SamplingEmployeeService.js
  /**
   * @name SamplingEmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingEmployeeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/employees', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SamplingEmployeeService',
      [
        '$resource', 'TokenService',
        SamplingEmployeeService
      ]
    );

  //PreservationService.js
  /**
   * @name PreservationService
   * @constructor
   * @desc Proveedor de datos, Preservaciones
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PreservationService($resource, TokenService) {
    return $resource(API_BASE_URL + 'preservations', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PreservationService',
      [
        '$resource', 'TokenService',
        PreservationService
      ]
    );

  //ContainerService.js
  /**
   * @name ContainerService
   * @constructor
   * @desc Proveedor de datos, Recipientes
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ContainerService($resource, TokenService) {
    return $resource(API_BASE_URL + 'containers/:containerId', {}, {
      query: {
        method: 'GET',
        params: {containerId: 'id_recipiente'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ContainerService',
      [
        '$resource', 'TokenService',
        ContainerService
      ]
    );

  //ContainerLogService.js
  /**
   * @name ContainerLogService
   * @constructor
   * @desc Proveedor de datos, Bitácoras de Recipiente
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ContainerLogService($resource, TokenService) {
    return $resource(API_BASE_URL + 'containers/:containerId/logs', {}, {
      query: {
        method: 'GET',
        params: {containerId: 'id_recipiente'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ContainerLogService',
      [
        '$resource', 'TokenService',
        ContainerLogService
      ]
    );

  //ReactiveService.js
  /**
   * @name ReactiveService
   * @constructor
   * @desc Proveedor de datos, Reactivos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
  */
  function ReactiveService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reactives', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReactiveService',
      [
        '$resource', 'TokenService',
        ReactiveService
      ]
    );

  //MaterialService.js
  /**
   * @name MaterialService
   * @constructor
   * @desc Proveedor de datos, Materiales
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MaterialService($resource, TokenService) {
    return $resource(API_BASE_URL + 'materials', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('MaterialService',
      [
        '$resource', 'TokenService',
        MaterialService
      ]
    );

  //CoolerService.js
  /**
   * @name CoolerService
   * @constructor
   * @desc Proveedor de datos, Hieleras
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CoolerService($resource, TokenService) {
    return $resource(API_BASE_URL + 'coolers', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('CoolerService',
      [
        '$resource', 'TokenService',
        CoolerService
      ]
    );

  //SamplingInstrumentService.js
  /**
   * @name SamplingInstrumentService
   * @constructor
   * @desc Proveedor de datos, Equipos de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingInstrumentService($resource, TokenService) {
    return $resource(API_BASE_URL + 'instruments/sampling', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SamplingInstrumentService',
      [
        '$resource', 'TokenService',
        SamplingInstrumentService
      ]
    );

  //FieldParameterService.js
  /**
   * @name FieldParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros campo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function FieldParameterService($resource, TokenService) {
    return $resource(API_BASE_URL + 'parameters/field', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('FieldParameterService',
      [
        '$resource', 'TokenService',
        FieldParameterService
      ]
    );

  //ReceptionistService.js
  /**
   * @name ReceptionistService
   * @constructor
   * @desc Proveedor de datos, Recepcionistas
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReceptionistService($resource, TokenService) {
    return $resource(API_BASE_URL + 'receptionists', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReceptionistService',
      [
        '$resource', 'TokenService',
        ReceptionistService
      ]
    );

  //AreaService.js
  /**
   * @name AreaService
   * @constructor
   * @desc Proveedor de datos, Áreas
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function AreaService($resource, TokenService) {
    return $resource(API_BASE_URL + 'areas', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('AreaService',
      [
        '$resource', 'TokenService',
        AreaService
      ]
    );

  //ReceivingAreaService.js
  /**
   * @name ReceivingAreaService
   * @constructor
   * @desc Proveedor de datos, Áreas receptoras
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReceivingAreaService($resource, TokenService) {
    return $resource(API_BASE_URL + 'areas/reception', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReceivingAreaService',
      [
        '$resource', 'TokenService',
        ReceivingAreaService
      ]
    );

  //RequiredVolumeService.js
  /**
   * @name RequiredVolumeService
   * @constructor
   * @desc Proveedor de datos, Volúmenes requeridos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function RequiredVolumeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'volumes', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('RequiredVolumeService',
      [
        '$resource', 'TokenService',
        RequiredVolumeService
      ]
    );

  //SampleService.js
  /**
   * @name SampleService
   * @constructor
   * @desc Proveedor de datos, Muestras
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SampleService($resource, TokenService) {
    return $resource(API_BASE_URL + 'samples/:sampleId', {}, {
      query: {
        method: 'GET',
        params: {sampleId: 'id_muestra'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SampleService',
      [
        '$resource', 'TokenService',
        SampleService
      ]
    );

  //SheetSampleService.js
  /**
   * @name SheetSampleService
   * @constructor
   * @desc Proveedor de datos, Muestras por Hoja de campo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SheetSampleService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sheet/samples/:sheetId', {}, {
      query: {
        method: 'GET',
        params: {sheetId: 'id_hoja'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SheetSampleService',
      [
        '$resource', 'TokenService',
        SheetSampleService
      ]
    );

  //InstrumentsListService.js
  /**
   * @name InstrumentsListService
   * @constructor
   * @desc Proveedor de datos, Equipos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function InstrumentsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'instruments', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('InstrumentsListService',
      [
        '$resource', 'TokenService',
        InstrumentsListService
      ]
    );

  //AnalysisListService.js
  /**
   * @name AnalysisListService
   * @constructor
   * @desc Proveedor de datos, consulta de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function AnalysisListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'analysis', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('AnalysisListService',
      [
        '$resource', 'TokenService',
        AnalysisListService
      ]
    );

  //DepartmentService.js
  /**
   * @name DepartmentService
   * @constructor
   * @desc Proveedor de datos, Áreas
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function DepartmentService($resource, TokenService) {
    return $resource(API_BASE_URL + 'areas', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('DepartmentService',
      [
        '$resource', 'TokenService',
        DepartmentService
      ]
    );

  //AnalysisService.js
  /**
   * @name AnalysisService
   * @constructor
   * @desc Proveedor de datos, selección de formato de captura de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function AnalysisService($resource, TokenService) {
    return $resource(API_BASE_URL + 'analysis/selections', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('AnalysisService',
      [
        '$resource', 'TokenService',
        AnalysisService
      ]
    );

  //ReportsListService.js
  /**
   * @name ReportsListService
   * @constructor
   * @desc Proveedor de datos, Reportes
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReportsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reports', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReportsListService',
      [
        '$resource', 'TokenService',
        ReportsListService
      ]
    );

  //ReportService.js
  /**
   * @name ReportService
   * @constructor
   * @desc Proveedor de datos, Reporte
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReportService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reports/:reportId', {}, {
      query: {
        method: 'GET',
        params: {reportId: 'id_reporte'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReportService',
      [
        '$resource', 'TokenService',
        ReportService
      ]
    );

  //EmployeeService.js
  /**
   * @name EmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function EmployeeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'employees', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('EmployeeService',
      [
        '$resource', 'TokenService',
        EmployeeService
      ]
    );

  //NormsListService.js
  /**
   * @name NormsListService
   * @constructor
   * @desc Proveedor de datos, Normas
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function NormsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'norms', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('NormsListService',
      [
        '$resource', 'TokenService',
        NormsListService
      ]
    );

  //ReferencesListService.js
  /**
   * @name ReferencesListService
   * @constructor
   * @desc Proveedor de datos, Referencias
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReferencesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'references', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReferencesListService',
      [
        '$resource', 'TokenService',
        ReferencesListService
      ]
    );

  //MethodsListService.js
  /**
   * @name MethodsListService
   * @constructor
   * @desc Proveedor de datos, Métodos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MethodsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'methods', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('MethodsListService',
      [
        '$resource', 'TokenService',
        MethodsListService
      ]
    );

  //PricesListService.js
  /**
   * @name PricesListService
   * @constructor
   * @desc Proveedor de datos, Precios
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PricesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'prices', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PricesListService',
      [
        '$resource', 'TokenService',
        PricesListService
      ]
    );

  //UsersListService.js
  /**
   * @name UsersListService
   * @constructor
   * @desc Proveedor de datos, Usuarios
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function UsersListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'users', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('UsersListService',
      [
        '$resource', 'TokenService',
        UsersListService
      ]
    );

  //ProfileService.js
  /**
   * @name ProfileService
   * @constructor
   * @desc Proveedor de datos, Perfil de usuario
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ProfileService($resource, TokenService) {
    return $resource(API_BASE_URL + 'users/:userId', {}, {
      query: {
        method: 'GET',
        params: {userId: 'id_usuario'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ProfileService',
      [
        '$resource', 'TokenService',
        ProfileService
      ]
    );

  //CloudService.js
  /**
   * @name CloudService
   * @constructor
   * @desc Proveedor de datos, Cobertura nubes
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CloudService($resource, TokenService) {
    return $resource(API_BASE_URL + 'clouds', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('CloudService',
      [
        '$resource', 'TokenService',
        CloudService
      ]
    );

  //WindService.js
  /**
   * @name WindService
   * @constructor
   * @desc Proveedor de datos, Direcciones viento
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function WindService($resource, TokenService) {
    return $resource(API_BASE_URL + 'winds', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('WindService',
      [
        '$resource', 'TokenService',
        WindService
      ]
    );

  //WaveService.js
  /**
   * @name WaveService
   * @constructor
   * @desc Proveedor de datos, Intensidades oleaje
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function WaveService($resource, TokenService) {
    return $resource(API_BASE_URL + 'waves', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('WaveService',
      [
        '$resource', 'TokenService',
        WaveService
      ]
    );

  //SamplingNormService.js
  /**
   * @name SamplingNormService
   * @constructor
   * @desc Proveedor de datos, Normas muestreo
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingNormService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/norms', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SamplingNormService',
      [
        '$resource', 'TokenService',
        SamplingNormService
      ]
    );

  //LocationService.js
  /**
   * @name LocationService
   * @constructor
   * @desc Proveedor de datos, Ubicación
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function LocationService($resource, TokenService) {
    return $resource(API_BASE_URL + 'locations/:locationId', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      query: {
        method: 'GET',
        params: {locationId: 'id_ubicacion'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('LocationService',
      [
        '$resource', 'TokenService',
        LocationService
      ]
    );

  //WaterBodyService.js
  /**
   * @name WaterBodyService
   * @constructor
   * @desc Proveedor de datos, Cuerpo de agua
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function WaterBodyService($resource, TokenService) {
    return $resource(API_BASE_URL + 'bodies/:bodyId', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      query: {
        method: 'GET',
        params: {bodyId: 'id_cuerpo'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('WaterBodyService',
      [
        '$resource', 'TokenService',
        WaterBodyService
      ]
    );

  //StorageService.js
  /**
   * @name StorageService
   * @constructor
   * @desc Proveedor de datos, Almacenamientos
   * @param {Object} $resource - Acceso a recursos HTTP
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function StorageService($resource, TokenService) {
    return $resource(API_BASE_URL + 'storages/:storageId', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      query: {
        method: 'GET',
        params: {storageId: 'id_almacenamiento'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('StorageService',
      [
        '$resource', 'TokenService',
        StorageService
      ]
    );
})();
