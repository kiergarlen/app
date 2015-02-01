/*
 * @name ChemicalSupervisorService
 * @constructor
 * @desc Proveedor de datos, Supervisores físicoquimico
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ChemicalSupervisorService($resource) {
  return $resource('models/chemical_supervisors.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ChemicalSupervisorService', ['$resource', ChemicalSupervisorService]);