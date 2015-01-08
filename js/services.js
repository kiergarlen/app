'use strict';

/* Services */

var siclabServices = angular.module('siclabServices', ['ngResource']);

siclabServices.factory('TaskService', ['$resource', function($resource){
	return $resource('models/tasks.json', {}, {
		query: {method:'GET', params:{}, isArray:false}
	});
}]);

siclabServices.factory('LoginService', ['$resource', function($resource){
	return $resource('models/login.json', {}, {
		query: {method:'GET', params:{}, isArray:false}
	});
}]);

siclabServices.factory('MenuService', ['$resource', function($resource){
	return $resource('models/menu.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('ClientDetailService', ['$resource', function($resource){
	return $resource('models/clients/:clientId.json', {}, {
		query: {method:'GET', params:{clientId:'id_cliente'}, isArray:true}
	});
}]);

siclabServices.factory('ClientService', ['$resource', function($resource){
	return $resource('models/clients.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('DepartmentService', ['$resource', function($resource){
	return $resource('models/areas.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('EmployeeService', ['$resource', function($resource){
	return $resource('models/empleados.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('UserService', ['$resource', function($resource){
	return $resource('models/usuarios.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('ParameterService', ['$resource', function($resource){
	return $resource('models/parametros.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('NormService', ['$resource', function($resource){
	return $resource('models/normas.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('SamplingTypeService', ['$resource', function($resource){
	return $resource('models/tipos_muestreo.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('QuoteService', ['$resource', function($resource){
	return $resource('models/quotes/1.json', {}, {
		query: {method:'GET', params:{}, isArray:false}
	});
}]);

siclabServices.factory('OrderSourceService', ['$resource', function($resource){
	return $resource('models/order_sources.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('MatrixService', ['$resource', function($resource){
	return $resource('models/matrices.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('SamplingSupervisorService', ['$resource', function($resource){
	return $resource('models/sampling_supervisors.json', {}, {
		query: {method:'GET', params:{}, isArray:true}
	});
}]);

siclabServices.factory('SamplingOrderService', ['$resource', function($resource){
	return $resource('models/sampling/orders/1.json', {}, {
		query: {method:'GET', params:{}, isArray:false}
	});
}]);