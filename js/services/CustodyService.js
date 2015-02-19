/**
 * @name CustodyService
 * @constructor
 * @desc Proveedor de datos, Cadenas custodia
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function CustodyService($resource) {
  return $resource('models/custodies/100.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('CustodyService', ['$resource', CustodyService]);