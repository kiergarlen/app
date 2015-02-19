/**
 * @name MetalSupervisorService
 * @constructor
 * @desc Proveedor de datos, Supervisores metales pesados
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function MetalSupervisorService($resource) {
  return $resource('models/metal_supervisors.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('MetalSupervisorService', ['$resource', MetalSupervisorService]);
