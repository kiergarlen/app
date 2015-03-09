/**
* @name QuotesListController
* @constructor
* @desc Controla la vista para el listado de Solicitudes
* @this {Object} $scope - Contenedor para el modelo [AngularJS]
* @param {Object} $location - Manejo de URL [AngularJS]
* @param {Object} QuotesListService - Proveedor de datos, solicitudes
*/
function QuotesListController($location, QuotesListService) {
var vm = this;
vm.quotes = QuotesListService.query();
vm.addQuote = addQuote;
vm.selectRow = selectRow;

function addQuote() {
  $location.path('/muestreo/solicitud');
}

function selectRow(e) {
  var itemId = e.currentTarget.id.split('Id')[1];
  console.log(itemId);
}
}

angular
.module('siclabApp')
.controller('QuotesListController',
  [
    '$location', 'QuotesListService',
    QuotesListController
  ]
);
