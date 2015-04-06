  // SERVICES
  // ArrayUtilsService.js
  /**
   * @name ArrayUtilsService
   * @constructor
   * @desc Proveedor para manejo de arreglos
   * @return {ArrayUtilsService} ArrayUtils - Métodos para manejo de arreglos
   */
  function ArrayUtilsService() {
    var ArrayUtils = {};

    ArrayUtils.selectItemFromCollection = selectItemFromCollection;
    ArrayUtils.selectItemsFromCollection = selectItemsFromCollection;
    ArrayUtils.extractItemFromCollection = extractItemFromCollection;
    ArrayUtils.countSelectedItems = countSelectedItems;
    ArrayUtils.averageFromValues = averageFromValues;

    /**
     * @function selectItemFromCollection
     * @desc Obtiene un ítem de un Array, empatando una propiedad y su valor
     * @param {Array} collection - Array de objetos a seleccionar
     * @param {String} field - Nombre de la propiedad a empatar
     * @param {Object} value - Valor de la propiedad a empatar
     * @return {Object} item - Ítem seleccionado
     */
    function selectItemFromCollection(collection, field, value) {
      var i = 0,
      l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value)
        {
          item = collection[i];
          break;
        }
      }
      return item;
    }

    /**
     * @function selectItemsFromCollection
     * @desc Obtiene los ítems de un Array, empatando una propiedad y su valor
     * @param {Array} collection - Array de objetos a seleccionar
     * @param {String} field - Nombre de la propiedad a empatar
     * @param {Object} value - Valor de la propiedad a empatar
     * @return {Array} items - Array de ítems seleccionados
     */
    function selectItemsFromCollection(collection) {
      var i = 0,
      l = collection.length,
      items = [];
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value)
        {
          items.push(collection[i]);
        }
      }
      return items;
    }

    /**
     * @function extractItemFromCollection
     * @desc Extrae un ítem de un Array, empatando una propiedad y su valor
     * @param {Array} collection - Array de objetos a extraer
     * @param {String} field - Nombre de la propiedad a empatar
     * @param {Object} value - Valor de la propiedad a empatar
     * @return {Object} item - Item extraído
     */
    function extractItemFromCollection(collection, field, value) {
      var i = 0,
      l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value)
        {
          item = collection.splice(i, 1);
          break;
        }
      }
      return item;
    }

    /**
     * @function countSelectedItems
     * @desc Cuenta los objetos de un Array con valor true de la propiedad selected
     * @param {Array} collection - Array de objetos a extraer
     * @return {Number} count - Cantidad de objetos que cumplen la condición
     */
    function countSelectedItems(collection){
      var i, l, count = 0;
      if (!collection)
      {
        return 0;
      }
      l = collection.length;
      for (i = 0; i < l; i += 1) {
        if (collection[i].selected)
        {
          count += 1;
        }
      }
      return count;
    }

    /**
     * @function averageFromValues
     * @desc Calcula el promedio de los valores numéricos de un Array
     * @param {Array} collection - Array de valores a promediar
     * @return {Number} avg - Cantidad de objetos que cumplen la condición
     */
    function averageFromValues(collection) {
      var i = 0,
      l = collection.length,
      sum = 0,
      avg = 0;
      if (l > 0)
      {
        for (i; i < l; i++) {
          sum += parseFloat(collection[i]);
        }
        avg = Math.round((sum / l) * 1000 * 1000) / (1000 * 1000);
      }
      return avg;
    }

    return ArrayUtils;
  }
  angular
    .module('sislabApp')
    .factory('ArrayUtilsService',
      [
        ArrayUtilsService
      ]
    );

  // DateUtilsService.js
  /**
   * @name DateUtilsService
   * @constructor
   * @desc Proveedor para manejo de fechas
   * @return {DateUtilsService} DateUtils - Métodos para manejo de fechas
   */
  function DateUtilsService() {
    var DateUtils = {};

    DateUtils.padNumber = padNumber;
    DateUtils.dateToISOString = dateToISOString;
    DateUtils.isValidDate = isValidDate;

    /**
     * @function padNumber
     * @desc Agrega ceros a un número, devuelve una cadena de la longitud dada
     * @param {Number} number - Número a procesar
     * @param {Number} plces - longitud mínima de la cadena
     * @return {Object} paddedNumber - cadena de la longitud dada
     */
    function padNumber(number, places) {
      var paddedNumber = String(number),
      i = 0,
      l = paddedNumber.length,
      padding = '';
      if (l < places)
      {
        l = places - l;
        for (i = 0; i < l; i += 1) {
          padding += '0';
        }
        return padding + '' + paddedNumber;
      }
      return paddedNumber;
    }

    /**
     * @function dateToISOString
     * @desc Convierte una fecha local a una cadena con formato ISO 8601
     * @param {Date} date - Fecha a convertir
     * @return {String} - Cadena de fecha con formato ISO 8601
     */
    function dateToISOString(date) {
      return [
        date.getFullYear(),
        '-',
        padNumber(date.getMonth() + 1, 2),
        '-',
        padNumber(date.getDate(), 2),
        'T',
        padNumber(date.getHours(), 2),
        ':',
        padNumber(date.getMinutes(), 2),
        ':',
        padNumber(date.getSeconds(), 2),
        '.',
        (date.getMilliseconds() / 1000).toFixed(3).slice(2, 5),
        (date.getTimezoneOffset() / 60 > -1) ? '+' : '-',
        padNumber(date.getTimezoneOffset() / 60, 2),
        ':00'
      ].join('');
    }

    /**
     * @function isValidDate
     * @desc Determina si la fecha dada es válida
     * @param {Date} date - Fecha a evaluar
     * @return {Boolean} - Resultado de la evaluación
     */
    function isValidDate(date) {
      if (Object.prototype.toString.call(date) !== '[object Date]')
      {
        return false;
      }
      return !isNaN(date.getTime());
    }

    return DateUtils;
  }
  angular
    .module('sislabApp')
    .factory('DateUtilsService',
      [
        DateUtilsService
      ]
    );

  // RestUtilsService.js
  /**
   * @name RestUtilsService
   * @constructor
   * @desc Proveedor para manejo de servicios REST
   * @return {RestUtilsService} RestUtils - Métodos para manejo de REST
   */
  function RestUtilsService($resource, $location) {
    var RestUtils = {};

    RestUtils.saveData = saveData;
    RestUtils.updateData = updateData;

    /**
     * @function saveData
     * @desc Envía los datos vía POST para generar un nuevo recurso en el servicio
     * @param {Object} service - Proveedor de datos a usar
     * @param {String} data - JSON a enviar al servicio
     * @param {String} returnPath - Ruta de la vista a desplegar, éxito
     * @param {String} itemIdName - Propiedad a usar como identificador del recurso
     */
    function saveData(service, data, returnPath, itemIdName) {
      service
        .save(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          $location.path(returnPath);
          return response[itemIdName];
        }, function error(response) {
          if (response.status === 404)
          {
            return 'Recurso no encontrado';
          }
          else
          {
            return 'Error no especificado';
          }
        });
    }

    /**
     * @function saveData
     * @desc Envía los datos vía POST para actualizar un recurso en el servicio
     * @param {Object} service - Proveedor de datos a usar
     * @param {String} data - JSON a enviar al servicio
     * @param {String} returnPath - Ruta de la vista a desplegar, éxito
     * @param {String} itemIdName - Propiedad a usar como identificador del recurso
     */
    function updateData(service, data, returnPath, itemIdName) {
      service
        .update(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          $location.path(returnPath + '/' + response[itemIdName]);
          return response[itemIdName];
        }, function error(response) {
          if (response.status === 404)
          {
            return 'Recurso no encontrado';
          }
          else
          {
            return 'Error no especificado';
          }
        });
    }

    return RestUtils;
  }
  angular
    .module('sislabApp')
    .factory('RestUtilsService',
      [
        '$resource', '$location',
        RestUtilsService
      ]
    );

  // TokenService.js
  /**
   * @name TokenService
   * @constructor
   * @desc Proveedor para manejo del token
   * @param {Object} $window - Acceso a Objeto Window [AngularJS]
   * @param {Object} jwtHelper - Acceso a utilerías de token [Angular-jwt]
   * @return {TokenService} Token - Métodos para manejo de token
   */
  function TokenService($window, $http, $location, jwtHelper) {
    var tokenKey = 'sislab-token',
    storage = $window.localStorage,
    cachedToken,
    Token = {};

    Token.authenticateUser = authenticateUser;
    Token.isAuthenticated = isAuthenticated;
    Token.setToken = setToken;
    Token.getToken = getToken;
    Token.clearToken = clearToken;
    Token.decodeToken = decodeToken;
    Token.getUserFromToken = getUserFromToken;

    /**
     * @function authenticateUser
     * @desc Envía los datos del usuario al servicio de autenticación
     * @param {String} username - Nombre de usuario
     * @param {String} password - Contraseña del usuario
     */
    function authenticateUser(username, password) {
      $http({
        url: API_BASE_URL + 'login',
        method: 'POST',
        data: {
          username: username,
          password: password
        }
      }).then(function success(response) {
        var token = response.data || null;
        setToken(token);
        $location.path('main');
      }, function error(response) {
        if (response.status === 404)
        {
          return 'Sin enlace al servidor';
        }
        else
        {
          return 'Error no especificado';
        }
      });
    }

    /**
     * @function isAuthenticated
     * @desc Indica si el usuario está autenticado, por la presencia del token
     * @return {Boolean} - Presencia del token
     */
    function isAuthenticated() {
      return !!getToken();
    }

    /**
     * @function setToken
     * @desc Almacena el token
     * @param {Object} token - Token de autenticación
     */
    function setToken(token) {
      cachedToken = token;
      storage.setItem(tokenKey, token);
    }

    /**
     * @function getToken
     * @desc Obtiene el token
     * @return {Object} cachedToken - Token de autenticación
     */
    function getToken() {
      if (!cachedToken)
      {
        cachedToken = storage.getItem(tokenKey);
      }
      return cachedToken;
    }

    /**
     * @function clearToken
     * @desc Elimina el token
     */
    function clearToken() {
      cachedToken = null;
      storage.removeItem(tokenKey);
    }

    /**
     * @function decodeToken
     * @desc Decodifica el token
     * @return {Object} - Token de autenticación, decodificado
     */
    function decodeToken() {
      var token = getToken();
      return token && jwtHelper.decodeToken(token);
    }

    /**
     * @function getUserFromToken
     * @desc Obtiene datos del usuario del token decodificado
     * @return {Object} userData - Datos del usuario
     */
    function getUserFromToken() {
      var decodedJwt,
      userData;
      if (isAuthenticated())
      {
        decodedJwt = decodeToken();
        userData = {
          name: decodedJwt.nam,
          id: decodedJwt.uid,
          level: decodedJwt.ulv
        };
      }
      return userData;
    }

    return Token;
  }
  angular
    .module('sislabApp')
    .factory('TokenService',
      [
        '$window', '$http', '$location', 'jwtHelper',
        TokenService
      ]
    );

  // ValidationService.js
  /**
   * @name ValidationService
   * @constructor
   * @desc Proveedor para manejo de validación
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @return {ArrayUtilsService} ArrayUtils - Métodos para manejo de validación
   */
  function ValidationService(DateUtilsService) {
    var Validation = {};

    Validation.approveItem = approveItem;
    Validation.rejectItem = rejectItem;

    function approveItem(item, user) {
      item.id_status = 2;
      item.status = 'Validado';
      item.id_usuario_valida = user.id;
      item.motivo_rechaza = '';
      item.fecha_valida = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function rejectItem(item, user) {
      item.id_status = 3;
      item.status = 'Rechazado';
      item.id_usuario_valida = user.id;
      item.fecha_rechaza = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    return Validation;
  }
  angular
    .module('sislabApp')
    .factory('ValidationService',
      [
        'DateUtilsService',
        ValidationService
      ]
    );

  // MenuService.js
  /**
   * @name MenuService
   * @constructor
   * @desc Proveedor de datos, Menú
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MenuService($resource, TokenService) {
    return $resource(API_BASE_URL + 'menu', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('MenuService',
      [
        '$resource', 'TokenService',
        MenuService
      ]
    );

  // TasksListService.js
  /**
   * @name TasksListService
   * @constructor
   * @desc Proveedor de datos, Tareas
   * @param {Object} $resource- Acceso a recursos HTTP, AngularJS
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function TasksListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'tasks', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('TasksListService',
      [
        '$resource', 'TokenService',
        TasksListService
      ]
    );