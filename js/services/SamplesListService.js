/**
 * @name SamplesListService
 * @constructor
 * @desc Proveedor de datos, lista Muestras
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function SamplesListService($resource) {
  return $resource('models/samples_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('SamplesListService', ['$resource', SamplesListService]);
