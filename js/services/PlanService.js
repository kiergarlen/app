/**
 * @name PlanService
 * @constructor
 * @desc Proveedor de datos, Plan muestreo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function PlanService($resource) {
  return $resource('models/sampling/plans/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('PlanService', ['$resource', PlanService]);