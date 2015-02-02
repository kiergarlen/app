/**
 * @name TasksController
 * @constructor
 * @desc Controla la vista para Bienvenida
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} TaskService - Proveedor de datos, Bienvenida
 */
function TasksController(TaskService) {
  var vm = this;
  vm.welcome = TaskService.query();
}

angular
  .module('siclabApp')
  .controller('TasksController',
    [
      'TaskService',
      TasksController
    ]
  );