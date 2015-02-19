/**
 * @name CoolerService
 * @constructor
 * @desc Proveedor de datos, Hieleras
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function CoolerService($resource) {
  return $resource('models/coolers.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('CoolerService', ['$resource', CoolerService]);