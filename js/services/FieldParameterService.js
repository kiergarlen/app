/*
 * @name FieldParameterService
 * @constructor
 * @desc Proveedor de datos, Parámetros campo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function FieldParameterService($resource) {
  return $resource('models/field_parameters.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('FieldParameterService', ['$resource', FieldParameterService]);