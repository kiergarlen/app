/**
 * @name UsersListService
 * @constructor
 * @desc Proveedor de datos, Usuarios
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function UsersListService($resource) {
  return $resource('models/users.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('UsersListService', ['$resource', UsersListService]);