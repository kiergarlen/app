/**
 * @name EmployeesListService
 * @constructor
 * @desc Proveedor de datos, lista Empleados
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function EmployeesListService($resource) {
  return $resource('models/employees_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('EmployeesListService', ['$resource', EmployeesListService]);
