/*
 * @name SamplingNormService
 * @constructor
 * @desc Proveedor de datos, Normas muestreo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function SamplingNormService($resource) {
  return $resource('models/sampling_norms.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('SamplingNormService', ['$resource', SamplingNormService]);