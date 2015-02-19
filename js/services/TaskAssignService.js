/**
 * @name TaskAssignService
 * @constructor
 * @desc Proveedor de datos, Órdenes trabajo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function TaskAssignService($resource) {
  return $resource('models/taskAssignments/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('TaskAssignService', ['$resource', TaskAssignService]);