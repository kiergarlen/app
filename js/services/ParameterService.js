/**
 * @name ParameterService
 * @constructor
 * @desc Proveedor de datos, Parámetros análisis
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ParameterService($resource) {
  return $resource('models/parameters.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ParameterService', ['$resource', ParameterService]);