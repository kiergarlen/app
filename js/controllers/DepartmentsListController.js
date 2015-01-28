/**
 * @name DepartmentsListController
 * @constructor
 * @desc Controla la vista para consulta de Áreas
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} DepartmentsListService - Proveedor de datos, lista Áreas
 */
function DepartmentsListController(DepartmentsListService) {
  var vm = this;
  vm.clients = DepartmentsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('DepartmentsListController',
    [
      'DepartmentsListService',
      DepartmentsListController
    ]
  );