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
