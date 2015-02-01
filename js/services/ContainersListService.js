/*
 * @name ContainersListService
 * @constructor
 * @desc Proveedor de datos, lista Recipients
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ContainersListService($resource) {
  return $resource('models/containers_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ContainersListService', ['$resource', ContainersListService]);
