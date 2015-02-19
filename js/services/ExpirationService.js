/**
 * @name ExpirationService
 * @constructor
 * @desc Proveedor de datos, Vigencias
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ExpirationService($resource) {
  return $resource('models/expirations.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ExpirationService', ['$resource', ExpirationService]);