//CONTROLLERS


/**
 * @name LoginController
 * @desc Controla la vista para Login
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
 * @param {Function} LoginService - Proveedor de datos, Login
 */
function LoginController($scope, $http, Loginservice) {
  var vm = this;
  vm.message = '';
  vm.user = {
    username: '',
    password: ''
  };

  vm.submit = function(msg, usr, pwd) {
    msg = [
      msg,
      ', USER: ',
      usr,
      ' PASSWORD: ',
      pwd
    ].join('');
    return msg;
  };

  vm.login = function() {
    if (vm.loginForm.$valid)
    {
      if (vm.user.username == 'rgarcia' &&
        vm.user.password == '123'
      )
      {
        vm.message = 'Enviando datos secretos...';
        vm.submit(
          vm.message,
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
  };
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

/**
 * @name MenuController
 * @desc Controla la vista para el Menú principal
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Function} MenuService - Proveedor de datos, Menú
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
  );

/**
 * @name TasksController
 * @desc Controla la vista para Bienvenida (Tablero de Tareas)
 * @param {Function} TaskService - Proveedor de datos, Tareas
 */
function TasksController(TaskService) {
  //TODO: construir Tablero de Tareas del usuario
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
  );

/**
 * @name ClientsListController
 * @desc Controla la vista para el listado de Clientes
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Function} ClientService - Proveedor de datos, Cliente
 */
function ClientsListController($scope, ClientService) {
  $scope.clients = ClientService.query();
}

angular
  .module('siclabApp')
  .controller('ClientsListController',
    [
      '$scope',
      'ClientService',
      ClientsListController
    ]
  );

/**
 * @name ClientDetailController
 * @desc Controla la vista para con el detalle de un Cliente
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Function} ClientDetailService - Proveedor de datos, Detalle Cliente
 */
function ClientDetailController($scope, ClientDetailService) {
  $scope.clientDetail = ClientDetailService.query();
}

angular
  .module('siclabApp')
  .controller('ClientDetailController',
    [
      '$scope',
      'ClientDetailService',
      ClientsListController
    ]
  );

/**
 * @name DepartmentsListController
 * @desc Controla la vista para el listado de Áreas
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Function} DepartmentService - Proveedor de datos, Áreas
 */
function DepartmentsListController($scope, DepartmentService) {
  $scope.departments = DepartmentService.query();
}

angular
  .module('siclabApp')
  .controller('DepartmentsListController',
    [
      '$scope',
      'DepartmentService',
      DepartmentsListController
    ]
  );

/**
 * @name EmployeesListController
 * @desc Controla la vista para el listado de Empleados
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Function} EmployeeService - Proveedor de datos, Empleados
 */
function EmployeesListController($scope, EmployeeService) {
  $scope.employees = EmployeeService.query();
}

angular
  .module('siclabApp')
  .controller('EmployeesListController',
    [
      '$scope',
      'EmployeeService',
      EmployeesListController
    ]
  );

/**
 * @name UsersListController
 * @desc Controla la vista para el listado de Usuarios
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Function} UserService - Proveedor de datos, Usuarios
 */
function UsersListController ($scope, UserService) {
  $scope.users = UserService.query();
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

/**
 * @name NormsListController
 * @desc Controla la vista para el listado de Normas
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 * @param {Function} NormService - Proveedor de datos, Normas
 */
function NormsListController($scope, NormService) {
  $scope.norms = NormService.query();
}

angular
  .module('siclabApp')
  .controller('NormsListController',
  [
    '$scope',
    'NormService',
    NormsListController
  ]
  );

/**
 * @name QuoteController
 * @desc Controla la vista para capturar una Solicitud/Cotización
 * @param {Function} ClientService - Proveedor de datos, Clientes
 * @param {Function} ParameterService - Proveedor de datos, Parámetros
 * @param {Function} NormService - Proveedor de datos, Normas
 * @param {Function} SamplingTypeService - Proveedor de datos, Tipos muestreo
 * @param {Function} QuoteService - Proveedor de datos, Cotizaciones
 */
function QuoteController(ClientService, ParameterService, NormService,
  SamplingTypeService, QuoteService) {
  var vm = this;
  vm.clients = ClientService.query();
  vm.parameters = ParameterService.query();
  vm.norms = NormService.query();
  vm.samplingTypes = SamplingTypeService.query();
  vm.quote = QuoteService.query();
  vm.clientDetailsIsShown = false;
  vm.totalCost = 0;

  vm.toggleClientInfo = function() {
    var id = vm.quote.id_cliente;
    vm.clientDetailsIsShown = (
      vm.quote.id_cliente > 0 &&
      vm.selectClient(id).cliente &&
      !vm.clientDetailsIsShown
    );
  };

  vm.selectClient = function(idClient) {
    var i = 0, l = vm.clients.length;
    vm.quote.cliente = {};
    for (i; i < l; i += 1) {
      if (vm.clients[i].id_cliente == idClient)
      {
        vm.quote.cliente = vm.clients[i];
        break;
      }
    }
    return vm.quote.cliente;
  };

  vm.totalParameter = function(){
    var t = 0;
    angular.forEach(vm.parameters, function(s){
      if(s.selected)
      {
        t += parseFloat(s.precio);
      }
    });
    t = t * vm.quote.cliente.tasa;
    vm.totalCost = (Math.round(t * 100) / 100);
    vm.quote.total = vm.totalCost;
    return vm.totalCost;
  };

  vm.selectNorm = function(idNorm) {
    var i, l, j, m;
    l = vm.norms.length;
    vm.quote.norma = {};
    vm.quote.parametros_seleccionados = [];
    for (i = 0; i < l; i += 1) {
      if (vm.norms[i].id_norma == idNorm)
      {
        vm.quote.norma = vm.norms[i];
        break;
      }
    }
    vm.selectNormParameters();
    return '';
  };

  vm.selectNormParameters = function() {
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
  };

  vm.submitQuoteForm = function () {

  };
}

angular
  .module('siclabApp')
  .controller('QuoteController',
    [
      'ClientService', 'ParameterService', 'NormService',
      'SamplingTypeService', 'QuoteService',
      QuoteController
    ]
  );

/**
 * @name SamplingOrderController
 * @desc Controla la vista para capturar una Orden de muestreo
 * @param {Function} QuoteService - Proveedor de datos, Cotizaciones
 * @param {Function} OrderSourceService - Proveedor de datos, Orígenes orden
 * @param {Function} MatrixService - Proveedor de datos, Tipos matriz
 * @param {Function} ParameterService - Proveedor de datos, Parámetros
 * @param {Function} SamplingSupervisorService - Proveedor de datos, Supervisores
 * @param {Function} SamplingOrderService - Proveedor de datos, Orden muestreo
 */
function SamplingOrderController(QuoteService, OrderSourceService,
  MatrixService, ParameterService, SamplingSupervisorService,
  SamplingOrderService) {
  var m = this;
  vm.order = SamplingOrderService.query();
  vm.quote = QuoteService.query();
  vm.orderSources = OrderSourceService.query();
  vm.matrices = MatrixService.query();
  vm.supervisors = SamplingSupervisorService.query();
  vm.parameters = ParameterService.query();

  vm.selectOrderSource = function(idSource) {
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
  };

  vm.selectMatrix = function(idMatrix) {
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
  };

  vm.selectSupervisor = function(idSupervisor) {
  var i = 0, l = vm.supervisors.length;
    vm.order.id_responsable_muestreo = {};
    for (i; i < l; i += 1) {
      if (vm.supervisors[i].id_id_responsable_muestreo == idSupervisor)
      {
        vm.order.id_responsable_muestreo = vm.supervisors[i];
        break;
      }
    }
    return vm.order.id_responsable_muestreo;
  };

  vm.validateOrderForm = function() {

  };

  vm.submitOrderForm = function() {

  };
}

angular
  .module('siclabApp')
  .controller('SamplingOrderController',
    [
      'QuoteService','OrderSourceService','MatrixService',
      'ParameterService','SamplingSupervisorService','SamplingOrderService',
      SamplingPlanController
    ]
  );

/**
 * @name SamplingPlanController
 * @desc Controla la vista para capturar un Plan de muestreo
 * @param {Object} $scope - Contenedor para el modelo [AngularJS]
 */
function SamplingPlanController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('SamplingPlanController',
    [
      '$scope',
      SamplingPlanController
    ]
  );