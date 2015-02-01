/**
 * @name ProfileController
 * @constructor
 * @desc Controla la vista para Perfil
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ProfileService - Proveedor de datos, Perfil
 */
function ProfileController(ProfileService) {
  var vm = this;
  vm.profile = ProfileService.query();
}

angular
  .module('siclabApp')
  .controller('ProfileController',
    [
      'ProfileService',
      ProfileController
    ]
  );