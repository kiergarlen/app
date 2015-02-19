/**
 * @name TaskService
 * @constructor
 * @desc Proveedor de datos, Bienvenida
 * @param {Object} $resource- Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function TaskService($resource){
  return $resource('models/tasks.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('TaskService', ['$resource', TaskService]);