  // SERVICES
  // TokenService.js
  /**
   * @name TokenService
   * @constructor
   * @desc Proveedor para manejo del token
   * @param {Object} $window - Acceso a Objeto Window [AngularJS]
   * @return {Object} Object - Métodos para manejo de token
   */
  function TokenService($window) {
    var tokenKey = 'siclab-token',
    storage = $window.localStorage,
    cachedToken;

    return {
      isAuthenticated: function isAuthenticated() {
        return !!getToken();
      },
      setToken: function setToken(token) {
        cachedToken = token;
        storage.setItem(tokenKey, token);
      },
      getToken: function getToken() {
        if (!cachedToken)
        {
          cachedToken = storage.getItem(tokenKey);
        }
        return cachedToken;
      },
      clearToken: function clearToken() {
        cachedToken = null;
        storage.removeItem(tokenKey);
      }
    };
  }

  angular
    .module('siclabApp')
    .factory('TokenService', [
      '$window'
    ]
  );



  // MenuService.js
  /**
   * @name MenuService
   * @constructor
   * @desc Proveedor de datos, Menú
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MenuService($resource, $window) {
    return $resource(API_BASE_URL + 'menu', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MenuService', [
      '$resource', '$window',
      MenuService
    ]
  );

  // TasksListService.js
  /**
   * @name TasksListService
   * @constructor
   * @desc Proveedor de datos, Tareas
   * @param {Object} $resource- Acceso a recursos HTTP, AngularJS
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function TasksListService($resource, $window){
    return $resource(API_BASE_URL + 'tasks', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('TasksListService', [
      '$resource', '$window',
      TasksListService
    ]
  );

  // ClientService.js
  /**
   * @name ClientService
   * @constructor
   * @desc Proveedor de datos, Cliente
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ClientService($resource, $window) {
    return $resource(API_BASE_URL + 'clients', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ClientService', [
      '$resource', '$window',
      ClientService
    ]
  );

  // ParameterService.js
  /**
   * @name ParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ParameterService($resource, $window) {
    return $resource(API_BASE_URL + 'parameters', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token': $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ParameterService', [
      '$resource', '$window',
      ParameterService
    ]
  );

  // NormService.js
  /**
   * @name NormService
   * @constructor
   * @desc Proveedor de datos, Normas referencia
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function NormService($resource, $window) {
    return $resource(API_BASE_URL + 'norms', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('NormService', [
      '$resource', '$window',
      NormService
    ]
  );

  // SamplingTypeService.js
  /**
   * @name SamplingTypeService
   * @constructor
   * @desc Proveedor de datos, Tipo muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingTypeService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/types', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingTypeService', [
      '$resource', '$window',
      SamplingTypeService
    ]
  );

  // QuoteService.js
  /**
   * @name QuoteService
   * @constructor
   * @desc Proveedor de datos, Cotizaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function QuoteService($resource, $window) {
    return $resource(API_BASE_URL + 'quotes/:quoteId', {}, {
      query: {
        method:'GET',
        params:{quoteId:'id_solicitud'},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('QuoteService', [
      '$resource', '$window',
      QuoteService
    ]
   );


  // OrderSourceService.js
  /**
   * @name OrderSourceService
   * @constructor
   * @desc Proveedor de datos, Orígenes orden
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrderSourceService($resource, $window) {
    return $resource(API_BASE_URL + 'order/sources', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('OrderSourceService', [
      '$resource', '$window',
      OrderSourceService
    ]
  );

  // MatrixService.js
  /**
   * @name MatrixService
   * @constructor
   * @desc Proveedor de datos, Matrices
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MatrixService($resource, $window) {
    return $resource(API_BASE_URL + 'matrices', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MatrixService', [
      '$resource', '$window',
      MatrixService
    ]
  );

  // SamplingSupervisorService.js
  /**
   * @name SamplingSupervisorService
   * @constructor
   * @desc Proveedor de datos, Supervisores muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingSupervisorService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/supervisors', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingSupervisorService', [
      '$resource', '$window',
      SamplingSupervisorService
    ]
  );

  // OrdersListService.js
  /**
   * @name OrdersListService
   * @constructor
   * @desc Proveedor de datos, lista de órdenes de muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrdersListService($resource, $window) {
    return $resource(API_BASE_URL + 'orders', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('OrdersListService', [
      '$resource', '$window',
      OrdersListService
    ]
  );

  // OrderService.js
  /**
   * @name OrderService
   * @constructor
   * @desc Proveedor de datos, Orden muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function OrderService($resource, $window) {
    return $resource(API_BASE_URL + 'orders/:orderId', {}, {
      query: {
        method:'GET',
        params:{orderId: 'id_orden'},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('OrderService', [
      '$resource', '$window',
      OrderService
    ]
  );

  // PlanObjectivesService.js
  /**
   * @name PlanObjectivesService
   * @constructor
   * @desc Proveedor de datos, Objetivos plan
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlanObjectivesService($resource, $window) {
    return $resource(API_BASE_URL + 'plan/objectives', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PlanObjectivesService', [
      '$resource', '$window',
      PlanObjectivesService
    ]
  );

  // PointKindsService.js
  /**
   * @name PointKindsService
   * @constructor
   * @desc Proveedor de datos, tipos Punto
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointKindsService($resource, $window) {
    return $resource(API_BASE_URL + 'point/kinds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PointKindsService', [
      '$resource', '$window',
      PointKindsService
    ]
  );

  // DistrictService.js
  /**
   * @name DistrictService
   * @constructor
   * @desc Proveedor de datos, Municipios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function DistrictService($resource, $window) {
    return $resource(API_BASE_URL + 'districts', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('DistrictService', [
      '$resource', '$window',
      DistrictService
    ]
  );

  // CityService.js
  /**
   * @name CityService
   * @constructor
   * @desc Proveedor de datos, Localidades
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CityService($resource, $window) {
    return $resource(API_BASE_URL + 'districts/cities/:districtId', {}, {
      query: {
        method:'GET',
        params:{districtId: 'id_municipio'},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CityService', [
      '$resource', '$window',
      CityService
    ]
  );

  // SamplingEmployeeService.js
  /**
   * @name SamplingEmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingEmployeeService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/employees', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingEmployeeService', [
      '$resource', '$window',
      SamplingEmployeeService
    ]
  );

  // PreservationService.js
  /**
   * @name PreservationService
   * @constructor
   * @desc Proveedor de datos, Preservaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PreservationService($resource, $window) {
    return $resource(API_BASE_URL + 'preservations', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PreservationService', [
      '$resource', '$window',
      PreservationService
    ]
  );

  // ContainerKindsService.js
  /**
   * @name ContainerKindsService
   * @constructor
   * @desc Proveedor de datos, Recipientes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ContainerKindsService($resource, $window) {
    return $resource(API_BASE_URL + 'containers/kinds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ContainerKindsService', [
      '$resource', '$window',
      ContainerKindsService
    ]
  );

  // ReactivesListService.js
  /**
   * @name ReactivesListService
   * @constructor
   * @desc Proveedor de datos, lista Reactivos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReactivesListService($resource, $window) {
    return $resource(API_BASE_URL + 'reactives', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReactivesListService', [
      '$resource', '$window',
      ReactivesListService
    ]
  );

  // MaterialService.js
  /**
   * @name MaterialService
   * @constructor
   * @desc Proveedor de datos, Materiales
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MaterialService($resource, $window) {
    return $resource(API_BASE_URL + 'materials', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MaterialService', [
      '$resource', '$window',
      MaterialService
    ]
  );

  // CoolerService.js
  /**
   * @name CoolerService
   * @constructor
   * @desc Proveedor de datos, Hieleras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CoolerService($resource, $window) {
    return $resource(API_BASE_URL + 'coolers', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CoolerService', [
      '$resource', '$window',
      CoolerService
    ]
  );

  // PlansListService.js
  /**
   * @name PlansListService
   * @constructor
   * @desc Proveedor de datos, lista de Planes muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlansListService($resource, $window) {
    return $resource(API_BASE_URL + 'plans', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PlansListService', [
      '$resource', '$window',
      PlansListService
    ]
  );

  // PlanService.js
  /**
   * @name PlanService
   * @constructor
   * @desc Proveedor de datos, Plan muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PlanService($resource, $window) {
    return $resource(API_BASE_URL + 'plans/:planId', {}, {
      query: {
        method:'GET',
        params:{planId: 'id_plan'},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PlanService', [
      '$resource', '$window',
      PlanService
    ]
  );

  // CloudService.js
  /**
   * @name CloudService
   * @constructor
   * @desc Proveedor de datos, Coberturas nubes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CloudService($resource, $window) {
    return $resource(API_BASE_URL + 'clouds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CloudService', [
      '$resource', '$window',
      CloudService
    ]
  );

  // WindService.js
  /**
   * @name WindService
   * @constructor
   * @desc Proveedor de datos, Direcciones viento
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function WindService($resource, $window) {
    return $resource(API_BASE_URL + 'winds', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('WindService', [
      '$resource', '$window',
      WindService
    ]
  );

  // WaveService.js
  /**
   * @name WaveService
   * @constructor
   * @desc Proveedor de datos, Intensidades oleaje
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function WaveService($resource, $window) {
    return $resource(API_BASE_URL + 'waves', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('WaveService', [
      '$resource', '$window',
      WaveService
    ]
  );

  // SamplingNormService.js
  /**
   * @name SamplingNormService
   * @constructor
   * @desc Proveedor de datos, Normas muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplingNormService($resource, $window) {
    return $resource(API_BASE_URL + 'sampling/norms', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplingNormService', [
      '$resource', '$window',
      SamplingNormService
    ]
  );

  // PointService.js
  /**
   * @name PointService
   * @constructor
   * @desc Proveedor de datos, Puntos muestreo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointService($resource, $window) {
    return $resource(API_BASE_URL + 'points', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PointService', [
      '$resource', '$window',
      PointService
    ]
  );

  // FieldParameterService.js
  /**
   * @name FieldParameterService
   * @constructor
   * @desc Proveedor de datos, Parámetros campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function FieldParameterService($resource, $window) {
    return $resource(API_BASE_URL + 'parameters/field', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('FieldParameterService', [
      '$resource', '$window',
      FieldParameterService
    ]
  );

  // FieldSheetService.js
  /**
   * @name FieldSheetService
   * @constructor
   * @desc Proveedor de datos, Hojas campo
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function FieldSheetService($resource, $window) {
    //return $resource(API_BASE_URL + 'fieldsheets/:fieldsheetId', {}, {
    return $resource('models/field_sheets/1.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('FieldSheetService', [
      '$resource', '$window',
      FieldSheetService
    ]
  );

  // ReceptionistService.js
  /**
   * @name ReceptionistService
   * @constructor
   * @desc Proveedor de datos, Recepcionistas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReceptionistService($resource, $window) {
    return $resource(API_BASE_URL + 'receptionists', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReceptionistService', [
      '$resource', '$window',
      ReceptionistService
    ]
  );

  // ReceptionService.js
  /**
   * @name ReceptionService
   * @constructor
   * @desc Proveedor de datos, Recepción
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReceptionService($resource, $window) {
    //return $resource(API_BASE_URL + 'receptions/:receptionId', {}, {
    return $resource('models/sampling/samples/1.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReceptionService', [
      '$resource', '$window',
      ReceptionService
    ]
  );

  // ExpirationService.js
  /**
   * @name ExpirationService
   * @constructor
   * @desc Proveedor de datos, Vigencias
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ExpirationService($resource, $window) {
    return $resource(API_BASE_URL + 'expirations', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ExpirationService', [
      '$resource', '$window',
      ExpirationService
    ]
  );

  // RequiredVolumeService.js
  /**
   * @name RequiredVolumeService
   * @constructor
   * @desc Proveedor de datos, Volúmenes requeridos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function RequiredVolumeService($resource, $window) {
    return $resource(API_BASE_URL + 'volumes', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('RequiredVolumeService', [
      '$resource', '$window',
      RequiredVolumeService
    ]
  );

  // CheckerService.js
  /**
   * @name CheckerService
   * @constructor
   * @desc Proveedor de datos, Responsables verificación
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CheckerService($resource, $window) {
    return $resource(API_BASE_URL + 'checkers', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CheckerService', [
      '$resource', '$window',
      CheckerService
    ]
  );

  // CustodyService.js
  /**
   * @name CustodyService
   * @constructor
   * @desc Proveedor de datos, Cadenas custodia
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function CustodyService($resource, $window) {
    //return $resource(API_BASE_URL + 'custodies/:custodyId', {}, {
    return $resource('models/custodies/100.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:false,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('CustodyService', [
      '$resource', '$window',
      CustodyService
    ]
  );

  // SamplesListService.js
  /**
   * @name SamplesListService
   * @constructor
   * @desc Proveedor de datos, lista Muestras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function SamplesListService($resource, $window) {
    return $resource(API_BASE_URL + 'samples', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('SamplesListService', [
      '$resource', '$window',
      SamplesListService
    ]
  );

  // InstrumentsListService.js
  /**
   * @name InstrumentsListService
   * @constructor
   * @desc Proveedor de datos, lista Equipos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function InstrumentsListService($resource, $window) {
    return $resource(API_BASE_URL + 'instruments', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('InstrumentsListService', [
      '$resource', '$window',
      InstrumentsListService
    ]
  );

  // ContainersListService.js
  /**
   * @name ContainersListService
   * @constructor
   * @desc Proveedor de datos, lista Recipients
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ContainersListService($resource, $window) {
    return $resource(API_BASE_URL + 'containers', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ContainersListService', [
      '$resource', '$window',
      ContainersListService
    ]
  );

  // AnalysisListService.js
  /**
   * @name AnalysisListService
   * @constructor
   * @desc Proveedor de datos, consulta de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function AnalysisListService($resource, $window) {
    return $resource(API_BASE_URL + 'analysis', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('AnalysisListService', [
      '$resource', '$window',
      AnalysisListService
    ]
  );

  // DepartmentService.js
  /**
   * @name DepartmentService
   * @constructor
   * @desc Proveedor de datos, Áreas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function DepartmentService($resource, $window) {
    return $resource(API_BASE_URL + 'areas', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('DepartmentService', [
      '$resource', '$window',
      DepartmentService
    ]
  );

  // AnalysisService.js
  /**
   * @name AnalysisService
   * @constructor
   * @desc Proveedor de datos, selección de formato de captura de Análisis
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function AnalysisService($resource, $window) {
    return $resource(API_BASE_URL + 'analysis/selections', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('AnalysisService', [
      '$resource', '$window',
      AnalysisService
    ]
  );

  // ReportsListService.js
  /**
   * @name ReportsListService
   * @constructor
   * @desc Proveedor de datos, lista Reportes
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReportsListService($resource, $window) {
    return $resource(API_BASE_URL + 'reports', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReportsListService', [
      '$resource', '$window',
      ReportsListService
    ]
  );

  // ReportApprovalService.js
  /**
   * @name ReportApprovalService
   * @constructor
   * @desc Proveedor de datos, validación Reporte
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReportApprovalService($resource, $window) {
    //return $resource(API_BASE_URL + 'reports/:reportId', {}, {
    return $resource('models/report.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReportApprovalService', [
      '$resource', '$window',
      ReportApprovalService
    ]
  );

  // PointsListService.js
  /**
   * @name PointsListService
   * @constructor
   * @desc Proveedor de datos, lista Puntos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PointsListService($resource, $window) {
    return $resource(API_BASE_URL + 'points', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PointsListService', [
      '$resource', '$window',
      PointsListService
    ]
  );

  // EmployeeService.js
  /**
   * @name EmployeeService
   * @constructor
   * @desc Proveedor de datos, Empleados
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function EmployeeService($resource, $window) {
    return $resource(API_BASE_URL + 'employees', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('EmployeeService', [
      '$resource', '$window',
      EmployeeService
    ]
  );

  // NormsListService.js
  /**
   * @name NormsListService
   * @constructor
   * @desc Proveedor de datos, lista Normas
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function NormsListService($resource, $window) {
    return $resource(API_BASE_URL + 'norms', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('NormsListService', [
      '$resource', '$window',
      NormsListService
    ]
  );

  // ReferencesListService.js
  /**
   * @name ReferencesListService
   * @constructor
   * @desc Proveedor de datos, lista Referencias
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ReferencesListService($resource, $window) {
    return $resource(API_BASE_URL + 'references', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ReferencesListService', [
      '$resource', '$window',
      ReferencesListService
    ]
  );

  // MethodsListService.js
  /**
   * @name MethodsListService
   * @constructor
   * @desc Proveedor de datos, Métodos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function MethodsListService($resource, $window) {
    return $resource(API_BASE_URL + 'methods', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('MethodsListService', [
      '$resource', '$window',
      MethodsListService
    ]
  );

  // PricesListService.js
  /**
   * @name PricesListService
   * @constructor
   * @desc Proveedor de datos, lista Precios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function PricesListService($resource, $window) {
    return $resource(API_BASE_URL + 'prices', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('PricesListService', [
      '$resource', '$window',
      PricesListService
    ]
  );

  // UsersListService.js
  /**
   * @name UsersListService
   * @constructor
   * @desc Proveedor de datos, Usuarios
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function UsersListService($resource, $window) {
    return $resource(API_BASE_URL + 'users', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('UsersListService', [
      '$resource', '$window',
      UsersListService
    ]
  );

  // UserProfileService.js
  /**
   * @name UserProfileService
   * @constructor
   * @desc Proveedor de datos, Perfil de usuario
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function UserProfileService($resource, $window) {
    //return $resource(API_BASE_URL + 'users/:userId', {}, {
    return $resource('models/profile.json', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('UserProfileService', [
      '$resource', '$window',
      UserProfileService
    ]
  );

  // QuotesListService.js
  /**
   * @name QuotesListService
   * @constructor
   * @desc Proveedor de datos, lista de Cotizaciones
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function QuotesListService($resource, $window) {
    return $resource(API_BASE_URL + 'quotes', {}, {
      query: {
        method:'GET',
        params:{},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('QuotesListService', [
      '$resource', '$window',
      QuotesListService
    ]
  );

  // ClientDetailService.js
  /**
   * @name ClientDetailService
   * @constructor
   * @desc Proveedor de datos, Detalle cliente
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @return {Object} $resource - Acceso a recursos HTTP, según ruta y parámetros
   */
  function ClientDetailService($resource, $window) {
    //return $resource(API_BASE_URL + 'clients/:clientId', {}, {
    return $resource('models/clients/:clientId.json', {}, {
      query: {
        method:'GET',
        params:{clientId:'id_cliente'},
        isArray:true,
        headers: {
          'Auth-Token' : $window.localStorage.getItem('siclab-token')
        }
      }
    });
  }

  angular
    .module('siclabApp')
    .factory('ClientDetailService', [
      '$resource', '$window',
      ClientDetailService
    ]
  );
