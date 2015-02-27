/**
 * @name SamplingEmployeeService
 * @constructor
 * @desc Proveedor de datos, Empleados muestreo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function SamplingEmployeeService($resource) {
  return $resource('models/sampling_employees.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('SamplingEmployeeService', ['$resource', SamplingEmployeeService]);