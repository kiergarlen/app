/**
 * @name RequiredVolumeService
 * @constructor
 * @desc Proveedor de datos, Volúmenes requeridos
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function RequiredVolumeService($resource) {
  return $resource('models/volumes.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('RequiredVolumeService', ['$resource', RequiredVolumeService]);