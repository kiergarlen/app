/**
 * @name LoginController
 * @constructor
 * @desc Controla la vista para Login
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
 * @param {Object} LoginService - Proveedor de datos, Login
 */
function LoginController($scope, $http, Loginservice) {
  var vm = this;
  vm.message = '';
  vm.user = {username: '', password: ''};
  vm.submit = submitMessage;
  vm.login = login;

  function submitMessage(msg, usr, pwd) {
    msg = [
      msg,
      ' USER: ',
      usr,
      ' PASSWORD: ',
      pwd
    ].join('');
    return msg;
  }

  function login() {
    if ($scope.loginForm.$valid)
    {
      if (vm.user.username == 'rgarcia' &&
        vm.user.password == 'rgarcia'
      )
      {
        vm.message = 'Enviando...';
        vm.submit(
          '',
          vm.user.username,
          vm.user.password
        );
      }
      else
      {
        vm.message = 'Usuario o contraseña incorrectos';
      }
    }
    else
    {
      vm.message = 'Debe ingresar usuario y/o contraseña';
    }
  }
}

angular
  .module('siclabApp')
  .controller('LoginController',
    [
      '$scope', '$http',
      'LoginService',
      LoginController
    ]
  );
