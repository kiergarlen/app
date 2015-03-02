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
    query: {method:'GET', params:{
        //auth:"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3IiOiJyZ2FyY2lhIiwicHdkIjoicmdhcmNpYSIsImx2bCI6NSwiaXNzIjoiaHR0cDpcL1wvZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImlhdCI6MTQyNTE3NTQ1NCwiZXhwIjoxNDI2MTc1MTkzfQ.ZDZ1VypzLdH3uySKALamGufaJxuTQjon2ho5PecA1p4"
    }, isArray:true}
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
