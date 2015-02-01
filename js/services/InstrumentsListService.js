/*
 * @name InstrumentsListService
 * @constructor
 * @desc Proveedor de datos, lista Equipos
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function InstrumentsListService($resource) {
  return $resource('models/intruments_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('InstrumentsListService', ['$resource', InstrumentsListService]);
