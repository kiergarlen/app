
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
   * @param {Object} jwtInterceptorProvider - Proveedor, intercepción de JWT
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
      when('/estudio/estudio', {
        templateUrl: 'partials/estudio/estudios.html',
        controller: 'StudiesListController',
        controllerAs: 'studies'
      }).
      when('/estudio/estudio/:studyId', {
        templateUrl: 'partials/estudio/estudio.html',
        controller: 'StudyController',
        controllerAs: 'study'
      }).
      when('/muestreo/solicitud', {
        templateUrl: 'partials/muestreo/solicitudes.html',
        controller: 'QuotesListController',
        controllerAs: 'quotes'
      }).
      when('/muestreo/solicitud/:quoteId', {
        templateUrl: 'partials/muestreo/solicitud.html',
        controller: 'QuoteController',
        controllerAs: 'quote'
      }).
      when('/muestreo/orden', {
        templateUrl: 'partials/muestreo/ordenes.html',
        controller: 'OrdersListController',
        controllerAs: 'orders'
      }).
      when('/muestreo/orden/:orderId', {
        templateUrl: 'partials/muestreo/orden.html',
        controller: 'OrderController',
        controllerAs: 'order'
      }).
      when('/muestreo/plan', {
        templateUrl: 'partials/muestreo/planes.html',
        controller: 'PlansListController',
        controllerAs: 'plans'
      }).
      when('/muestreo/plan/:planId', {
        templateUrl: 'partials/muestreo/plan.html',
        controller: 'PlanController',
        controllerAs: 'plan'
      }).
      when('/recepcion/hoja', {
        templateUrl: 'partials/recepcion/hojas.html',
        controller: 'FieldSheetsListController',
        controllerAs: 'fieldSheets'
      }).
      when('/recepcion/hoja/:sheetId', {
        templateUrl: 'partials/recepcion/hoja.html',
        controller: 'FieldSheetController',
        controllerAs: 'fieldSheet'
      }).
      when('/recepcion/recepcion', {
        templateUrl: 'partials/recepcion/recepciones.html',
        controller: 'ReceptionsListController',
        controllerAs: 'receptions'
      }).
      when('/recepcion/recepcion/:receptionId', {
        templateUrl: 'partials/recepcion/recepcion.html',
        controller: 'ReceptionController',
        controllerAs: 'reception'
      }).
      when('/recepcion/custodia', {
        templateUrl: 'partials/recepcion/custodias.html',
        controller: 'CustodiesListController',
        controllerAs: 'custodies'
      }).
      when('/recepcion/custodia/:custodyId', {
        templateUrl: 'partials/recepcion/custodia.html',
        controller: 'CustodyController',
        controllerAs: 'custody'
      }).
      when('/inventario/muestra', {
        templateUrl: 'partials/inventario/muestras.html',
        controller: 'SamplesListController',
        controllerAs: 'samplesList'
      }).
      when('/inventario/equipo', {
        templateUrl: 'partials/inventario/equipos.html',
        controller: 'InstrumentsListController',
        controllerAs: 'instrumentsList'
      }).
      when('/inventario/reactivo', {
        templateUrl: 'partials/inventario/reactivos.html',
        controller: 'ReactivesListController',
        controllerAs: 'reactivesList'
      }).
      when('/inventario/recipiente', {
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
      when('/reporte/reporte', {
        templateUrl: 'partials/reporte/reportes.html',
        controller: 'ReportsListController',
        controllerAs: 'reportsList'
      }).
      when('/reporte/reporte/:reportId', {
        templateUrl: 'partials/reporte/reporte.html',
        controller: 'ReportController',
        controllerAs: 'report'
      }).
      when('/catalogo/punto', {
        templateUrl: 'partials/catalogo/puntos.html',
        controller: 'PointsListController',
        controllerAs: 'pointsList'
      }).
      when('/catalogo/cliente', {
        templateUrl: 'partials/catalogo/clientes.html',
        controller: 'ClientsListController',
        controllerAs: 'clients'
      }).
      when('/catalogo/cliente/:clientId', {
        templateUrl: 'partials/catalogo/cliente.html',
        controller: 'ClientDetailController',
        controllerAs: 'clientDetail'
      }).
      when('/catalogo/area', {
        templateUrl: 'partials/catalogo/areas.html',
        controller: 'DepartmentsListController',
        controllerAs: 'departmentsList'
      }).
      when('/catalogo/empleado', {
        templateUrl: 'partials/catalogo/empleados.html',
        controller: 'EmployeesListController',
        controllerAs: 'employeesList'
      }).
      when('/catalogo/norma', {
        templateUrl: 'partials/catalogo/normas.html',
        controller: 'NormsListController',
        controllerAs: 'normsList'
      }).
      when('/catalogo/referencia', {
        templateUrl: 'partials/catalogo/referencia.html',
        controller: 'ReferencesListController',
        controllerAs: 'referencesList'
      }).
      when('/catalogo/metodo', {
        templateUrl: 'partials/catalogo/metodos.html',
        controller: 'MethodsListController',
        controllerAs: 'methodsList'
      }).
      when('/catalogo/precio', {
        templateUrl: 'partials/catalogo/precios.html',
        controller: 'PricesListController',
        controllerAs: 'pricesList'
      }).
      when('/sistema/usuario', {
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
      templateUrl: 'partials/sistema/menu.html',
      controller: 'MenuController',
      controllerAs: 'menu'
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
