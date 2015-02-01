/*
 * @name CheckerService
 * @constructor
 * @desc Proveedor de datos, Responsables verificación
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function CheckerService($resource) {
  return $resource('models/checkers.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('CheckerService', ['$resource', CheckerService]);