/*
 * @name FieldSheetService
 * @constructor
 * @desc Proveedor de datos, Hojas campo
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function FieldSheetService($resource) {
  return $resource('models/field_sheets/1.json', {}, {
    query: {method:'GET', params:{}, isArray:false}
  });
}

angular
  .module('siclabApp')
  .factory('FieldSheetService', ['$resource', FieldSheetService]);