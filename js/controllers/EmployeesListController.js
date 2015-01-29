/**
 * @name EmployeesListController
 * @constructor
 * @desc Controla la vista para consulta de Empleados
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} EmployeesListService - Proveedor de datos, lista Empleados
 */
function EmployeesListController(EmployeesListService) {
  var vm = this;
  vm.clients = EmployeesListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('EmployeesListController',
    [
      'EmployeesListService',
      EmployeesListController
    ]
  );