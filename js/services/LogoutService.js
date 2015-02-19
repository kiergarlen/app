/**
 * @name LogoutService
 * @constructor
 * @desc Proveedor de datos, Logout
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function LogoutService($resource) {
  return $resource('models/logout.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('LogoutService', ['$resource', LogoutService]);
