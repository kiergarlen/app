/**
 * @name EmployeesListController
 * @constructor
 * @desc Controla la vista para el listado de Empleados
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} EmployeeService - Proveedor de datos, Empleados
 */
function EmployeesListController(EmployeeService) {
	var vm = this;
  vm.employees = EmployeeService.query();
}

angular
  .module('siclabApp')
  .controller('EmployeesListController',
    [
      'EmployeeService',
      EmployeesListController
    ]
  );