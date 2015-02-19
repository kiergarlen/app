/**
 * @name SamplingSupervisorService
 * @constructor
 * @desc Proveedor de datos, Supervisores muestreo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function SamplingSupervisorService($resource) {
  return $resource('models/sampling_supervisors.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('SamplingSupervisorService', ['$resource', SamplingSupervisorService]);