/*
 * @name PointService
 * @constructor
 * @desc Proveedor de datos, Puntos muestreo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function PointService($resource) {
  return $resource('models/points.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PointService', ['$resource', PointService]);