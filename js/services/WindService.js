/**
 * @name WindService
 * @constructor
 * @desc Proveedor de datos, Direcciones viento
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function WindService($resource) {
  return $resource('models/winds.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('WindService', ['$resource', WindService]);