/*
 * @name WaveService
 * @constructor
 * @desc Proveedor de datos, Intensidades oleaje
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function WaveService($resource) {
  return $resource('models/waves.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('WaveService', ['$resource', WaveService]);