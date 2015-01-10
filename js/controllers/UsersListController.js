function UsersListController (UserService) {
  this.users = UserService.query();
}

angular
  .module('siclabApp')
  .controller('UsersListController',
  ['UserService',
  UsersListController
]);