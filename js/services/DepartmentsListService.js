/**
 * @name DepartmentsListService
 * @constructor
 * @desc Proveedor de datos, Áreas
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function DepartmentsListService($resource) {
  return $resource('models/deparments_list.json', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('DepartmentsListService', ['$resource', DepartmentsListService]);
