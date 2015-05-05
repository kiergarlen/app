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
    ArrayUtils.seItemsFromReference = seItemsFromReference;
    ArrayUtils.countSelectedItems = countSelectedItems;
    ArrayUtils.averageFromValues = averageFromValues;

    /**
     * @function selectItemFromCollection
     * @desc Obtiene un ítem de un Array, coincidiendo una propiedad y su valor
     * @param {Array} collection - Array de ítems a seleccionar
     * @param {String} field - Nombre de la propiedad a coincidir
     * @param {Object} value - Valor de la propiedad a coincidir
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
     * @desc Obtiene los ítems de un Array, coincidiendo una propiedad y su valor
     * @param {Array} collection - Array de ítems a seleccionar
     * @param {String} field - Nombre de la propiedad a coincidir
     * @param {Object} value - Valor de la propiedad a coincidir
     * @return {Array} items - Array de ítems seleccionados
     */
    function selectItemsFromCollection(collection, field, value) {
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
     * @desc Extrae un ítem de un Array, coincidiendo una propiedad y su valor
     * @param {Array} collection - Array de ítems a extraer
     * @param {String} field - Nombre de la propiedad a coincidir
     * @param {Object} value - Valor de la propiedad a coincidir
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
     * @function seItemsFromReference
     * @desc Cambia el valor de una propiedad de ítem de un Array, coincidiendo una propiedad y su valor desde otro Array
     * @param {Array} collection - Array de ítems a modificar
     * @param {Array} referenceCollection - Array de referencia
     * @param {String} matchField - Nombre de la propiedad a coincidir
     * @param {Array} fields - Nombres de las propiedades a cambiar
     * @return {Object} item - Ítem seleccionado
     */
    function seItemsFromReference(collection, referenceCollection, matchField, fields) {
      var i, l, j, m, k, n, field = '';
      l = collection.length;
      n = fields.length;
      for(i = 0; i < l; i += 1) {
        if (referenceCollection !== undefined)
        {
          m = referenceCollection.length;
          for (j = 0; j < m; j += 1) {
            if (collection[i][matchField] ==
              referenceCollection[j][matchField])
            {
              for (k = 0; k < n; k += 1) {
                field = fields[k];
                collection[i][field] = referenceCollection[j][field];
              }
            }
          }
        }
      }
      return collection;
    }

    /**
     * @function countSelectedItems
     * @desc Cuenta los objetos de un Array con valor true de la propiedad selected
     * @param {Array} collection - Array de ítems a extraer
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
        for (i = 0; i < l; i++) {
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
     * @function updateData
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

    Token.hashMessage = hashMessage;
    Token.authenticateUser = authenticateUser;
    Token.isAuthenticated = isAuthenticated;
    Token.setToken = setToken;
    Token.getToken = getToken;
    Token.clearToken = clearToken;
    Token.decodeToken = decodeToken;
    Token.getUserFromToken = getUserFromToken;

    /**
     * @function hashMessage
     * @desc Codifica un mensaje usando SHA-256
     * @param {String} message - Mensaje a codificar
     * @return {String} hash - Mensaje codificado
     */
    function hashMessage(message) {
      var hash = CryptoJS.SHA256(message);
      return hash;
    }

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

  // TaskService.js
  /**
   * @name TaskService
   * @constructor
   * @desc Proveedor de datos, Tareas
   * @param {Object} $resource- Acceso a recursos HTTP, AngularJS
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function TaskService($resource, TokenService) {
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
    .factory('TaskService',
      [
        '$resource', 'TokenService',
        TaskService
      ]
    );

  // StudyService.js
  /**
   * @name StudyService
   * @constructor
   * @desc Proveedor de datos, Estudios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function StudyService($resource, TokenService) {
    return $resource(API_BASE_URL + 'studies/:studyId', {}, {
      query: {
        method: 'GET',
        params: {studyId: 'id_estudio'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {studyId: 'id_estudio'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('StudyService',
      [
        '$resource', 'TokenService',
        StudyService
      ]
    );


  // QuoteService.js
  /**
   * @name QuoteService
   * @constructor
   * @desc Proveedor de datos, Solicitudes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function QuoteService($resource, TokenService) {
    return $resource(API_BASE_URL + 'quotes/:quoteId', {}, {
      query: {
        method: 'GET',
        params: {quoteId:'id_solicitud'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {quoteId:'id_solicitud'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('QuoteService',
    [
      '$resource', 'TokenService',
      QuoteService
    ]
   );

  // OrderService.js
  /**
   * @name OrderService
   * @constructor
   * @desc Proveedor de datos, Órdenes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function OrderService($resource, TokenService) {
    return $resource(API_BASE_URL + 'orders/:orderId', {}, {
      query: {
        method: 'GET',
        params: {orderId: 'id_orden'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {orderId: 'id_orden'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('OrderService',
      [
        '$resource', 'TokenService',
        OrderService
      ]
    );

  // PlanService.js
  /**
   * @name PlanService
   * @constructor
   * @desc Proveedor de datos, Planes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PlanService($resource, TokenService) {
    return $resource(API_BASE_URL + 'plans/:planId', {}, {
      query: {
        method: 'GET',
        params: {planId: 'id_plan'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {planId: 'id_plan'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PlanService',
      [
        '$resource', 'TokenService',
        PlanService
      ]
    );

  // SheetService.js
  /**
   * @name SheetService
   * @constructor
   * @desc  Proveedor de datos, Hojas de campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SheetService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sheets/:sheetId', {}, {
      query: {
        method: 'GET',
        params: {sheetId: 'id_hoja'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {sheetId: 'id_hoja'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
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
    .factory('SheetService',
      [
        '$resource', 'TokenService',
        SheetService
      ]
    );

  // ReceptionService.js
  /**
   * @name ReceptionService
   * @constructor
   * @desc Proveedor de datos, Recepciones de muestras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReceptionService($resource, TokenService) {
    return $resource(API_BASE_URL + 'receptions/:receptionId', {}, {
      query: {
        method: 'GET',
        params: {receptionId: 'id_recepcion'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {receptionId: 'id_recepcion'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
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
    .factory('ReceptionService',
      [
        '$resource', 'TokenService',
        ReceptionService
      ]
    );

  // CustodyService.js
  /**
   * @name CustodyService
   * @constructor
   * @desc Proveedor de datos, Cadenas de custodia
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CustodyService($resource, TokenService) {
    return $resource(API_BASE_URL + 'custodies/:custodyId', {}, {
      query: {
        method: 'GET',
        params: {custodyId: 'id_custodia'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {custodyId: 'id_custodia'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
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
    .factory('CustodyService',
      [
        '$resource', 'TokenService',
        CustodyService
      ]
    );
