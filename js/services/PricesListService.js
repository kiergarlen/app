/*
 * @name PricesListService
 * @constructor
 * @desc Proveedor de datos, lista Precios
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function PricesListService($resource) {
  return $resource('models/prices_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('PricesListService', ['$resource', PricesListService]);
