/**
 * @name NormService
 * @constructor
 * @desc Proveedor de datos, Normas referencia
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function NormService($resource) {
  return $resource('models/normas.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('NormService', ['$resource', NormService]);