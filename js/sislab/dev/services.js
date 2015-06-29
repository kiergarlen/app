  //SERVICES
  //ArrayUtilsService.js
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
      var i = 0;
      var l = collection.length;
      var item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value) {
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
      var i = 0;
      var l = collection.length;
      var items = [];
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value) {
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
      var i = 0;
      var l = collection.length;
      var item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value) {
          item = collection.splice(i, 1);
          break;
        }
      }
      return item;
    }

    /**
     * @function seItemsFromReference
     * @desc Cambia el valor de una propiedad de ítem de un Array,
     * coincidiendo una propiedad y su valor desde otro Array
     * @param {Array} collection - Array de ítems a modificar
     * @param {Array} reference - Array de referencia
     * @param {String} matchField - Nombre de la propiedad a coincidir
     * @param {Array} fields - Nombres de las propiedades a cambiar
     * @return {Object} item - Ítem seleccionado
     */
    function seItemsFromReference(collection, reference, matchField, fields) {
      var i;
      var l;
      var j;
      var m;
      var k;
      var n;
      var field = '';
      l = collection.length;
      n = fields.length;
      for(i = 0; i < l; i += 1) {
        if (reference !== undefined) {
          m = reference.length;
          for (j = 0; j < m; j += 1) {
            if (collection[i][matchField] == reference[j][matchField]) {
              for (k = 0; k < n; k += 1) {
                field = fields[k];
                collection[i][field] = reference[j][field];
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
    function countSelectedItems(collection) {
      var i;
      var l;
      var count = 0;
      if (!collection) {
        return 0;
      }
      l = collection.length;
      for (i = 0; i < l; i += 1) {
        if (collection[i].selected) {
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
      var i = 0;
      var l = collection.length;
      var sum = 0;
      var avg = 0;
      if (l > 0) {
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

  //DateUtilsService.js
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
      var paddedNumber = String(number);
      var i = 0;
      var l = paddedNumber.length;
      var padding = '';
      if (l < places) {
        l = places - l;
        for (i = 0; i < l; i += 1) {
          padding += '0';
        }
        return [
          padding,
          paddedNumber
        ].join('');
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
        padNumber(date.getSeconds(), 2)
      ].join('');
        // '.',
        // (date.getMilliseconds() / 1000).toFixed(3).slice(2, 5),
        // (date.getTimezoneOffset() / 60 > -1) ? '+' : '-',
        // padNumber(date.getTimezoneOffset() / 60, 2),
        // ':00'
    }

    /**
     * @function isValidDate
     * @desc Determina si la fecha dada es válida
     * @param {Date} date - Fecha a evaluar
     * @return {Boolean} - Resultado de la evaluación
     */
    function isValidDate(date) {
      if (Object.prototype.toString.call(date) !== '[object Date]') {
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

  //RestUtilsService.js
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
     */
    function saveData(service, data, returnPath) {
      service
        .save(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          $location.path(returnPath);
          return response;
        }, function error(response) {
          if (response.status === 404) {
            return 'Recurso no encontrado';
          }
          else {
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
     * @param {String} itemIdName - Nombre del identificador del recurso
     */
    function updateData(service, data, returnPath, itemIdName) {
      service
        .update(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          //$location.path(returnPath + '/' + response[itemIdName]);
          $location.path(returnPath);
          return response;
        }, function error(response) {
          if (response.status === 404) {
            return 'Recurso no encontrado';
          }
          else {
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

  //TokenService.js
  /**
   * @name TokenService
   * @constructor
   * @desc Proveedor para manejo del token
   * @param {Object} $window - Acceso a Objeto Window [AngularJS]
   * @param {Object} jwtHelper - Acceso a utilerías de token [Angular-jwt]
   * @return {TokenService} Token - Métodos para manejo de token
   */
  function TokenService($window, $http, $location, jwtHelper) {
    var tokenKey = 'sislab-token';
    var storage = $window.localStorage;
    var cachedToken;
    var Token = {};

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
     * @return {String} - Mensaje codificado
     */
    function hashMessage(message) {
      return CryptoJS.SHA256(message);
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
        if (response.status === 404) {
          return 'Sin enlace al servidor';
        }
        else {
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
      if (!cachedToken) {
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
     * @return {Object} - Token decodificado
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
      var decodedJwt;
      var userData;
      if (isAuthenticated()) {
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

  //ValidationService.js
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
      item.id_usuario_valida = user.id;
      item.motivo_rechaza = '';
      item.fecha_valida = DateUtilsService.dateToISOString(new Date()).slice(0,10);
    }

    function rejectItem(item, user) {
      item.id_status = 3;
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

  //MenuService.js
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

  //TaskService.js
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

  //StudyService.js
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
        params: {},
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


  //QuoteService.js
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
        params: {},
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

  //OrderService.js
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
        params: {},
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

  //PlanService.js
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
        params: {},
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

  //SheetService.js
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
        params: {},
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
    .factory('SheetService',
      [
        '$resource', 'TokenService',
        SheetService
      ]
    );

  //ReceptionService.js
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
        params: {},
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
    .factory('ReceptionService',
      [
        '$resource', 'TokenService',
        ReceptionService
      ]
    );

  //CustodyService.js
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
        params: {},
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
    .factory('CustodyService',
      [
        '$resource', 'TokenService',
        CustodyService
      ]
    );

  //ClientService.js
  /**
   * @name ClientService
   * @constructor
   * @desc Proveedor de datos, Cliente
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ClientService($resource, TokenService) {
    return $resource(API_BASE_URL + 'clients', {}, {
      query: {
        method: 'GET',
        params: {clientId: 'id_cliente'},
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
        params: {},
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
    .factory('ClientService',
      [
        '$resource', 'TokenService',
        ClientService
      ]
    );

  //PointService.js
  /**
   * @name PointService
   * @constructor
   * @desc Proveedor de datos, Puntos muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointService($resource, TokenService) {
    return $resource(API_BASE_URL + 'points', {}, {
      query: {
        method: 'GET',
        params: {pointId: 'id_punto'},
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
        params: {},
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
    .factory('PointService',
      [
        '$resource', 'TokenService',
        PointService
      ]
    );

  //PointsByPackageService.js
  /**
   * @name PointsByPackageService
   * @constructor
   * @desc Proveedor de datos, Puntos de muestreo por aquete
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointsByPackageService($resource, TokenService) {
    return $resource(API_BASE_URL + 'points/package', {}, {
      get: {
        method: 'GET',
        params: {pointId: 'id_paquete_punto'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PointsByPackageService',
      [
        '$resource', 'TokenService',
        PointsByPackageService
      ]
    );

  //ParameterService.js
  /**
   * @name ParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros de análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ParameterService($resource, TokenService) {
    return $resource(API_BASE_URL + 'parameters', {}, {
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
    .factory('ParameterService',
      [
        '$resource', 'TokenService',
        ParameterService
      ]
    );

  //NormService.js
  /**
   * @name NormService
   * @constructor
   * @desc Proveedor de datos, Normas referencia
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function NormService($resource, TokenService) {
    return $resource(API_BASE_URL + 'norms', {}, {
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
    .factory('NormService',
      [
        '$resource', 'TokenService',
        NormService
      ]
    );

  //SamplingTypeService.js
  /**
   * @name SamplingTypeService
   * @constructor
   * @desc Proveedor de datos, Tipos de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingTypeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/types', {}, {
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
    .factory('SamplingTypeService',
      [
        '$resource', 'TokenService',
        SamplingTypeService
      ]
    );

  //OrderSourceService.js
  /**
   * @name OrderSourceService
   * @constructor
   * @desc Proveedor de datos, Orígenes de orden
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function OrderSourceService($resource, TokenService) {
    return $resource(API_BASE_URL + 'order/sources', {}, {
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
    .factory('OrderSourceService',
      [
        '$resource', 'TokenService',
        OrderSourceService
      ]
    );

  //MatrixService.js
  /**
   * @name MatrixService
   * @constructor
   * @desc Proveedor de datos, Matrices
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MatrixService($resource, TokenService) {
    return $resource(API_BASE_URL + 'matrices', {}, {
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
    .factory('MatrixService',
      [
        '$resource', 'TokenService',
        MatrixService
      ]
    );

  //PointPackageService.js
  /**
   * @name PointPackageService
   * @constructor
   * @desc Proveedor de datos, Paquetes de puntos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointPackageService($resource, TokenService) {
    return $resource(API_BASE_URL + 'points/packages', {}, {
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
    .factory('PointPackageService',
      [
        '$resource', 'TokenService',
        PointPackageService
      ]
    );

  //SamplingSupervisorService.js
  /**
   * @name SamplingSupervisorService
   * @constructor
   * @desc Proveedor de datos, Supervisores de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingSupervisorService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/supervisors', {}, {
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
    .factory('SamplingSupervisorService',
      [
        '$resource', 'TokenService',
        SamplingSupervisorService
      ]
    );


  //PlanObjectivesService.js
  /**
   * @name PlanObjectivesService
   * @constructor
   * @desc Proveedor de datos, Objetivos plan
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PlanObjectivesService($resource, TokenService) {
    return $resource(API_BASE_URL + 'plan/objectives', {}, {
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
    .factory('PlanObjectivesService',
      [
        '$resource', 'TokenService',
        PlanObjectivesService
      ]
    );

  //PointKindsService.js
  /**
   * @name PointKindsService
   * @constructor
   * @desc Proveedor de datos, tipos Punto
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointKindsService($resource, TokenService) {
    return $resource(API_BASE_URL + 'point/kinds', {}, {
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
    .factory('PointKindsService',
      [
        '$resource', 'TokenService',
        PointKindsService
      ]
    );

  //DistrictService.js
  /**
   * @name DistrictService
   * @constructor
   * @desc Proveedor de datos, Municipios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function DistrictService($resource, TokenService) {
    return $resource(API_BASE_URL + 'districts', {}, {
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
    .factory('DistrictService',
      [
        '$resource', 'TokenService',
        DistrictService
      ]
    );

  //CityService.js
  /**
   * @name CityService
   * @constructor
   * @desc Proveedor de datos, Localidades
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CityService($resource, TokenService) {
    return $resource(API_BASE_URL + 'districts/cities/:districtId', {}, {
      query: {
        method: 'GET',
        params: {districtId: 'id_municipio'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('CityService',
      [
        '$resource', 'TokenService',
        CityService
      ]
    );

  //SamplingEmployeeService.js
  /**
   * @name SamplingEmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingEmployeeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/employees', {}, {
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
    .factory('SamplingEmployeeService',
      [
        '$resource', 'TokenService',
        SamplingEmployeeService
      ]
    );

  //PreservationService.js
  /**
   * @name PreservationService
   * @constructor
   * @desc Proveedor de datos, Preservaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PreservationService($resource, TokenService) {
    return $resource(API_BASE_URL + 'preservations', {}, {
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
    .factory('PreservationService',
      [
        '$resource', 'TokenService',
        PreservationService
      ]
    );

  //ContainerService.js
  /**
   * @name ContainerService
   * @constructor
   * @desc Proveedor de datos, Recipientes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ContainerService($resource, TokenService) {
    return $resource(API_BASE_URL + 'containers/kinds', {}, {
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
    .factory('ContainerService',
      [
        '$resource', 'TokenService',
        ContainerService
      ]
    );

  //ReactiveService.js
  /**
   * @name ReactiveService
   * @constructor
   * @desc Proveedor de datos, Reactivos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReactiveService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reactives', {}, {
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
    .factory('ReactiveService',
      [
        '$resource', 'TokenService',
        ReactiveService
      ]
    );

  //MaterialService.js
  /**
   * @name MaterialService
   * @constructor
   * @desc Proveedor de datos, Materiales
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MaterialService($resource, TokenService) {
    return $resource(API_BASE_URL + 'materials', {}, {
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
    .factory('MaterialService',
      [
        '$resource', 'TokenService',
        MaterialService
      ]
    );

  //CoolerService.js
  /**
   * @name CoolerService
   * @constructor
   * @desc Proveedor de datos, Hieleras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CoolerService($resource, TokenService) {
    return $resource(API_BASE_URL + 'coolers', {}, {
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
    .factory('CoolerService',
      [
        '$resource', 'TokenService',
        CoolerService
      ]
    );

  //SamplingInstrumentService.js
  /**
   * @name SamplingInstrumentService
   * @constructor
   * @desc Proveedor de datos, Equipos de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingInstrumentService($resource, TokenService) {
    return $resource(API_BASE_URL + 'instruments/sampling', {}, {
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
    .factory('SamplingInstrumentService',
      [
        '$resource', 'TokenService',
        SamplingInstrumentService
      ]
    );

  //FieldParameterService.js
  /**
   * @name FieldParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function FieldParameterService($resource, TokenService) {
    return $resource(API_BASE_URL + 'parameters/field', {}, {
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
    .factory('FieldParameterService',
      [
        '$resource', 'TokenService',
        FieldParameterService
      ]
    );

  //ReceptionistService.js
  /**
   * @name ReceptionistService
   * @constructor
   * @desc Proveedor de datos, Recepcionistas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReceptionistService($resource, TokenService) {
    return $resource(API_BASE_URL + 'receptionists', {}, {
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
    .factory('ReceptionistService',
      [
        '$resource', 'TokenService',
        ReceptionistService
      ]
    );

  //ExpirationService.js
  /**
   * @name ExpirationService
   * @constructor
   * @desc Proveedor de datos, Vigencias
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ExpirationService($resource, TokenService) {
    return $resource(API_BASE_URL + 'expirations', {}, {
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
    .factory('ExpirationService',
      [
        '$resource', 'TokenService',
        ExpirationService
      ]
    );

  //RequiredVolumeService.js
  /**
   * @name RequiredVolumeService
   * @constructor
   * @desc Proveedor de datos, Volúmenes requeridos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function RequiredVolumeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'volumes', {}, {
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
    .factory('RequiredVolumeService',
      [
        '$resource', 'TokenService',
        RequiredVolumeService
      ]
    );

  //SampleService.js
  /**
   * @name SampleService
   * @constructor
   * @desc Proveedor de datos, Muestras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SampleService($resource, TokenService) {
    return $resource(API_BASE_URL + 'samples/:sampleId', {}, {
      query: {
        method: 'GET',
        params: {sampleId: 'id_muestra'},
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
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SampleService',
      [
        '$resource', 'TokenService',
        SampleService
      ]
    );


  //SheetSampleService.js
  /**
   * @name SheetSampleService
   * @constructor
   * @desc Proveedor de datos, Muestras por Hoja de campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SheetSampleService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sheet/samples/:sheetId', {}, {
      get: {
        method: 'GET',
        params: {sheetId: 'id_hoja'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SheetSampleService',
      [
        '$resource', 'TokenService',
        SheetSampleService
      ]
    );

  //InstrumentsListService.js
  /**
   * @name InstrumentsListService
   * @constructor
   * @desc Proveedor de datos, Equipos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function InstrumentsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'instruments', {}, {
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
    .factory('InstrumentsListService',
      [
        '$resource', 'TokenService',
        InstrumentsListService
      ]
    );

  //ContainersListService.js
  /**
   * @name ContainersListService
   * @constructor
   * @desc Proveedor de datos, Recipientes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ContainersListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'containers', {}, {
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
    .factory('ContainersListService',
      [
        '$resource', 'TokenService',
        ContainersListService
      ]
    );

  //AnalysisListService.js
  /**
   * @name AnalysisListService
   * @constructor
   * @desc Proveedor de datos, consulta de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function AnalysisListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'analysis', {}, {
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
    .factory('AnalysisListService',
      [
        '$resource', 'TokenService',
        AnalysisListService
      ]
    );

  //DepartmentService.js
  /**
   * @name DepartmentService
   * @constructor
   * @desc Proveedor de datos, Áreas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function DepartmentService($resource, TokenService) {
    return $resource(API_BASE_URL + 'areas', {}, {
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
    .factory('DepartmentService',
      [
        '$resource', 'TokenService',
        DepartmentService
      ]
    );

  //AnalysisService.js
  /**
   * @name AnalysisService
   * @constructor
   * @desc Proveedor de datos, selección de formato de captura de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function AnalysisService($resource, TokenService) {
    return $resource(API_BASE_URL + 'analysis/selections', {}, {
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
    .factory('AnalysisService',
      [
        '$resource', 'TokenService',
        AnalysisService
      ]
    );

  //ReportsListService.js
  /**
   * @name ReportsListService
   * @constructor
   * @desc Proveedor de datos, Reportes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReportsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reports', {}, {
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
    .factory('ReportsListService',
      [
        '$resource', 'TokenService',
        ReportsListService
      ]
    );

  //ReportService.js
  /**
   * @name ReportService
   * @constructor
   * @desc Proveedor de datos, Reporte
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReportService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reports/:reportId', {}, {
      query: {
        method: 'GET',
        params: {reportId: 'id_reporte'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('ReportService',
      [
        '$resource', 'TokenService',
        ReportService
      ]
    );

  //EmployeeService.js
  /**
   * @name EmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function EmployeeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'employees', {}, {
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
    .factory('EmployeeService',
      [
        '$resource', 'TokenService',
        EmployeeService
      ]
    );

  //NormsListService.js
  /**
   * @name NormsListService
   * @constructor
   * @desc Proveedor de datos, Normas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function NormsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'norms', {}, {
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
    .factory('NormsListService',
      [
        '$resource', 'TokenService',
        NormsListService
      ]
    );

  //ReferencesListService.js
  /**
   * @name ReferencesListService
   * @constructor
   * @desc Proveedor de datos, Referencias
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReferencesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'references', {}, {
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
    .factory('ReferencesListService',
      [
        '$resource', 'TokenService',
        ReferencesListService
      ]
    );

  //MethodsListService.js
  /**
   * @name MethodsListService
   * @constructor
   * @desc Proveedor de datos, Métodos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function MethodsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'methods', {}, {
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
    .factory('MethodsListService',
      [
        '$resource', 'TokenService',
        MethodsListService
      ]
    );

  //PricesListService.js
  /**
   * @name PricesListService
   * @constructor
   * @desc Proveedor de datos, Precios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PricesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'prices', {}, {
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
    .factory('PricesListService',
      [
        '$resource', 'TokenService',
        PricesListService
      ]
    );

  //UsersListService.js
  /**
   * @name UsersListService
   * @constructor
   * @desc Proveedor de datos, Usuarios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function UsersListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'users', {}, {
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
    .factory('UsersListService',
      [
        '$resource', 'TokenService',
        UsersListService
      ]
    );

  //UserProfileService.js
  /**
   * @name UserProfileService
   * @constructor
   * @desc Proveedor de datos, Perfil de usuario
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function UserProfileService($resource, TokenService) {
    return $resource(API_BASE_URL + 'users/:userId', {}, {
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
    .factory('UserProfileService',
      [
        '$resource', 'TokenService',
        UserProfileService
      ]
    );



  //CloudService.js
  /**
   * @name CloudService
   * @constructor
   * @desc Proveedor de datos, Coberturas nubes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CloudService($resource, TokenService) {
    return $resource(API_BASE_URL + 'clouds', {}, {
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
    .factory('CloudService',
      [
        '$resource', 'TokenService',
        CloudService
      ]
    );

  //WindService.js
  /**
   * @name WindService
   * @constructor
   * @desc Proveedor de datos, Direcciones viento
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function WindService($resource, TokenService) {
    return $resource(API_BASE_URL + 'winds', {}, {
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
    .factory('WindService',
      [
        '$resource', 'TokenService',
        WindService
      ]
    );

  //WaveService.js
  /**
   * @name WaveService
   * @constructor
   * @desc Proveedor de datos, Intensidades oleaje
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function WaveService($resource, TokenService) {
    return $resource(API_BASE_URL + 'waves', {}, {
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
    .factory('WaveService',
      [
        '$resource', 'TokenService',
        WaveService
      ]
    );

  //SamplingNormService.js
  /**
   * @name SamplingNormService
   * @constructor
   * @desc Proveedor de datos, Normas muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingNormService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/norms', {}, {
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
    .factory('SamplingNormService',
      [
        '$resource', 'TokenService',
        SamplingNormService
      ]
    );
