/**
 * @name PlanObjectivesService
 * @constructor
 * @desc Proveedor de datos, Objetivos plan
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function PlanObjectivesService($resource) {
  return $resource('models/plan_objectives.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PlanObjectivesService', ['$resource', PlanObjectivesService]);
