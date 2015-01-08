'use strict';

/* Controllers */

var siclabControllers = angular.module('siclabControllers', []);

function LoginController($scope, Loginservice) {
  this.message = '';
  this.user = {
    username: '',
    password: ''
  };

  this.submit = function(form) {
    this.message += ' USR ' + form.username.$modelValue;
    this.message += ' PSW ' + form.password.$modelValue;
  };

  this.login = function() {
    this.message = '...';
    if ($scope.loginForm.$valid)
    {
      if (this.user.username == 'rgarcia' &&
        this.user.password == '123'
      )
      {
        this.message = 'Enviando credenciales secretas...';
        this.submit($scope.loginForm);
      }
      else
      {
        this.message = 'Usuario o contraseña incorrectos';
      }
    }
    else
    {
      this.message = 'Debe ingresar usuario y/o contraseña';
    }
  };
}

siclabControllers.controller('LoginController',
  ['$scope', 'LoginService',
  LoginController
]);

function NavController($scope, MenuService) {
  $scope.menu = MenuService.query();
}

siclabControllers.controller('NavController',
  ['$scope', 'MenuService',
  NavController
]);

function TasksController(TaskService) {
  this.welcome = TaskService.query();
}

siclabControllers.controller('TasksController',
  ['TaskService', TasksController]);

function ClientsListController($scope, ClientService) {
  $scope.clients = ClientService.query();
}

siclabControllers.controller('ClientsListController',
  ['$scope', 'ClientService',
  ClientsListController
]);

function ClientDetailController($scope, ClientDetailService) {
  $scope.clientDetail = ClientDetailService.query();
}

siclabControllers.controller('ClientDetailController',
  ['$scope', 'ClientDetailService',
  ClientsListController
]);

function DepartmentsListController($scope, DepartmentService) {
  $scope.departments = DepartmentService.query();
}

siclabControllers.controller('DepartmentsListController',
  ['$scope', 'DepartmentService',
  DepartmentsListController
]);

function EmployeesListController($scope, EmployeeService) {
  $scope.employees = EmployeeService.query();
}

siclabControllers.controller('EmployeesListController',
  ['$scope', 'EmployeeService',
  EmployeesListController
]);

function UsersListController ($scope, UserService) {
  $scope.users = UserService.query();
}

siclabControllers.controller('UsersListController',
  ['$scope', 'UserService',
  UsersListController
]);

function NormsListController($scope, NormService) {
  $scope.norms = NormService.query();
}

siclabControllers.controller('NormsListController',
  ['$scope', 'NormService',
  NormsListController
]);

function QuoteController(ClientService, ParameterService, NormService,
  SamplingTypeService, QuoteService) {
  this.clients = ClientService.query();
  this.parameters = ParameterService.query();
  this.norms = NormService.query();
  this.samplingTypes = SamplingTypeService.query();
  this.quote = QuoteService.query();
  this.clientDetailsIsShown = false;
  this.totalCost = 0;

  this.toggleClientInfo = function() {
    var id = this.quote.id_cliente;
    this.clientDetailsIsShown = (
      this.quote.id_cliente > 0 &&
      this.selectClient(id).cliente &&
      !this.clientDetailsIsShown
    );
  };

  this.selectClient = function(idClient) {
    var i = 0, l = this.clients.length;
    this.quote.cliente = {};
    for (i; i < l; i += 1) {
      if (this.clients[i].id_cliente == idClient) {
        this.quote.cliente = this.clients[i];
        break;
      }
    }
    return this.quote.cliente;
  };

  this.totalParameter = function(){
    var t = 0;
    angular.forEach(this.parameters, function(s){
      if(s.selected) {
        t += parseFloat(s.precio);
      }
    });
    t = t * this.quote.cliente.tasa;
    this.totalCost = (Math.round(t * 100) / 100);
    this.quote.total = this.totalCost;
    return this.totalCost;
  };

  this.selectNorm = function(idNorm) {
    var i, l, j, m, params;
    l = this.norms.length;
    this.quote.norma = {};
    this.quote.parametros_seleccionados = [];
    for (i = 0; i < l; i += 1) {
      if (this.norms[i].id_norma == idNorm) {
        this.quote.norma = this.norms[i];
        break;
      }
    }
    l = this.parameters.length;
    params = this.quote.norma.parametros;
    for(i = 0; i < l; i += 1) {
      this.parameters[i].selected = false;
      if (params !== undefined) {
        m = params.length;
        for (j = 0; j < m; j += 1) {
          if (this.parameters[i].id_parametro == params[j].id_parametro) {
            this.parameters[i].selected = true;
          }
        }
      }
    }
    return '';
  };

  this.submitQuoteForm = function () {

  };
}

siclabControllers.controller('QuoteController',
 ['ClientService', 'ParameterService', 'NormService',
 'SamplingTypeService', 'QuoteService',
  QuoteController
]);

function SamplingOrderController(QuoteService, OrderSourceService,
  MatrixService, ParameterService, SamplingSupervisorService,
  SamplingOrderService) {
  this.order = SamplingOrderService.query();
  this.quote = QuoteService.query();
  this.orderSources = OrderSourceService.query();
  this.matrices = MatrixService.query();
  this.supervisors = SamplingSupervisorService.query();
  this.parameters = ParameterService.query();

  this.selectOrderSource = function(idSource) {
  var i = 0, l = this.orderSources.length;
    this.order.origen_orden = {};
    for (i; i < l; i += 1) {
      if (this.orderSources[i].id_origen_orden == idSource)
      {
        this.order.origen_orden = this.orderSources[i];
        break;
      }
    }
    return this.order.origen_orden;
  };

  this.selectMatrix = function(idMatrix) {
  var i = 0, l = this.matrices.length;
    this.order.matriz = {};
    for (i; i < l; i += 1) {
      if (this.matrices[i].id_matriz == idMatrix)
      {
        this.order.matriz = this.matrices[i];
        break;
      }
    }
    return this.order.matriz;
  };

  this.selectSupervisor = function(idSupervisor) {
  var i = 0, l = this.supervisors.length;
    this.order.id_responsable_muestreo = {};
    for (i; i < l; i += 1) {
      if (this.supervisors[i].id_id_responsable_muestreo == idSupervisor)
      {
        this.order.id_responsable_muestreo = this.supervisors[i];
        break;
      }
    }
    return this.order.id_responsable_muestreo;
  };

  this.validateOrderForm = function() {

  };

  this.submitOrderForm = function() {

  };
}

siclabControllers.controller('SamplingOrderController',
  ['QuoteService', 'OrderSourceService', 'MatrixService',
  'ParameterService', 'SamplingSupervisorService', 'SamplingOrderService',
  SamplingOrderController
]);

function SamplingPlanController() {
  //
}

siclabControllers.controller('SamplingPlanController',
  [
  SamplingPlanController
]);