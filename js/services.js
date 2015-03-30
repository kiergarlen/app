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
    ArrayUtils.extractItemFromCollection = extractItemFromCollection;
    ArrayUtils.countSelectedItems = countSelectedItems;
    ArrayUtils.averageFromValues = averageFromValues;

    /**
     * @function selectItemFromCollection
     * @desc Selecciona un ítem de un Array, empatando una propiedad y su valor
     * @param {Array} collection - Array de objetos a seleccionar
     * @param {String} field - Nombre de la propiedad a empatar
     * @param {Object} value - Valor de la propiedad a empatar
     * @return {Object} item - Item seleccionado
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
     * @desc Cuenta los objetos de un Array con valor TRUE de la propiedad 'selected'
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
    .factory('ArrayUtilsService', [
      ArrayUtilsService
    ]
  );

  // DateUtilsService.js
  /**
   * @name DateUtilsService
   * @constructor
   * @desc Proveedor para manejo de arreglos
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
      if (Object.prototype.toString.call(date) !== "[object Date]")
      {
        return false;
      }
      return !isNaN(date.getTime());
    }

    return DateUtils;
  }

  angular
    .module('sislabApp')
    .factory('DateUtilsService', [
      DateUtilsService
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
  function TokenService($window, jwtHelper) {
    var tokenKey = 'sislab-token',
    storage = $window.localStorage,
    cachedToken,
    Token = {};

    Token.isAuthenticated = isAuthenticated;
    Token.setToken = setToken;
    Token.getToken = getToken;
    Token.clearToken = clearToken;
    Token.decodeToken = decodeToken;
    Token.getUserFromToken = getUserFromToken;

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
    .factory('TokenService', [
      '$window', 'jwtHelper',
      TokenService
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
      query: {
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
    .factory('MenuService', [
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
      query: {
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
    .factory('TasksListService', [
      '$resource', 'TokenService',
      TasksListService
    ]
  );

  // ClientService.js
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
    .factory('ClientService', [
      '$resource', 'TokenService',
      ClientService
    ]
  );

  // ParameterService.js
  /**
   * @name ParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ParameterService($resource, TokenService) {
    return $resource(API_BASE_URL + 'parameters', {}, {
      query: {
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
    .factory('ParameterService', [
      '$resource', 'TokenService',
      ParameterService
    ]
  );

  // NormService.js
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
      query: {
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
    .factory('NormService', [
      '$resource', 'TokenService',
      NormService
    ]
  );

  // SamplingTypeService.js
  /**
   * @name SamplingTypeService
   * @constructor
   * @desc Proveedor de datos, Tipo muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingTypeService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/types', {}, {
      query: {
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
    .factory('SamplingTypeService', [
      '$resource', 'TokenService',
      SamplingTypeService
    ]
  );


  // StudyService.js
  /**
   * @name StudyService
   * @constructor
   * @desc Proveedor de datos, Estudio
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function StudyService($resource, TokenService) {
    return $resource(API_BASE_URL + 'studies/:studyId', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
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
      },
      query: {
        method: 'GET',
        params: {studyId: 'id_estudio'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'PUT',
        params: {studyId: 'id_estudio'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      remove: {
        method: 'DELETE',
        params: {studyId: 'id_estudio'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
    });
  }

  angular
    .module('sislabApp')
    .factory('StudyService', [
      '$resource', 'TokenService',
      StudyService
    ]
   );


  // QuoteService.js
  /**
   * @name QuoteService
   * @constructor
   * @desc Proveedor de datos, Cotizaciones
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
      }
    });
  }

  angular
    .module('sislabApp')
    .factory('QuoteService', [
      '$resource', 'TokenService',
      QuoteService
    ]
   );


  // OrderSourceService.js
  /**
   * @name OrderSourceService
   * @constructor
   * @desc Proveedor de datos, Orígenes orden
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function OrderSourceService($resource, TokenService) {
    return $resource(API_BASE_URL + 'order/sources', {}, {
      query: {
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
    .factory('OrderSourceService', [
      '$resource', 'TokenService',
      OrderSourceService
    ]
  );

  // MatrixService.js
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
      query: {
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
    .factory('MatrixService', [
      '$resource', 'TokenService',
      MatrixService
    ]
  );

  // SamplingSupervisorService.js
  /**
   * @name SamplingSupervisorService
   * @constructor
   * @desc Proveedor de datos, Supervisores muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplingSupervisorService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sampling/supervisors', {}, {
      query: {
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
    .factory('SamplingSupervisorService', [
      '$resource', 'TokenService',
      SamplingSupervisorService
    ]
  );

  // OrdersListService.js
  /**
   * @name OrdersListService
   * @constructor
   * @desc Proveedor de datos, lista de órdenes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function OrdersListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'orders', {}, {
      query: {
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
    .factory('OrdersListService', [
      '$resource', 'TokenService',
      OrdersListService
    ]
  );

  // OrderService.js
  /**
   * @name OrderService
   * @constructor
   * @desc Proveedor de datos, Orden muestreo
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
      }
    });
  }

  angular
    .module('sislabApp')
    .factory('OrderService', [
      '$resource', 'TokenService',
      OrderService
    ]
  );

  // PlanObjectivesService.js
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
      query: {
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
    .factory('PlanObjectivesService', [
      '$resource', 'TokenService',
      PlanObjectivesService
    ]
  );

  // PointKindsService.js
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
      query: {
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
    .factory('PointKindsService', [
      '$resource', 'TokenService',
      PointKindsService
    ]
  );

  // DistrictService.js
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
      query: {
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
    .factory('DistrictService', [
      '$resource', 'TokenService',
      DistrictService
    ]
  );

  // CityService.js
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
    .factory('CityService', [
      '$resource', 'TokenService',
      CityService
    ]
  );

  // SamplingEmployeeService.js
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
      query: {
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
    .factory('SamplingEmployeeService', [
      '$resource', 'TokenService',
      SamplingEmployeeService
    ]
  );

  // PreservationService.js
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
      query: {
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
    .factory('PreservationService', [
      '$resource', 'TokenService',
      PreservationService
    ]
  );

  // ContainerKindsService.js
  /**
   * @name ContainerKindsService
   * @constructor
   * @desc Proveedor de datos, Recipientes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ContainerKindsService($resource, TokenService) {
    return $resource(API_BASE_URL + 'containers/kinds', {}, {
      query: {
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
    .factory('ContainerKindsService', [
      '$resource', 'TokenService',
      ContainerKindsService
    ]
  );

  // ReactivesListService.js
  /**
   * @name ReactivesListService
   * @constructor
   * @desc Proveedor de datos, lista Reactivos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReactivesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reactives', {}, {
      query: {
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
    .factory('ReactivesListService', [
      '$resource', 'TokenService',
      ReactivesListService
    ]
  );

  // MaterialService.js
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
      query: {
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
    .factory('MaterialService', [
      '$resource', 'TokenService',
      MaterialService
    ]
  );

  // CoolerService.js
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
      query: {
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
    .factory('CoolerService', [
      '$resource', 'TokenService',
      CoolerService
    ]
  );

  // PlansListService.js
  /**
   * @name PlansListService
   * @constructor
   * @desc Proveedor de datos, Planes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PlansListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'plans', {}, {
      query: {
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
    .factory('PlansListService', [
      '$resource', 'TokenService',
      PlansListService
    ]
  );

  // PlanService.js
  /**
   * @name PlanService
   * @constructor
   * @desc Proveedor de datos, Plan muestreo
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
      }
    });
  }

  angular
    .module('sislabApp')
    .factory('PlanService', [
      '$resource', 'TokenService',
      PlanService
    ]
  );

  // CloudService.js
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
      query: {
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
    .factory('CloudService', [
      '$resource', 'TokenService',
      CloudService
    ]
  );

  // WindService.js
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
      query: {
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
    .factory('WindService', [
      '$resource', 'TokenService',
      WindService
    ]
  );

  // WaveService.js
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
      query: {
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
    .factory('WaveService', [
      '$resource', 'TokenService',
      WaveService
    ]
  );

  // SamplingNormService.js
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
      query: {
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
    .factory('SamplingNormService', [
      '$resource', 'TokenService',
      SamplingNormService
    ]
  );

  // PointService.js
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
    .factory('PointService', [
      '$resource', 'TokenService',
      PointService
    ]
  );

  // FieldParameterService.js
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
      query: {
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
    .factory('FieldParameterService', [
      '$resource', 'TokenService',
      FieldParameterService
    ]
  );

  // FieldSheetsListService.js
  /**
   * @name FieldSheetsListService
   * @constructor
   * @desc Proveedor de datos, lista de Hojas campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function FieldSheetsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sheets', {}, {
      query: {
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
    .factory('FieldSheetsListService', [
      '$resource', 'TokenService',
      FieldSheetsListService
    ]
  );

  // FieldSheetService.js
  /**
   * @name FieldSheetService
   * @constructor
   * @desc Proveedor de datos, Hoja campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function FieldSheetService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sheets/:sheetId', {}, {
      query: {
        method: 'GET',
        params: {sheetId: 'id_hoja_campo'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }

  angular
    .module('sislabApp')
    .factory('FieldSheetService', [
      '$resource', 'TokenService',
      FieldSheetService
    ]
  );

  // ReceptionistService.js
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
      query: {
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
    .factory('ReceptionistService', [
      '$resource', 'TokenService',
      ReceptionistService
    ]
  );

  // ReceptionsListService.js
  /**
   * @name ReceptionsListService
   * @constructor
   * @desc Proveedor de datos, lista de Recepciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReceptionsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'receptions', {}, {
      query: {
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
    .factory('ReceptionsListService', [
      '$resource', 'TokenService',
      ReceptionsListService
    ]
  );

  // ReceptionService.js
  /**
   * @name ReceptionService
   * @constructor
   * @desc Proveedor de datos, Recepción
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
      }
    });
  }

  angular
    .module('sislabApp')
    .factory('ReceptionService', [
      '$resource', 'TokenService',
      ReceptionService
    ]
  );

  // ExpirationService.js
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
      query: {
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
    .factory('ExpirationService', [
      '$resource', 'TokenService',
      ExpirationService
    ]
  );

  // RequiredVolumeService.js
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
      query: {
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
    .factory('RequiredVolumeService', [
      '$resource', 'TokenService',
      RequiredVolumeService
    ]
  );

  // CheckerService.js
  /**
   * @name CheckerService
   * @constructor
   * @desc Proveedor de datos, Responsables verificación
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CheckerService($resource, TokenService) {
    return $resource(API_BASE_URL + 'checkers', {}, {
      query: {
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
    .factory('CheckerService', [
      '$resource', 'TokenService',
      CheckerService
    ]
  );

  // CustodiesListService.js
  /**
   * @name CustodiesListService
   * @constructor
   * @desc Proveedor de datos, lista de Cadenas de custodia
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function CustodiesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'custodies', {}, {
      query: {
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
    .factory('CustodiesListService', [
      '$resource', 'TokenService',
      CustodiesListService
    ]
  );

  // CustodyService.js
  /**
   * @name CustodyService
   * @constructor
   * @desc Proveedor de datos, Cadenas custodia
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
      }
    });
  }

  angular
    .module('sislabApp')
    .factory('CustodyService', [
      '$resource', 'TokenService',
      CustodyService
    ]
  );

  // SamplesListService.js
  /**
   * @name SamplesListService
   * @constructor
   * @desc Proveedor de datos, lista Muestras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'samples', {}, {
      query: {
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
    .factory('SamplesListService', [
      '$resource', 'TokenService',
      SamplesListService
    ]
  );

  // InstrumentsListService.js
  /**
   * @name InstrumentsListService
   * @constructor
   * @desc Proveedor de datos, lista Equipos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function InstrumentsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'instruments', {}, {
      query: {
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
    .factory('InstrumentsListService', [
      '$resource', 'TokenService',
      InstrumentsListService
    ]
  );

  // ContainersListService.js
  /**
   * @name ContainersListService
   * @constructor
   * @desc Proveedor de datos, lista Recipients
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ContainersListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'containers', {}, {
      query: {
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
    .factory('ContainersListService', [
      '$resource', 'TokenService',
      ContainersListService
    ]
  );

  // AnalysisListService.js
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
      query: {
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
    .factory('AnalysisListService', [
      '$resource', 'TokenService',
      AnalysisListService
    ]
  );

  // DepartmentService.js
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
      query: {
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
    .factory('DepartmentService', [
      '$resource', 'TokenService',
      DepartmentService
    ]
  );

  // AnalysisService.js
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
      query: {
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
    .factory('AnalysisService', [
      '$resource', 'TokenService',
      AnalysisService
    ]
  );

  // ReportsListService.js
  /**
   * @name ReportsListService
   * @constructor
   * @desc Proveedor de datos, lista Reportes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReportsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'reports', {}, {
      query: {
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
    .factory('ReportsListService', [
      '$resource', 'TokenService',
      ReportsListService
    ]
  );

  // ReportService.js
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
    .factory('ReportService', [
      '$resource', 'TokenService',
      ReportService
    ]
  );

  // PointsListService.js
  /**
   * @name PointsListService
   * @constructor
   * @desc Proveedor de datos, lista Puntos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'points', {}, {
      query: {
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
    .factory('PointsListService', [
      '$resource', 'TokenService',
      PointsListService
    ]
  );

  // EmployeeService.js
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
      query: {
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
    .factory('EmployeeService', [
      '$resource', 'TokenService',
      EmployeeService
    ]
  );

  // NormsListService.js
  /**
   * @name NormsListService
   * @constructor
   * @desc Proveedor de datos, lista Normas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function NormsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'norms', {}, {
      query: {
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
    .factory('NormsListService', [
      '$resource', 'TokenService',
      NormsListService
    ]
  );

  // ReferencesListService.js
  /**
   * @name ReferencesListService
   * @constructor
   * @desc Proveedor de datos, lista Referencias
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ReferencesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'references', {}, {
      query: {
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
    .factory('ReferencesListService', [
      '$resource', 'TokenService',
      ReferencesListService
    ]
  );

  // MethodsListService.js
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
      query: {
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
    .factory('MethodsListService', [
      '$resource', 'TokenService',
      MethodsListService
    ]
  );

  // PricesListService.js
  /**
   * @name PricesListService
   * @constructor
   * @desc Proveedor de datos, lista Precios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PricesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'prices', {}, {
      query: {
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
    .factory('PricesListService', [
      '$resource', 'TokenService',
      PricesListService
    ]
  );

  // UsersListService.js
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
      query: {
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
    .factory('UsersListService', [
      '$resource', 'TokenService',
      UsersListService
    ]
  );

  // UserProfileService.js
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
      query: {
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
    .factory('UserProfileService', [
      '$resource', 'TokenService',
      UserProfileService
    ]
  );

  // QuotesListService.js
  /**
   * @name QuotesListService
   * @constructor
   * @desc Controla la vista para el listado de Solicitudes/Cotizaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function QuotesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'quotes', {}, {
      query: {
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
    .factory('QuotesListService', [
      '$resource', 'TokenService',
      QuotesListService
    ]
  );

  // ClientDetailService.js
  /**
   * @name ClientDetailService
   * @constructor
   * @desc Proveedor de datos, Detalle cliente
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function ClientDetailService($resource, TokenService) {
    return $resource(API_BASE_URL + 'clients/:clientId', {}, {
      query: {
        method: 'GET',
        params: {clientId:'id_cliente'},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }

  angular
    .module('sislabApp')
    .factory('ClientDetailService', [
      '$resource', 'TokenService',
      ClientDetailService
    ]
  );
