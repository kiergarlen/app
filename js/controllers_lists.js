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

  //SampleListController.js
  /**
   * @name SampleListController
   * @constructor
   * @desc Controla la vista para el listado de Muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} SampleService - Proveedor de datos, Muestras
   */
  function SampleListController(SampleService) {
    var vm = this;
    vm.pricesList = SampleService.get();
    vm.selectRow = selectRow;

    function selectRow() {

    }
  }
  angular
    .module('sislabApp')
    .controller('SampleListController',
      [
        'SampleService',
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

  //AnalysiListController.js
  /**
   * @name AnalysiListController
   * @constructor
   * @desc Controla la vista para la búsqueda de Análisis
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} AnalysisService - Proveedor de datos, Análisis
   */
  function AnalysiListController(AnalysisService) {
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
    .controller('AnalysiListController',
      [
        'AnalysisService',
        AnalysiListController
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