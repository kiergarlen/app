/**
 * @name ReportApprovalService
 * @constructor
 * @desc Proveedor de datos, validación Reporte
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ReportApprovalService($resource) {
  return $resource('models/report.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ReportApprovalService', ['$resource', ReportApprovalService]);
