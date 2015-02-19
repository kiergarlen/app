/**
 * @name MaterialService
 * @constructor
 * @desc Proveedor de datos, Materiales
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function MaterialService($resource) {
  return $resource('models/materials.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('MaterialService', ['$resource', MaterialService]);