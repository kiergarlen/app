/**
 * @name DistrictService
 * @constructor
 * @desc Proveedor de datos, Municipios
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function DistrictService($resource) {
  return $resource('models/districts.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('DistrictService', ['$resource', DistrictService]);