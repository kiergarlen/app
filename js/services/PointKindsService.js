/*
 * @name PointKindsService
 * @constructor
 * @desc Proveedor de datos, tipos Punto
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function PointKindsService($resource) {
  return $resource('models/point_kinds.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PointKindsService', ['$resource', PointKindsService]);
