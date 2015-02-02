/**
 * @name PlanContainersController
 * @constructor
 * @desc Controla la vista para capturar los recipientes de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanContainersController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanContainersController',
    [
      '$scope',
      PlanContainersController
    ]
  );