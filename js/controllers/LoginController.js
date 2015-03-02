/**
 * @name LoginController
 * @constructor
 * @desc Controla la vista para Login
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
 * @param {Object} LoginService - Proveedor de datos, Login
 */
function LoginController($scope, $http, $window, Loginservice) {
  var vm = this;
  vm.message = '';
  vm.user = {username: '', password: ''};
  vm.submit = submitMessage;
  vm.login = login;

  function submitMessage(username, password) {
    //$scope.badCreds = false;
    $http({
      url: 'api/login',
      method: 'POST',
      data: {
        username: username,
        password: password
      }
    }).then(function success(response) {
      //console.log(response);
      console.log(response.data);
      //AuthToken.setToken(response.data.token);
      $window.localStorage.setItem('user-token', response.data.token);
      console.log($window.localStorage.getItem('user-token'));
      //$scope.user = response.data.user;
      //$scope.noPicture = true;
      //$scope.alreadyLoggedIn = true;
      //showAlert('success', 'Hey there!', 'Welcome ' + $scope.user.username + '!');
    }, function error(response) {
      if (response.status === 404) {
        //$scope.badCreds = true;
        //showAlert('danger', 'Whoops...', 'Do I know you?');
        console.log('Not found');
      } else {
        //showAlert('danger', 'Hmmm....', 'Problem logging in! Sorry!');
        console.log('Problem logging in!');
      }
    });
  }

  function login() {
    vm.message = '';
    if (!$scope.loginForm.$valid)
    {
      vm.message = 'Debe ingresar usuario y/o contraseña';
      return;
    }
    vm.submit(
      vm.user.username,
      vm.user.password
    );
  }
}

angular
  .module('siclabApp')
  .controller('LoginController',
    [
      '$scope', '$http', '$window',
      'LoginService',
      LoginController
    ]
  );
