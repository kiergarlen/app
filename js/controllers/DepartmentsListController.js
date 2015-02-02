/**
 * @name DepartmentsListController
 * @constructor
 * @desc Controla la vista para el listado de Áreas
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} DepartmentService - Proveedor de datos, Áreas
 */
function DepartmentsListController($scope, DepartmentService) {
  $scope.departments = DepartmentService.query();
}

angular
  .module('siclabApp')
  .controller('DepartmentsListController',
    [
      '$scope',
      'DepartmentService',
      DepartmentsListController
    ]
  );