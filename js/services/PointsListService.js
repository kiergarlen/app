/*
 * @name PointsListService
 * @constructor
 * @desc Proveedor de datos, lista Puntos
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function PointsListService($resource) {
  return $resource('models/points_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PointsListService', ['$resource', PointsListService]);
