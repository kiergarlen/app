/*
 * @name ContainerService
 * @constructor
 * @desc Proveedor de datos, Recipientes
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ContainerService($resource) {
  return $resource('models/containers.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ContainerService', ['$resource', ContainerService]);