/**
 * @name MethodsService
 * @constructor
 * @desc Proveedor de datos, Métodos
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function MethodsService($resource) {
  return $resource('models/methods.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('MethodsService', ['$resource', MethodsService]);