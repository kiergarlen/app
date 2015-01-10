function TasksController(TaskService) {
  this.welcome = TaskService.query();
}

angular
  .module('siclabApp')
  .controller('TasksController',
  ['TaskService', TasksController]);