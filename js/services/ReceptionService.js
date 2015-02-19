/**
 * @name ReceptionService
 * @constructor
 * @desc Proveedor de datos, Recepción
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ReceptionService($resource) {
  return $resource('models/sampling/samples/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('ReceptionService', ['$resource', ReceptionService]);