//SERVICES

function TaskService($resource){
  return $resource('models/tasks.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('TaskService', ['$resource', TaskService]);

function LoginService($resource) {
  return $resource('models/login.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('LoginService', ['$resource', LoginService]);

function MenuService($resource) {
  return $resource('models/menu.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('MenuService', ['$resource', MenuService]);

function ClientDetailService($resource) {
  return $resource('models/clients/:clientId.json', {}, {
    query: {method:'GET', params:{clientId:'id_cliente'}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ClientDetailService', ['$resource',  ClientDetailService]);

function ClientService($resource) {
  return $resource('models/clients.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ClientService', ['$resource', ClientService]);

function DepartmentService($resource) {
  return $resource('models/areas.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('DepartmentService', ['$resource', DepartmentService]);

function EmployeeService($resource) {
  return $resource('models/empleados.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('EmployeeService', ['$resource', EmployeeService]);

function UserService($resource) {
  return $resource('models/usuarios.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('UserService', ['$resource', UserService]);

function ParameterService($resource) {
  return $resource('models/parametros.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ParameterService', ['$resource', ParameterService]);

function NormService($resource) {
  return $resource('models/normas.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('NormService', ['$resource', NormService]);

function SamplingTypeService($resource) {
  return $resource('models/sampling/types.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('SamplingTypeService', ['$resource', SamplingTypeService]);

function QuoteService($resource) {
  return $resource('models/quotes/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('QuoteService', ['$resource', QuoteService]);

function OrderSourceService($resource) {
  return $resource('models/order_sources.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('OrderSourceService', ['$resource', OrderSourceService]);

function MatrixService($resource) {
  return $resource('models/matrices.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('MatrixService', ['$resource', MatrixService]);

function SamplingSupervisorService($resource) {
  return $resource('models/sampling_supervisors.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('SamplingSupervisorService', ['$resource', SamplingSupervisorService]);

function OrderService($resource) {
  return $resource('models/sampling/orders/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('OrderService', ['$resource', OrderService]);

function ReceptionService($resource) {
  return $resource('models/sampling/samples/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('ReceptionService', ['$resource', ReceptionService]);

function ReceptionistService($resource) {
  return $resource('models/receptionists.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ReceptionistService', ['$resource', ReceptionistService]);

function CloudService($resource) {
  return $resource('models/clouds.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('CloudService', ['$resource', CloudService]);


function WindService($resource) {
  return $resource('models/winds.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('WindService', ['$resource', WindService]);


function WaveService($resource) {
  return $resource('models/waves.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('WaveService', ['$resource', WaveService]);


function SamplingNormService($resource) {
  return $resource('models/sampling_norms.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('SamplingNormService', ['$resource', SamplingNormService]);


function PointService($resource) {
  return $resource('models/points.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PointService', ['$resource', PointService]);


function FieldParameterService($resource) {
  return $resource('models/field_parameters.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('FieldParameterService', ['$resource', FieldParameterService]);


function PreservationService($resource) {
  return $resource('models/preservations.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PreservationService', ['$resource', PreservationService]);

function FieldSheetService($resource) {
  return $resource('models/field_sheets/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('FieldSheetService', ['$resource', FieldSheetService]);

function CustodyController($resource) {
  return $resource('models/custodies/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('CustodyController', ['$resource', CustodyController]);