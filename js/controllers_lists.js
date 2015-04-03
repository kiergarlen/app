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
    vm.addOrder = addOrder;
    vm.viewOrder = viewOrder;
    /**/
    function addOrder() {
      $location.path('/muestreo/orden/0');
    }
    /**/
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
    vm.plans = PlanService.query();
    vm.addPlan = addPlan;
    vm.selectRow = selectRow;

    function addPlan() {
      $location.path('/muestreo/plan/0');
    }

    function viewStudy(id) {
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

  //FieldSheetsListController.js
  /**
   * @name FieldSheetsListController
   * @constructor
   * @desc Controla la vista para el listado de Hojas de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} FieldSheetService - Proveedor de datos, Hojas de campo
   */
  function FieldSheetsListController($location, FieldSheetService) {
    var vm = this;
    vm.fieldSheets = FieldSheetService.query();
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
        '$location', 'FieldSheetService',
        FieldSheetsListController
      ]
    );

  //ReceptionsListController.js
  /**
   * @name ReceptionsListController
   * @constructor
   * @desc Controla la vista para el listado de Recepciones
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
   */
  function ReceptionsListController($location, ReceptionService) {
    var vm = this;
    vm.receptions = ReceptionService.query();
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
        '$location', 'ReceptionService',
        ReceptionsListController
      ]
    );

  /**
   * @name CustodiesListController
   * @constructor
   * @desc Controla la vista para el listado de Cadenas de custodia
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} CustodiesService - Proveedor de datos, Cadenas custodia
   */
  function CustodiesListController($location, CustodiesService) {
    var vm = this;
    vm.custodies = CustodiesService.get();
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
        '$location', 'CustodiesService',
        CustodiesListController
      ]
    );

  //SamplesListController.js
  /**
   * @name SamplesListController
   * @constructor
   * @desc Controla la vista para el listado de Muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} SamplesListService - Proveedor de datos, lista de Muestras
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

  //InstrumentsListController.js
  /**
   * @name InstrumentsListController
   * @constructor
   * @desc Controla la vista para el listado de Equipos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} InstrumentsListService - Proveedor de datos, lista de Equipos
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

  //ReactivesListController.js
  /**
   * @name ReactivesListController
   * @constructor
   * @desc Controla la vista para el listado de Reactivos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReactivesListService - Proveedor de datos, lista de Reactivos
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

  //ContainersListController.js
  /**
   * @name ContainersListController
   * @constructor
   * @desc Controla la vista para el listado de Recipientes
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

  //AnalysisListController.js
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

  //AnalysisController.js
  /**
   * @name AnalysisController
   * @constructor
   * @desc Controla la vista para seleccionar captura de Análisis
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} DepartmentService - Proveedor de datos, Áreas
   * @param {Object} ParameterService - Proveedor de datos, Parámetros
   * @param {Object} AnalysisService - Proveedor de datos, selección de captura de Análisis
   */
  function AnalysisController(DepartmentService, ParameterService,
    AnalysisService) {
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

  //ReportsListController.js
  /**
   * @name ReportsListController
   * @constructor
   * @desc Controla la vista para el listado de Reportes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReportsListService - Proveedor de datos, lista de Reportes
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

  //PointsListController.js
  /**
   * @name PointsListController
   * @constructor
   * @desc Controla la vista para el listado de Puntos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PointsListService - Proveedor de datos, lista de Puntos
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

  //ClientsListController.js
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

  //DepartmentsListController.js
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

  //EmployeesListController.js
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

  //NormsListController.js
  /**
   * @name NormsListController
   * @constructor
   * @desc Controla la vista para el listado de Normas
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

  //ReferencesListController.js
  /**
   * @name ReferencesListController
   * @constructor
   * @desc Controla la vista para el listado de Referencias
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

  //MethodsListController.js
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

  //PricesListController.js
  /**
   * @name PricesListController
   * @constructor
   * @desc Controla la vista para el listado de Precios
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

  //UsersListController.js
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
        ClientsListController
      ]
    );