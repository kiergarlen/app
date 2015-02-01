/*
 * @name ReceptionistService
 * @constructor
 * @desc Proveedor de datos, Recepcionistas
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ReceptionistService($resource) {
  return $resource('models/receptionists.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ReceptionistService', ['$resource', ReceptionistService]);