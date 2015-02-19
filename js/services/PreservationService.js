/**
 * @name PreservationService
 * @constructor
 * @desc Proveedor de datos, Preservaciones
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function PreservationService($resource) {
  return $resource('models/preservations.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PreservationService', ['$resource', PreservationService]);