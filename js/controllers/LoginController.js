/**
 * @name LoginController
 * @constructor
 * @desc Controla la vista para Login
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
 * @param {Object} $location - Manejo de URL [AngularJS]
 * @param {Object} $window - Manejo de objeto Window [AngularJS]
 * @param {Object} jwtHelper - Utilerías para JWT [angular-jwt]
 * @param {Object} LoginService - Proveedor de datos, Login
 */
function LoginController($scope, $http, $location, $window, jwtHelper) {
  var vm = this;
  vm.message = '';
  vm.user = {username: '', password: ''};
  vm.submit = submitMessage;
  vm.login = login;
  console.log($window.localStorage.getItem('user-token'));

  function submitMessage(username, password) {
    $http({
      url: 'api/login',
      method: 'POST',
      data: {
        username: username,
        password: password
      }
    }).then(function success(response) {
      var token = response.data || null;
      $window.localStorage.setItem('user-token', token);

      $location.path('main');

    }, function error(response) {
      if (response.status === 404) {
        //not found
      } else {
        //error
      }
    });
    return '';
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
      '$scope', '$http', '$location', '$window', 'jwtHelper',
      LoginController
    ]
  );

/*
//I decided to store the token on the local storage, so I don’t need to login
//everytime I enter the page, but that is based on your personal use case.

app.factory('Auth', function($http, LocalService, AccessLevels) {
  return {
    authorize: function(access) {
      if (access === AccessLevels.user) {
        return this.isAuthenticated();
      } else {
        return true;
      }
    },
    isAuthenticated: function() {
      return LocalService.get('auth_token');
    },
    login: function(credentials) {
      var login = $http.post('/auth/authenticate', credentials);
      login.success(function(result) {
        LocalService.set('auth_token', JSON.stringify(result));
      });
      return login;
    },
    logout: function() {
      // The backend doesn't care about logouts, delete the token and you're good to go.
      LocalService.unset('auth_token');
    },
    register: function(formData) {
      LocalService.unset('auth_token');
      var register = $http.post('/auth/register', formData);
      register.success(function(result) {
        LocalService.set('auth_token', JSON.stringify(result));
      });
      return register;
    }
  };
});

//For the login, we make a post with our credentials and if it succeds,
//we store the token (and also the user, I got lazy here) into the localstorage.
//For the registering, we remove the token if any and well, same thing as login.
//
//To see if we are authenticated I decided to check for the token existence.
//Since the backend doens’t know about logins, having the token means that
//we can query our stuff so if the token exist, we are “logged in”.
//Of course the server can reject it on the next request if the user
//no longer exist, it expired or we used the “rotate tokens” technique.
//
//Look how the logout works! We just need to delete the token because as I said,
//the backend is not concerned about logins as there is no sessions
//or stuff like that.
//
//The authorize method is a helper method I use to check if a user
//is authenticated or not before I enter a route (more on this later).
//
//I also created a AuthInterceptor to handle the request/response:

app.factory('AuthInterceptor', function($q, $injector) {
  return {
    request: function(config) {
      var LocalService = $injector.get('LocalService');
      var token;
      if (LocalService.get('auth_token')) {
        token = angular.fromJson(LocalService.get('auth_token')).token;
      }
      if (token) {
        config.headers.Authorization = 'Bearer ' + token;
      }
      return config;
    },
    responseError: function(response) {
      if (response.status === 401 || response.status === 403) {
        LocalService.unset('auth_token');
        $injector.get('$state').go('anon.login');
      }
      return $q.reject(response);
    }
  };
});
*/
