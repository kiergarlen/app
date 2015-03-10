
  /**
   * @name TokenService
   * @constructor
   * @desc Proveedor para lectura/escritura de token
   * @param {Object} $window - Acceso a Objeto Window [AngularJS]
   * @return {Object} authData - Métodos para manejo de token
   */
  function TokenService($window) {
    var tokenKey = 'user-token';
    var storage = $window.localStorage;
    var cachedToken;
    var authData = {
      isAuthenticated: isAuthenticated,
      setToken: setToken,
      getToken: getToken,
      clearToken: clearToken
    };
    return authData;

    function setToken(token) {
      cachedToken = token;
      storage.setItem(tokenKey, token);
    }

    function getToken() {
      if (!cachedToken)
      {
        cachedToken = storage.getItem(tokenKey);
      }
      return cachedToken;
    }

    function clearToken() {
      cachedToken = null;
      storage.removeItem(tokenKey);
    }

    function isAuthenticated() {
      return !!getToken();
    }
  }

  angular
    .module('siclabApp')
    .factory('TokenService', [
      '$window'
    ]
  );

  /**
   * @name AuthenticationInterceptService
   * @constructor
   * @desc Proveedor para envío de encabezado con token
   * @param {Object} $window - Acceso a Objeto Window [AngularJS]
   * @return {Object} Object - Métodos para manejo de peticiones de autenticación
   */
  function AuthenticationInterceptService($rootScope, $q, TokenService) {
    return {
      request: processRequest,
      response: processResponse
    };

    function processRequest(config) {
      var token = TokenService.getToken();
      if (token)
      {
        config.headers = config.headers || {};
        config.headers.Authorization = 'Bearer ' + token;
      }
      return config;
    }

    function processResponse(response) {
      if (response.status > 399 && response.status < 500)
      {
        console.log('user no authenticated', response);
        //TODO re-route
      }
      return response || $q.when(response);
    }
  }

  angular
    .module('siclabApp')
    .factory('AuthenticationInterceptService', [
      '$rootScope', '$q', 'TokenService'
    ]
  );
