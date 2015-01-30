/**
 * @name PointsListController
 * @constructor
 * @desc Controla la vista para consulta de Puntos
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} PointsListService - Proveedor de datos, lista Puntos
 */
function PointsListController(PointsListService) {
  var vm = this;
  vm.clients = PointsListService.query();
  vm.selectRow = selectRow;

  function selectRow() {

  }
}

angular
  .module('siclabApp')
  .controller('PointsListController',
    [
      'PointsListService',
      PointsListController
    ]
  );