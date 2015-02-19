/**
 * @name MethodsListService
 * @constructor
 * @desc Proveedor de datos, Métodos
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function MethodsListService($resource) {
  return $resource('models/methods.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('MethodsListService', ['$resource', MethodsListService]);