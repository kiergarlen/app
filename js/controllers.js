//CONTROLLERS

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

angular
  .module('siclabApp')
  .controller('LoginController',
  ['$scope', 'LoginService',
  LoginController
]);

function NavController($scope, MenuService) {
  $scope.menu = MenuService.query();
}

angular
  .module('siclabApp')
  .controller('NavController',
  ['$scope', 'MenuService',
  NavController
]);

function TasksController(TaskService) {
  this.welcome = TaskService.query();
}

angular
  .module('siclabApp')
  .controller('TasksController',
  ['TaskService', TasksController]);

function ClientsListController($scope, ClientService) {
  $scope.clients = ClientService.query();
}

angular
  .module('siclabApp')
  .controller('ClientsListController',
  ['$scope', 'ClientService',
  ClientsListController
]);

function ClientDetailController($scope, ClientDetailService) {
  $scope.clientDetail = ClientDetailService.query();
}

angular
  .module('siclabApp')
  .controller('ClientDetailController',
  ['$scope', 'ClientDetailService',
  ClientsListController
]);

function DepartmentsListController($scope, DepartmentService) {
  $scope.departments = DepartmentService.query();
}

angular
  .module('siclabApp')
  .controller('DepartmentsListController',
  ['$scope', 'DepartmentService',
  DepartmentsListController
]);

function EmployeesListController($scope, EmployeeService) {
  $scope.employees = EmployeeService.query();
}

angular
  .module('siclabApp')
  .controller('EmployeesListController',
  ['$scope', 'EmployeeService',
  EmployeesListController
]);

function UsersListController ($scope, UserService) {
  $scope.users = UserService.query();
}

angular
  .module('siclabApp')
  .controller('UsersListController',
  ['$scope', 'UserService',
  UsersListController
]);

function NormsListController($scope, NormService) {
  $scope.norms = NormService.query();
}

angular
  .module('siclabApp')
  .controller('NormsListController',
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
    var i = 0,l = this.clients.length;
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

angular
  .module('siclabApp')
  .controller('QuoteController',
 ['ClientService', 'ParameterService', 'NormService',
 'SamplingTypeService', 'QuoteService',
  QuoteController
]);

function SamplingOrderController($scope, QuoteService, OrderSourceService,
  MatrixService, ParameterService, SamplingSupervisorService,
  SamplingOrderService) {
  $scope.order = {};
  $scope.order.order = SamplingOrderService.query();
  $scope.order.quote = QuoteService.query();
  $scope.order.orderSources = OrderSourceService.query();
  $scope.order.matrices = MatrixService.query();
  $scope.order.supervisors = SamplingSupervisorService.query();
  $scope.order.parameters = ParameterService.query();
  $scope.order.selectOrderSource = function() {

  };
  $scope.order.selectMatrix = function() {

  };
  $scope.order.selectSupervisor = function() {

  };
  $scope.order.validateOrderForm = function() {

  };
  $scope.order.submitOrderForm = function() {

  };
}

angular
  .module('siclabApp')
  .controller('SamplingOrderController',
  ['$scope', 'QuoteService', 'OrderSourceService', 'MatrixService',
  'ParameterService', 'SamplingSupervisorService', 'SamplingOrderService',
  SamplingOrderController
]);

function SamplingPlanController() {

}

angular
  .module('siclabApp')
  .controller('SamplingPlanController',
  ['$scope',
  SamplingPlanController
]);