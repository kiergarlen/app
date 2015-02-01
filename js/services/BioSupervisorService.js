/*
 * @name BioSupervisorService
 * @constructor
 * @desc Proveedor de datos, Supervisores microbiológico
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function BioSupervisorService($resource) {
  return $resource('models/bio_supervisors.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('BioSupervisorService', ['$resource', BioSupervisorService]);