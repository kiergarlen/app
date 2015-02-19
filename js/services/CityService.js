/**
 * @name CityService
 * @constructor
 * @desc Proveedor de datos, Localidades
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function CityService($resource) {
  return $resource('models/cities.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('CityService', ['$resource', CityService]);