/*
 * @name ReferencesListService
 * @constructor
 * @desc Proveedor de datos, lista Referencias
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ReferencesListService($resource) {
  return $resource('models/references_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ReferencesListService', ['$resource', ReferencesListService]);
