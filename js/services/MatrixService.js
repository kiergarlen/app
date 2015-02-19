/**
 * @name MatrixService
 * @constructor
 * @desc Proveedor de datos, Matrices
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function MatrixService($resource) {
  return $resource('models/matrices.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('MatrixService', ['$resource', MatrixService]);