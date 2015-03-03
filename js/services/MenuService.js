/**
 * @name MenuService
 * @constructor
 * @desc Proveedor de datos, Menú
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
//function MenuService($resource) {
//  return $resource('models/menu.json', {}, {
//    query: {method:'GET', params:{}, isArray:true}
//  });
//}
function MenuService($resource, $http, $q) {
  return $resource('api/menu', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

//angular
//  .module('siclabApp')
//  .factory('MenuService', ['$resource', MenuService]);
angular
  .module('siclabApp')
  .factory('MenuService', [
    '$resource', '$http', '$q',
    MenuService
  ]
);
