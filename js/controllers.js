/**
 * @name AnalysisController
 * @constructor
 * @desc Controla la vista para seleccionar formato de captura de Análisis
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} DepartmentService - Proveedor de datos, Áreas
 * @param {Object} ParameterService - Proveedor de datos, Parámetros
 * @param {Object} AnalysisService - Proveedor de datos, selección de formato de captura de Análisis
 */
function AnalysisController(DepartmentService, ParameterService, AnalysisService) {
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
  .module('siclabApp')
  .controller('AnalysisController',
    [
      'DepartmentService', 'ParameterService',
      'AnalysisService',
      AnalysisController
    ]
  );;
/**
 * @name AnalysisListController
 * @constructor
 * @desc Controla la vista para la búsqueda de Análisis
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
  .module('siclabApp')
  .controller('AnalysisListController',
    [
      'AnalysisListService',
      AnalysisListController
    ]
  );;
/**
 * @name ClientDetailController
 * @constructor
 * @desc Controla la vista para con el detalle de un Cliente
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ClientDetailService - Proveedor de datos, Detalle cliente
 */
function ClientDetailController($scope, ClientDetailService) {
  var vm = this;
  vm.clientDetail = ClientDetailService.query();
}

angular
  .module('siclabApp')
  .controller('ClientDetailController',
    [
      '$scope',
      'ClientDetailService',
      ClientsListController
    ]
  );;
/**
 * @name ClientsListController
 * @constructor
 * @desc Controla la vista para el listado de Clientes
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ClientService - Proveedor de datos, Cliente
 */
function ClientsListController(ClientService) {
  var vm = this;
  vm.clients = ClientService.query();
}

angular
  .module('siclabApp')
  .controller('ClientsListController',
    [
      'ClientService',
      ClientsListController
    ]
  );
;
/**
 * @name ContainersListController
 * @constructor
 * @desc Controla la vista para consulta de Recipientes
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
  .module('siclabApp')
  .controller('ContainersListController',
    [
      'ContainersListService',
      ContainersListController
    ]
  );;
/**
 * @name CustodyController
 * @constructor
 * @desc Controla la vista para capturar las Hojas de custodia
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PreservationService - Proveedor de datos, Preservaciones
 * @param {Object} ExpirationService - Proveedor de datos, Vigencias
 * @param {Object} RequiredVolumeService - Proveedor de datos, Volúmenes requeridos
 * @param {Object} ContainerService - Proveedor de datos, Recipientes
 * @param {Object} CheckerService - Proveedor de datos, Responsables verificación
 * @param {Object} CustodyService - Proveedor de datos, Cadenas custodia
 */
function CustodyController(PreservationService, ExpirationService,
  RequiredVolumeService, ContainerService, CheckerService,
  CustodyService) {
  var vm = this;
  vm.preservations = PreservationService.query();
  vm.expirations = ExpirationService.query();
  vm.volumes = RequiredVolumeService.query();
  vm.containers = ContainerService.query();
  vm.checkers = CheckerService.query();
  vm.custody = CustodyService.query();

  vm.selectChecker = selectChecker;

  vm.validateCustodyForm = validateCustodyForm;
  vm.submitCustodyForm = submitCustodyForm;

  function selectItemFromCollection(id, collection, field) {
    var i = 0, l = collection.length,
    item = {};
    for (i; i < l; i += 1) {
      if (collection[i][field] == id)
      {
        item = collection[i];
        break;
      }
    }
    return item;
  }

  function selectChecker(idChecker) {
    selectItemFromCollection(
      idChecker,'id_responsable_verificacion', vm.checkers
    );
  }

  function validateCustodyForm() {

  }

  function submitCustodyForm () {

  }
}

angular
  .module('siclabApp')
  .controller('CustodyController',
    [
      'PreservationService', 'ExpirationService', 'RequiredVolumeService',
      'ContainerService', 'CheckerService', 'CustodyService',
      CustodyController
    ]
  );;
/**
 * @name DepartmentsListController
 * @constructor
 * @desc Controla la vista para el listado de Áreas
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} DepartmentService - Proveedor de datos, Áreas
 */
function DepartmentsListController(DepartmentService) {
  var vm = this;
  vm.departments = DepartmentService.query();
}

angular
  .module('siclabApp')
  .controller('DepartmentsListController',
    [
      'DepartmentService',
      DepartmentsListController
    ]
  );;
/**
 * @name EmployeesListController
 * @constructor
 * @desc Controla la vista para el listado de Empleados
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} EmployeeService - Proveedor de datos, Empleados
 */
function EmployeesListController(EmployeeService) {
	var vm = this;
  vm.employees = EmployeeService.query();
}

angular
  .module('siclabApp')
  .controller('EmployeesListController',
    [
      'EmployeeService',
      EmployeesListController
    ]
  );;
/**
 * @name FieldSheetController
 * @constructor
 * @desc Controla la vista para capturar la hoja de campo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} CloudService - Proveedor de datos, Coberturas nubes
 * @param {Object} WindService - Proveedor de datos, Direcciones viento
 * @param {Object} WaveService - Proveedor de datos, Intensidades oleaje
 * @param {Object} SamplingNormService - Proveedor de datos, Normas muestreo
 * @param {Object} PointService - Proveedor de datos, Puntos muestreo
 * @param {Object} FieldParameterService - Proveedor de datos, Parámetros campo
 * @param {Object} PreservationService - Proveedor de datos, Preservaciones
 * @param {Object} FieldSheetService - Proveedor de datos, Hojas de campo
 */
function FieldSheetController(CloudService, WindService, WaveService,
  SamplingNormService, PointService, FieldParameterService,
  PreservationService, FieldSheetService) {
  var vm = this;
  vm.fieldSheet = FieldSheetService.query();
  vm.cloudCovers = CloudService.query();
  vm.windDirections = WindService.query();
  vm.waveIntensities = WaveService.query();
  vm.samplingNorms = SamplingNormService.query();
  vm.points = PointService.query();
  vm.fieldParameters = FieldParameterService.query();
  vm.preservations = PreservationService.query();

  vm.temp1 = 0;
  vm.temp2 = 0;
  vm.temp3 = 0;
  vm.temp = 0;
  vm.tempAmb1 = 0;
  vm.tempAmb2 = 0;
  vm.tempAmb3 = 0;
  vm.tempAmb = 0;
  vm.ph1 = 0;
  vm.ph2 = 0;
  vm.ph3 = 0;
  vm.ph = 0;
  vm.cond1 = 0;
  vm.cond2 = 0;
  vm.cond3 = 0;
  vm.cond = 0;
  vm.od1 = 0;
  vm.od2 = 0;
  vm.od3 = 0;
  vm.od = 0;
  vm.cr1 = 0;
  vm.cr2 = 0;
  vm.cr3 = 0;
  vm.cr = 0;

  vm.tempAvg = tempAvg;
  vm.tempAmbAvg = tempAmbAvg;
  vm.phAvg = phAvg;
  vm.condAvg = condAvg;
  vm.odAvg = odAvg;
  vm.crAvg = crAvg;

  vm.selectCloudCover = selectCloudCover;
  vm.selectWindDirection = selectWindDirection;
  vm.selectWaveIntensity = selectWaveIntensity;
  vm.selectSamplingNorm = selectSamplingNorm;
  vm.selectPoint = selectPoint;

  vm.validateFieldSheetForm = validateFieldSheetForm;
  vm.submitFieldSheetForm = submitFieldSheetForm;

  function selectItemFromCollection(id, collection, field) {
    var i = 0,
    l = collection.length,
    item = {};
    for (i; i < l; i += 1) {
      if (collection[i][field] == id)
      {
        item = collection[i];
        break;
      }
    }
    return item;
  }

  function averageFromArray(arr) {
    var i = 0,
    l = arr.length,
    sum = 0;
    if (l < 1)
    {
      return 0;
    }
    for (i; i < l; i++) {
      sum += parseFloat(arr[i]);
    }
    return Math.round((sum / l) * 1000 * 1000) / (1000 * 1000);
  }

  function tempAvg(){
    vm.temp = averageFromArray([
      vm.temp1,
      vm.temp2,
      vm.temp3
    ]);
    return vm.temp;
  }

  function tempAmbAvg(){
    vm.tempAmb = averageFromArray([
      vm.tempAmb1,
      vm.tempAmb2,
      vm.tempAmb3
    ]);
    return vm.tempAmb;
  }

  function phAvg() {
    vm.ph = averageFromArray([
      vm.ph1,
      vm.ph2,
      vm.ph3
    ]);
    return vm.ph;
  }

  function condAvg() {
    vm.cond = averageFromArray([
      vm.cond1,
      vm.cond2,
      vm.cond3
    ]);
    return vm.cond;
  }

  function odAvg() {
    vm.od = averageFromArray([
      vm.od1,
      vm.od2,
      vm.od3
    ]);
    return vm.od;
  }

  function crAvg() {
    vm.cr = averageFromArray([
      vm.cr1,
      vm.cr2,
      vm.cr3
    ]);
    return vm.cr;
  }

  function selectCloudCover(idCloud) {
    selectItemFromCollection(
      idCloud,'id_cobertura_nubes', vm.cloudCovers
    );
  }

  function selectWindDirection(idWind) {
    selectItemFromCollection(
      idWind,'id_direccion_viento', vm.windDirections
    );
  }

  function selectWaveIntensity(idWave) {
    selectItemFromCollection(
      idWave,'id_oleaje', vm.waveIntensities
    );
  }

  function selectSamplingNorm(idNorm) {
    selectItemFromCollection(
      idNorm,'id_metodo_muestreo', vm.samplingNorms
    );
  }

  function selectPoint(idPoint) {
    selectItemFromCollection(
      idPoint,'id_punto_muestreo', vm.points
    );
  }

  function validateFieldSheetForm() {

  }

  function submitFieldSheetForm() {

  }
}

angular
  .module('siclabApp')
  .controller('FieldSheetController',
    [
      'CloudService', 'WindService', 'WaveService',
      'SamplingNormService', 'PointService', 'FieldParameterService',
      'PreservationService', 'FieldSheetService',
      FieldSheetController
    ]
  );;
/**
 * @name InstrumentsListController
 * @constructor
 * @desc Controla la vista para consulta de Equipos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} InstrumentsListService - Proveedor de datos, lista Equipos
 */
function InstrumentsListController(InstrumentsListService) {
  var vm = this;
  vm.clients = InstrumentsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('InstrumentsListController',
    [
      'InstrumentsListService',
      InstrumentsListController
    ]
  );;
/**
 * @name LoginController
 * @constructor
 * @desc Controla la vista para Login
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
 * @param {Object} LoginService - Proveedor de datos, Login
 */
function LoginController($scope, $http, Loginservice) {
  var vm = this;
  vm.message = '';
  vm.user = {username: '', password: ''};
  vm.submit = submitMessage;
  vm.login = login;

  function submitMessage(msg, usr, pwd) {
    msg = [
      msg,
      ' USER: ',
      usr,
      ' PASSWORD: ',
      pwd
    ].join('');
    return msg;
  }

  function login() {
    if ($scope.loginForm.$valid)
    {
      if (vm.user.username == 'rgarcia' &&
        vm.user.password == 'rgarcia'
      )
      {
        vm.message = 'Enviando...';
        vm.submit(
          '',
          vm.user.username,
          vm.user.password
        );
      }
      else
      {
        vm.message = 'Usuario o contraseña incorrectos';
      }
    }
    else
    {
      vm.message = 'Debe ingresar usuario y/o contraseña';
    }
  }
}

angular
  .module('siclabApp')
  .controller('LoginController',
    [
      '$scope', '$http',
      'LoginService',
      LoginController
    ]
  );
;
/**
 * @name LogoutController
 * @constructor
 * @desc Controla la vista para Logout
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} LogoutService - Proveedor de datos, Logout
 */
function LogoutController(LogoutService) {
  var vm = this;
  vm.logout = LogoutService.query();
}

angular
  .module('siclabApp')
  .controller('LogoutController',
    [
      'LogoutService',
      LogoutController
    ]
  );;
/**
 * @name MenuController
 * @constructor
 * @desc Controla la vista para el Menú principal
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} MenuService - Proveedor de datos, Menú
 */
function MenuController($scope, MenuService) {
  $scope.menu = MenuService.query();
}

angular
  .module('siclabApp')
  .controller('MenuController',
    [
      '$scope',
      'MenuService',
      MenuController
    ]
  );;
/**
 * @name MethodsListController
 * @constructor
 * @desc Controla la vista para la búsqueda de Métodos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
  .module('siclabApp')
  .controller('MethodsListController',
    [
      'MethodsListService',
      MethodsListController
    ]
  );;
/**
 * @name NormsListController
 * @constructor
 * @desc Controla la vista para consulta de Normas
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
  .module('siclabApp')
  .controller('NormsListController',
    [
      'NormsListService',
      NormsListController
    ]
  );
;
/**
 * @name OrderController
 * @constructor
 * @desc Controla la vista para capturar una Orden de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
 * @param {Object} OrderSourceService - Proveedor de datos, Orígenes orden
 * @param {Object} MatrixService - Proveedor de datos, Tipos matriz
 * @param {Object} ParameterService - Proveedor de datos, Parámetros
 * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
 * @param {Object} OrderService - Proveedor de datos, Orden muestreo
 */
function OrderController(QuoteService, OrderSourceService,
  MatrixService, ParameterService, SamplingSupervisorService,
  OrderService) {
  var vm = this;
  vm.order = OrderService.query();
  vm.quote = QuoteService.query();
  vm.orderSources = OrderSourceService.query();
  vm.matrices = MatrixService.query();
  vm.supervisors = SamplingSupervisorService.query();
  vm.parameters = ParameterService.query();
  vm.parametersDetailVisible = false;

  vm.toggleParametersDetail = toggleParametersDetail;
  vm.selectOrderSource = selectOrderSource;
  vm.selectMatrix = selectMatrix;
  vm.selectSupervisor = selectSupervisor;
  vm.validateOrderForm = validateOrderForm;
  vm.submitOrderForm = submitOrderForm;

  function toggleParametersDetail() {
    vm.parametersDetailVisible = !vm.parametersDetailVisible;
  }

  function selectOrderSource(idSource) {
    var i = 0, l = vm.orderSources.length;
    vm.order.origen_orden = {};
    for (i; i < l; i += 1) {
      if (vm.orderSources[i].id_origen_orden == idSource)
      {
        vm.order.origen_orden = vm.orderSources[i];
        break;
      }
    }
    return vm.order.origen_orden;
  }

  function selectMatrix(idMatrix) {
    var i = 0, l = vm.matrices.length;
    vm.order.matriz = {};
    for (i; i < l; i += 1) {
      if (vm.matrices[i].id_matriz == idMatrix)
      {
        vm.order.matriz = vm.matrices[i];
        break;
      }
    }
    return vm.order.matriz;
  }

  function selectSupervisor(idSupervisor) {
    var i = 0, l = vm.supervisors.length;
    vm.order.id_supervisor_muestreo = {};
    for (i; i < l; i += 1) {
      if (vm.supervisors[i].id_id_supervisor_muestreo == idSupervisor)
      {
        vm.order.id_supervisor_muestreo = vm.supervisors[i];
        break;
      }
    }
    return vm.order.id_supervisor_muestreo;
  }

  function validateOrderForm() {

  }

  function submitOrderForm() {

  }
}

angular
  .module('siclabApp')
  .controller('OrderController',
    [
      'QuoteService','OrderSourceService','MatrixService',
      'ParameterService','SamplingSupervisorService','OrderService',
      OrderController
    ]
  );;
/**
 * @name PlanCheckController
 * @constructor
 * @desc Controla la vista para capturar la verificación de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanCheckController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanCheckController',
    [
      '$scope',
      PlanCheckController
    ]
  );;
/**
 * @name PlanContainersController
 * @constructor
 * @desc Controla la vista para capturar los recipientes de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanContainersController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanContainersController',
    [
      '$scope',
      PlanContainersController
    ]
  );;
/**
 * @name PlanController
 * @constructor
 * @desc Controla la vista para capturar un Plan muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PlanObjectivesService - Proveedor de datos, Objetivos Plan muestreo
 * @param {Object} PointKindsService - Proveedor de datos, tipos Punto
 * @param {Object} DistrictService - Proveedor de datos, Municipios
 * @param {Object} CityService - Proveedor de datos, Localidades
 * @param {Object} PreservationService - Proveedor de datos, Preservaciones
 * @param {Object} ContainerService - Proveedor de datos, Recipientes
 * @param {Object} ReactivesListService - Proveedor de datos, lista Reactivos
 * @param {Object} MaterialService - Proveedor de datos, Material
 * @param {Object} CoolerService - Proveedor de datos, lista Hieleras
 * @param {Object} PlanService - Proveedor de datos, Plan muestreo
 */
function PlanController(PlanObjectivesService, PointKindsService,
  DistrictService, CityService, PreservationService,
  ContainerService, ReactivesListService, MaterialService,
  CoolerService,
  PlanService) {
  var vm = this;
  vm.plan = PlanService.query();
  vm.objectives = PlanObjectivesService.query();
  vm.pointKinds = PointKindsService.query();
  vm.districts = DistrictService.query();
  vm.cities = CityService.query(vm.plan.id_municipio);
  vm.preservations = PreservationService.query();
  vm.reactives = ReactivesListService.query();
  vm.containers = ContainerService.query();
  vm.materials = MaterialService.query();
  vm.coolers = CoolerService.query();
  vm.addPoints = addPoints;

  vm.selectObjective = selectObjective;
  vm.selectPointType = selectPointType;
  vm.selectDistrict = selectDistrict;

  vm.selectSamplingSupervisor = selectSamplingSupervisor;
  vm.selectCollectingSupervisor = selectCollectingSupervisor;
  vm.selectLoggingSupervisor = selectLoggingSupervisor;

  function selectItemFromCollection(id, collection, field) {
    var i = 0,
    l = collection.length,
    item = {};
    for (i; i < l; i += 1) {
      if (collection[i][field] == id)
      {
        item = collection[i];
        break;
      }
    }
    return item;
  }

  function addPoints() {

  }

  function selectObjective() {

  }

  function selectPointType() {

  }

  function selectDistrict() {
    vm.cities = CityService.query(vm.plan.id_municipio);
  }

  function selectSamplingSupervisor() {

  }

  function selectCollectingSupervisor() {

  }

  function selectLoggingSupervisor() {

  }
  //
}

angular
  .module('siclabApp')
  .controller('PlanController',
    [
      'PlanObjectivesService', 'PointKindsService',
      'DistrictService', 'CityService', 'PreservationService',
      'ContainerService', 'ReactivesListService', 'MaterialService',
      'CoolerService',
      'PlanService',
      PlanController
    ]
  );;
/**
 * @name PlanCoolersController
 * @constructor
 * @desc Controla la vista para capturar las hieleras de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanCoolersController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanCoolersController',
    [
      '$scope',
      PlanCoolersController
    ]
  );;
/**
 * @name PlanMaterialsController
 * @constructor
 * @desc Controla la vista para capturar los materiales de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanMaterialsController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanMaterialsController',
    [
      '$scope',
      PlanMaterialsController
    ]
  );;
/**
 * @name PlanSubstancesController
 * @constructor
 * @desc Controla la vista para capturar los reactivos de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanSubstancesController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanSubstancesController',
    [
      '$scope',
      PlanSubstancesController
    ]
  );
;
/**
 * @name PointsListController
 * @constructor
 * @desc Controla la vista para consulta de Puntos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PointsListService - Proveedor de datos, lista Puntos
 */
function PointsListController(PointsListService) {
  var vm = this;
  vm.points = PointsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('PointsListController',
    [
      'PointsListService',
      PointsListController
    ]
  );;
/**
 * @name PricesListController
 * @constructor
 * @desc Controla la vista para consulta de Precios
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
  .module('siclabApp')
  .controller('PricesListController',
    [
      'PricesListService',
      PricesListController
    ]
  );;
/**
 * @name ProfileController
 * @constructor
 * @desc Controla la vista para Perfil
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ProfileService - Proveedor de datos, Perfil
 */
function ProfileController(ProfileService) {
  var vm = this;
  vm.profile = ProfileService.query();
}

angular
  .module('siclabApp')
  .controller('ProfileController',
    [
      'ProfileService',
      ProfileController
    ]
  );;
/**
 * @name QuoteController
 * @constructor
 * @desc Controla la vista para capturar una Solicitud/Cotización
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ClientService - Proveedor de datos, Clientes
 * @param {Object} ParameterService - Proveedor de datos, Parámetros
 * @param {Object} NormService - Proveedor de datos, Normas
 * @param {Object} SamplingTypeService - Proveedor de datos, Tipos muestreo
 * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
 */
function QuoteController(ClientService, ParameterService, NormService,
  SamplingTypeService, QuoteService) {
  var vm = this;
  vm.clients = ClientService.query();
  vm.parameters = ParameterService.query();
  vm.norms = NormService.query();
  vm.samplingTypes = SamplingTypeService.query();
  vm.quote = QuoteService.query();
  vm.clientDetailVisible = false;
  vm.parametersDetailVisible = false;
  vm.allParametersSelected = false;
  vm.totalCost = 0;

  vm.toggleClientDetail = toggleClientDetail;
  vm.toggleParametersDetail = toggleParametersDetail;
  vm.selectClient = selectClient;
  vm.totalParameter = totalParameter;
  vm.selectNorm = selectNorm;
  vm.selectNormParameters = selectNormParameters;
  vm.selectAllParameters = selectAllParameters;
  vm.selectSamplingType = selectSamplingType;
  vm.submitQuoteForm = submitQuoteForm;

  function selectItemFromCollection(id, collection, field) {
    var i = 0,
    l = collection.length,
    item = {};
    for (i; i < l; i += 1) {
      if (collection[i][field] == id)
      {
        item = collection[i];
        break;
      }
    }
    return item;
  }

  function toggleClientDetail() {
    var id = vm.quote.id_cliente;
    vm.clientDetailVisible = (
      vm.quote.id_cliente > 0 &&
      vm.selectClient(id).cliente &&
      !vm.clientDetailVisible
    );
  }

  function toggleParametersDetail() {
    vm.parametersDetailVisible = !vm.parametersDetailVisible;
  }

  function selectClient() {
    vm.quote.cliente = selectItemFromCollection(
      vm.quote.id_cliente,
      vm.clients,
      'id_cliente'
    );
    return vm.quote.cliente;
  }

  function totalParameter(){
    var i = 0, l = 0, t = 0;
    if (vm.parameters)
    {
      l = vm.parameters.length;
      for (i; i < l; i += 1) {
        if (vm.parameters[i].selected)
        {
          t = t + parseInt(vm.parameters[i].precio, 10);
        }
      }
      t = t * vm.quote.cliente.tasa;
      vm.totalCost = (Math.round(t * 100) / 100);
      vm.quote.total = vm.totalCost;
    }
    return vm.totalCost;
  }

  function selectNorm(idNorm) {
    var i, l;
    l = vm.norms.length;
    vm.quote.norma = {};
    vm.quote.parametros_seleccionados = [];
    vm.quote.allParametersSelected = false;
    for (i = 0; i < l; i += 1) {
      if (vm.norms[i].id_norma == idNorm)
      {
        vm.quote.norma = vm.norms[i];
        break;
      }
    }
    vm.selectNormParameters();
    return '';
  }

  function selectNormParameters() {
    var i, l, j, m;
    l = vm.parameters.length;
    for(i = 0; i < l; i += 1) {
      vm.parameters[i].selected = false;
      if (vm.quote.norma.parametros !== undefined)
      {
        m = vm.quote.norma.parametros.length;
        for (j = 0; j < m; j += 1) {
          if (vm.parameters[i].id_parametro ==
            vm.quote.norma.parametros[j].id_parametro)
          {
            vm.parameters[i].selected = true;
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

  function selectSamplingType() {
    var i, l;
    l = vm.samplingTypes.length;
    for (i = 0; i < l; i += 1) {
      vn.samplingTypes[i].selected =
      (vm.samplingTypes[i].id_tipo_muestreo ==
        vm.quote.id_tipo_muestreo);
    }
  }

  function submitQuoteForm() {

  }
}

angular
  .module('siclabApp')
  .controller('QuoteController',
    [
      'ClientService', 'ParameterService', 'NormService',
      'SamplingTypeService', 'QuoteService',
      QuoteController
    ]
  );;
/**
 * @name ReactivesListController
 * @constructor
 * @desc Controla la vista para consulta de Reactivos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReactivesListService - Proveedor de datos, lista Reactivos
 */
function ReactivesListController(ReactivesListService) {
  var vm = this;
  vm.pricesList = ReactivesListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('ReactivesListController',
    [
      'ReactivesListService',
      ReactivesListController
    ]
  );;
/**
 * @name ReceptionController
 * @constructor
 * @desc Controla la vista para capturar la recepción de muestras
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReceptionistService - Proveedor de datos, Recepcionistas
 * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
 */
function ReceptionController(ReceptionistService, ReceptionService) {
  var vm = this;
  vm.receptionists = ReceptionistService.query();
  vm.reception = ReceptionService.query();

  vm.selectReceptionist = selectReceptionist;
  vm.validateReceptionForm = validateReceptionForm;
  vm.submitReceptionForm = submitReceptionForm;

  function selectReceptionist(idRecepcionist) {
    var i = 0, l = vm.receptionists.length;
    vm.reception.recepcionista = {};
    for (i; i < l; i += 1) {
      if (vm.receptionists[i].id_empleado == idRecepcionist)
      {
        vm.reception.recepcionista = vm.receptionists[i];
        break;
      }
    }
    return vm.reception.recepcionista;
  }

  function validateReceptionForm() {

  }

  function submitReceptionForm() {

  }
}

angular
  .module('siclabApp')
  .controller('ReceptionController',
    [
      'ReceptionistService', 'ReceptionService',
      ReceptionController
    ]
  );;
/**
 * @name ReferencesListController
 * @constructor
 * @desc Controla la vista para consulta de Referencias
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
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
  .module('siclabApp')
  .controller('ReferencesListController',
    [
      'ReferencesListService',
      ReferencesListController
    ]
  );;
/**
 * @name ReportApprovalController
 * @constructor
 * @desc Controla la vista para validación Reporte
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReportApprovalService - Proveedor de datos, validación Reporte
 */
function ReportApprovalController(ReportApprovalService) {
  var vm = this;
  vm.reportApproval = ReportApprovalService.query();


  vm.validateReportApprovalForm = validateReportApprovalForm;
  vm.submitReportApprovalForm = submitReportApprovalForm;

  function validateReportApprovalForm() {

  }

  function submitReportApprovalForm() {

  }
}

angular
  .module('siclabApp')
  .controller('ReportApprovalController',
    [
      'ReportApprovalService',
      ReportApprovalController
    ]
  );;
/**
 * @name ReportsListController
 * @constructor
 * @desc Controla la vista para consulta de Reportes
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReportsListService - Proveedor de datos, lista Reportes
 */
function ReportsListController(ReportsListService) {
  var vm = this;
  vm.pricesList = ReportsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('ReportsListController',
    [
      'ReportsListService',
      ReportsListController
    ]
  );;
/**
 * @name SamplesListController
 * @constructor
 * @desc Controla la vista para consulta de Muestras
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} SamplesListService - Proveedor de datos, lista Muestras
 */
function SamplesListController(SamplesListService) {
  var vm = this;
  vm.pricesList = SamplesListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('SamplesListController',
    [
      'SamplesListService',
      SamplesListController
    ]
  );;
/**
 * @name TaskAssignController
 * @constructor
 * @desc Controla la vista para capturar las Órdenes de trabajo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ChemicalSupervisorService - Proveedor de datos, Supervisores físicoquimico
 * @param {Object} MetalSupervisorService - Proveedor de datos, Supervisores metales pesados
 * @param {Object} BioSupervisorService - Proveedor de datos, Supervisores microbiológico
 * @param {Object} TaskAssignService - Proveedor de datos, Órdenes trabajo
 */
function TaskAssignController(ChemicalSupervisorService,
  MetalSupervisorService, BioSupervisorService, TaskAssignService) {
  var vm = this;
  vm.chemicalSupervisors = ChemicalSupervisorService.query();
  vm.metalSupervisors = MetalSupervisorService.query();
  vm.bioSupervisors = BioSupervisorService.query();
  vm.taskAssign = TaskAssignService.query();

  vm.selectChemicalSupervisor = selectChemicalSupervisor;
  vm.selectMetalSupervisor = selectMetalSupervisor;
  vm.selectSupervisorBio = selectSupervisorBio;

  vm.validateTaskAssignForm = validateTaskAssignForm;
  vm.submitTaskAssignForm = submitTaskAssignForm;

  function selectItemFromCollection(id, collection, field) {
    var i = 0, l = collection.length,
    item = {};
    for (i; i < l; i += 1) {
      if (collection[i][field] == id)
      {
        item = collection[i];
        break;
      }
    }
    return item;
  }

  function selectChemicalSupervisor(idSup) {
    selectItemFromCollection(
      idSup,'id_empleado', vm.chemicalSupervisors
    );
  }

  function selectMetalSupervisor(idSup) {
    selectItemFromCollection(
      idSup,'id_empleado', vm.metalSupervisors
    );
  }

  function selectSupervisorBio(idSup) {
    selectItemFromCollection(
      idSup,'id_empleado', vm.bioSupervisors
    );
  }

  function validateTaskAssignForm() {

  }

  function submitTaskAssignForm () {

  }
}

angular
  .module('siclabApp')
  .controller('TaskAssignController',
    [
      'ChemicalSupervisorService', 'MetalSupervisorService',
      'BioSupervisorService', 'TaskAssignService',
      TaskAssignController
    ]
  );;
/**
 * @name TasksController
 * @constructor
 * @desc Controla la vista para Bienvenida
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} TaskService - Proveedor de datos, Bienvenida
 */
function TasksController(TaskService) {
  var vm = this;
  vm.welcome = TaskService.query();
}

angular
  .module('siclabApp')
  .controller('TasksController',
    [
      'TaskService',
      TasksController
    ]
  );;
/**
 * @name UsersListController
 * @constructor
 * @desc Controla la vista para el listado de Usuarios
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} UserService - Proveedor de datos, Usuarios
 */
function UsersListController (UserService) {
  var vm = this;
  vm.users = UserService.query();
}

angular
  .module('siclabApp')
  .controller('UsersListController',
    [
      '$scope',
      'UserService',
      UsersListController
    ]
  );