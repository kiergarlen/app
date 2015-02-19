/**
 * @name ClientDetailService
 * @constructor
 * @desc Proveedor de datos, Detalle cliente
 * @param {Object} $resource - Acceso a recursos HTTP, AngularJS
 * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
 */
function ClientDetailService($resource) {
  return $resource('models/clients/:clientId.json', {}, {
    query: {method:'GET', params:{clientId:'id_cliente'}, isArray:true}
  });
}

angular
  .module('siclabApp')
  .factory('ClientDetailService', ['$resource',  ClientDetailService]);
