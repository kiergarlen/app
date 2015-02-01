/*
 * @name ReactivesListService
 * @constructor
 * @desc Proveedor de datos, lista Reactivos
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ReactivesListService($resource) {
  return $resource('models/reactives_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ReactivesListService', ['$resource', ReactivesListService]);
