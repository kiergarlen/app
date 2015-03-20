
  'use strict';
  // ANGULAR MODULE SETTER
  angular
    .module('sislabApp', [
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
      when('/recepcion/hojas', {
        templateUrl: 'partials/recepcion/hojas.html',
        controller: 'FieldSheetsListController',
        controllerAs: 'fieldSheets'
      }).
      when('/recepcion/hoja/:sheetId', {
        templateUrl: 'partials/recepcion/hoja.html',
        controller: 'FieldSheetController',
        controllerAs: 'fieldSheet'
      }).
      when('/recepcion/recepciones', {
        templateUrl: 'partials/recepcion/recepciones.html',
        controller: 'ReceptionsListController',
        controllerAs: 'receptions'
      }).
      when('/recepcion/recepcion/:receptionId', {
        templateUrl: 'partials/recepcion/recepcion.html',
        controller: 'ReceptionController',
        controllerAs: 'reception'
      }).
      when('/recepcion/custodias', {
        templateUrl: 'partials/recepcion/custodias.html',
        controller: 'CustodiesListController',
        controllerAs: 'custodies'
      }).
      when('/recepcion/custodia/:custodyId', {
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
      when('/analisis/analisis/:analysisId', {
        templateUrl: 'partials/analisis/analisis.html',
        controller: 'AnalysisController',
        controllerAs: 'analysis'
      }).
      when('/analisis/analisis', {
        templateUrl: 'partials/analisis/consulta.html',
        controller: 'AnalysisListController',
        controllerAs: 'analysisList'
      }).
      when('/reporte/reporte/:reportId', {
        templateUrl: 'partials/reporte/reporte.html',
        controller: 'ReportController',
        controllerAs: 'report'
      }).
      when('/reporte/reportes', {
        templateUrl: 'partials/reporte/reportes.html',
        controller: 'ReportsListController',
        controllerAs: 'reportsList'
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
      when('/catalogo/cliente/:clientId', {
        templateUrl: 'partials/catalogo/cliente.html',
        controller: 'ClientDetailController',
        controllerAs: 'clientDetail'
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
  // sislabMenu.js
  /**
   * @name sislabMenu
   * @desc Directiva para menú principal
   */
  function sislabMenu() {
    return {
      restrict: 'EA',
      require: '^ngModel',
      templateUrl: 'partials/sistema/menu.html'
    };
  }

  angular
    .module('sislabApp')
    .directive('sislabMenu', sislabMenu);

  // sislabBanner.js
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

  // sislabFooter.js
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

  // sislabBannerBottom.js
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
