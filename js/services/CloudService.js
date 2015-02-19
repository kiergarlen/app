/**
 * @name CloudService
 * @constructor
 * @desc Proveedor de datos, Coberturas nubes
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function CloudService($resource) {
  return $resource('models/clouds.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('CloudService', ['$resource', CloudService]);