
  //SheetsListController.js
  /**
   * @name SheetsListController
   * @constructor
   * @desc Controla la vista para el listado de Hojas de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} SheetService - Proveedor de datos, Hojas de campo
   */
  function SheetsListController($location, SheetService) {
    var vm = this;
    vm.sheets = SheetService.get();
    vm.addSheet = addSheet;
    vm.selectRow = selectRow;

    function addSheet() {
      $location.path('/recepcion/hoja/0');
    }

    function selectRow(e) {
      var itemId = e.currentTarget.id.split('Id')[1];
      $location.path('/recepcion/hoja/' + itemId);
    }
  }
  angular
    .module('sislabApp')
    .controller('SheetsListController',
      [
        '$location', 'SheetService',
        SheetsListController
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
    vm.receptions = ReceptionService.get();
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
   * @param {Object} CustodyService - Proveedor de datos, Cadenas de custodia
   */
  function CustodiesListController($location, CustodyService) {
    var vm = this;
    vm.custodies = CustodyService.get();
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
        '$location', 'CustodyService',
        CustodiesListController
      ]
    );

  //SamplesListController.js
  /**
   * @name SamplesListController
   * @constructor
   * @desc Controla la vista para el listado de Muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} SampleService - Proveedor de datos, Muestras
   */
  function SamplesListController(SampleService) {
    var vm = this;
    vm.pricesList = SampleService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('SamplesListController',
      [
        'SampleService',
        SamplesListController
      ]
    );

  //InstrumentsListController.js
  /**
   * @name InstrumentsListController
   * @constructor
   * @desc Controla la vista para el listado de Equipos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} InstrumentService - Proveedor de datos, Equipos
   */
  function InstrumentsListController(InstrumentService) {
    var vm = this;
    vm.clients = InstrumentService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('InstrumentsListController',
      [
        'InstrumentService',
        InstrumentsListController
      ]
    );

  //ReactivesListController.js
  /**
   * @name ReactivesListController
   * @constructor
   * @desc Controla la vista para el listado de Reactivos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReactiveService - Proveedor de datos, Reactivos
   */
  function ReactivesListController(ReactiveService) {
    var vm = this;
    vm.pricesList = ReactiveService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ReactivesListController',
      [
        'ReactiveService',
        ReactivesListController
      ]
    );

  //ContainersListController.js
  /**
   * @name ContainersListController
   * @constructor
   * @desc Controla la vista para el listado de Recipientes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ContainerService - Proveedor de datos, Recipientes
   */
  function ContainersListController(ContainerService) {
    var vm = this;
    vm.pricesList = ContainerService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ContainersListController',
      [
        'ContainerService',
        ContainersListController
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

  //ReportsListController.js
  /**
   * @name ReportsListController
   * @constructor
   * @desc Controla la vista para el listado de Reportes
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReportService - Proveedor de datos, Reportes
   */
  function ReportsListController(ReportService) {
    var vm = this;
    vm.pricesList = ReportService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ReportsListController',
      [
        'ReportService',
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

  //PointsListController.js
  /**
   * @name PointsListController
   * @constructor
   * @desc Controla la vista para el listado de Puntos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PointService - Proveedor de datos, Puntos
   */
  function PointsListController(PointService) {
    var vm = this;
    vm.points = PointService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('PointsListController',
      [
        'PointService',
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
    vm.clients = ClientService.get();
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
    vm.departments = DepartmentService.get();
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
    vm.employees = EmployeeService.get();
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
   * @param {Object} NormService - Proveedor de datos, Normas
   */
  function NormsListController(NormService) {
    var vm = this;
    vm.clients = NormService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('NormsListController',
      [
        'NormService',
        NormsListController
      ]
    );

  //ReferencesListController.js
  /**
   * @name ReferencesListController
   * @constructor
   * @desc Controla la vista para el listado de Referencias
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} ReferenceService - Proveedor de datos, Referencias
   */
  function ReferencesListController(ReferenceService) {
    var vm = this;
    vm.ReferencesList = ReferenceService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('ReferencesListController',
      [
        'ReferenceService',
        ReferencesListController
      ]
    );

  //MethodsListController.js
  /**
   * @name MethodsListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Métodos
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} MethodService - Proveedor de datos, Métodos
   */
  function MethodsListController(MethodService) {
    var vm = this;
    vm.methodsList = MethodService.get();

    vm.selectRow = selectRow;
    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('MethodsListController',
      [
        'MethodService',
        MethodsListController
      ]
    );

  //PricesListController.js
  /**
   * @name PricesListController
   * @constructor
   * @desc Controla la vista para el listado de Precios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} PriceService - Proveedor de datos, Precios
   */
  function PricesListController(PriceService) {
    var vm = this;
    vm.pricesList = PriceService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('PricesListController',
      [
        'PriceService',
        PricesListController
      ]
    );

  //UsersListController.js
  /**
   * @name UsersListController
   * @constructor
   * @desc Controla la vista para el listado de Usuarios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} UserService - Proveedor de datos, Usuarios
   */
  function UsersListController (UserService) {
    var vm = this;
    vm.users = UserService.get();
  }
  angular
    .module('sislabApp')
    .controller('UsersListController',
      [
        'UserService',
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
        ClientsListController
      ]
    );