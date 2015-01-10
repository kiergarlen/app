function NormsListController(NormService) {
  this.norms = NormService.query();
}

angular
  .module('siclabApp')
  .controller('NormsListController',
  ['NormService',
  NormsListController
]);