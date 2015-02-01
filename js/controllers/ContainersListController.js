/**
 * @name ContainersListController
 * @constructor
 * @desc Controla la vista para consulta de Recipientes
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ContainersListService - Proveedor de datos, lista Recipientes
 */
function ContainersListController(ContainersListService) {
  var vm = this;
  vm.pricesList = ContainersListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('ContainersListController',
    [
      'ContainersListService',
      ContainersListController
    ]
  );