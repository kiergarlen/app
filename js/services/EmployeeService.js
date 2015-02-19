/**
 * @name EmployeeService
 * @constructor
 * @desc Proveedor de datos, Empleados
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function EmployeeService($resource) {
  return $resource('models/empleados.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('EmployeeService', ['$resource', EmployeeService]);