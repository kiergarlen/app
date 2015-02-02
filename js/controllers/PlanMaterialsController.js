/**
 * @name PlanMaterialsController
 * @constructor
 * @desc Controla la vista para capturar los materiales de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanMaterialsController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanMaterialsController',
    [
      '$scope',
      PlanMaterialsController
    ]
  );