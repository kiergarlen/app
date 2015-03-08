/**
 * @name QuoteListController
 * @constructor
 * @desc Controla la vista para capturar una Solicitud/Cotización
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} QuoteListService - Proveedor de datos, lista de Cotizaciones
 */
function QuoteListController(QuoteListService) {
  var vm = this;
  vm.quotes = QuoteListService.query();
  vm.selectRow = selectRow;
  vm.addNewQuote = addNewQuote;

  function selectRow($event) {
    console.log($event);
  }

  function addNewQuote() {
    $location.path('muestreo/solicitud');
  }
}

angular
  .module('siclabApp')
  .controller('QuoteListController',
    [
      'QuoteListService',
      QuoteListController
    ]
  );