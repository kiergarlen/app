function ClientsListController(ClientService) {
  this.clients = ClientService.query();
}

angular
  .module('siclabApp')
  .controller('ClientsListController',
  ['ClientService',
  ClientsListController
]);