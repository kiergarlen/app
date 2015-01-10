function ClientDetailController(ClientDetailService) {
  this.clientDetail = ClientDetailService.query();
}

angular
  .module('siclabApp')
  .controller('ClientDetailController',
  ['ClientDetailService',
  ClientsListController
]);