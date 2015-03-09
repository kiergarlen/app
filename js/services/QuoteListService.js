/**
* @name QuotesListService
* @constructor
* @desc Proveedor de datos, lista de Cotizaciones
* @param {Object} $resource - Acceso a recursos HTTP, AngularJS
* @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
*/
function QuotesListService($resource) {
return $resource('models/quotes/quotes.json', {}, {
  query: {method:'GET', params:{}, isArray:true}
});
}

angular
.module('siclabApp')
.factory('QuotesListService', [
  '$resource',
  QuotesListService
]
);

