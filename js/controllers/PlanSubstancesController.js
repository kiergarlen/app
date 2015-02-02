/**
 * @name PlanSubstancesController
 * @constructor
 * @desc Controla la vista para capturar los reactivos de un Plan de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 */
function PlanSubstancesController($scope) {
  //
}

angular
  .module('siclabApp')
  .controller('PlanSubstancesController',
    [
      '$scope',
      PlanSubstancesController
    ]
  );
