/**
 * @name AnalysisListService
 * @constructor
 * @desc Proveedor de datos, consulta de Análisis
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function AnalysisListService($resource) {
  return $resource('models/analysis_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('AnalysisListService', ['$resource', AnalysisListService]);