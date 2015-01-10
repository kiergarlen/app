function EmployeesListController(EmployeeService) {
  this.employees = EmployeeService.query();
}

angular
  .module('siclabApp')
  .controller('EmployeesListController',
  ['EmployeeService',
  EmployeesListController
]);