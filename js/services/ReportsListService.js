/**
 * @name ReportsListService
 * @constructor
 * @desc Proveedor de datos, lista Reportes
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ReportsListService($resource) {
  return $resource('models/reports_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ReportsListService', ['$resource', ReportsListService]);
