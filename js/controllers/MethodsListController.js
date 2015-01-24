/**
 * @name MethodsListController
 * @constructor
 * @desc Controla la vista para la búsqueda de Métodos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} MethodsListService - Proveedor de datos, Métodos
 */
function MethodsListController(MethodsListService) {
  var vm = this;
  vm.methodsList = MethodsListService.query();

  vm.selectRow = selectRow;
  function select($event) {
    //TODO send to details view
    console.log('clicked in row');
  }
}

angular
  .module('siclabApp')
  .controller('MethodsListController',
    [
      'MethodsListService',
      MethodsListController
    ]
  );