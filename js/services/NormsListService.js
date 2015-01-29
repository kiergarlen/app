/*
 * @name NormsListService
 * @constructor
 * @desc Proveedor de datos, lista Normas
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function NormsListService($resource) {
  return $resource('models/norms_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('NormsListService', ['$resource', NormsListService]);
