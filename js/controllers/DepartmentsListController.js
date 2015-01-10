function DepartmentsListController(DepartmentService) {
  this.departments = DepartmentService.query();
}

angular
  .module('siclabApp')
  .controller('DepartmentsListController',
  ['DepartmentService',
  DepartmentsListController
]);