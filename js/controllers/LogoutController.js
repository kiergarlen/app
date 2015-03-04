/**
 * @name LogoutController
 * @constructor
 * @desc Controla la vista para Logout
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} $location - Manejo de URL [AngularJS]
 * @param {Object} $window - Manejo de objeto Window [AngularJS]
 */
function LogoutController($location, $window) {
  var vm = this;
  vm.logout = logout;

  function logout() {
    $window.localStorage.removeItem('user-token');
    $location.path('sistema/login');
  }
}

angular
  .module('siclabApp')
  .controller('LogoutController',
    [
      '$location', '$window',
      LogoutController
    ]
  );