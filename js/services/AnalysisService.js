/**
 * @name AnalysisService
 * @constructor
 * @desc Proveedor de datos, selección de formato de captura de Análisis
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function AnalysisService($resource) {
  return $resource('models/analysis_select.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('AnalysisService', ['$resource', AnalysisService]);