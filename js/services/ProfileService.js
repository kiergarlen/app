/**
 * @name ProfileService
 * @constructor
 * @desc Proveedor de datos, Perfil
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ProfileService($resource) {
  return $resource('models/profile.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ProfileService', ['$resource', ProfileService]);
