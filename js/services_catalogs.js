
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
        params: {clientId: 'id_cliente'},
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
        params: {pointId: 'id_punto'},
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

  // PointsByPackageService.js
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

  // ParameterService.js
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

  // SamplingTypeService.js
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

  // OrderSourceService.js
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

  // PointPackageService.js
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

  // SamplingSupervisorService.js
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
    .factory('CityService',
      [
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

  // ContainerService.js
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

  // ReactiveService.js
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

  // SamplingInstrumentService.js
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
    .factory('CheckerService',
      [
        '$resource', 'TokenService',
        CheckerService
      ]
    );

  // SamplesListService.js
  /**
   * @name SamplesListService
   * @constructor
   * @desc Proveedor de datos, Muestras
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function SamplesListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'samples', {}, {
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
    .factory('SamplesListService',
      [
        '$resource', 'TokenService',
        SamplesListService
      ]
    );

  // InstrumentsListService.js
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

  // ContainersListService.js
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

  // ReportsListService.js
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
    .factory('ReportService',
      [
        '$resource', 'TokenService',
        ReportService
      ]
    );

  // PointsListService.js
  /**
   * @name PointsListService
   * @constructor
   * @desc Proveedor de datos, Puntos
   * @param {Object} $resource - Acceso a recursos HTTP [AngularJS]
   * @param {Object} TokenService - Proveedor de métodos para token
   * @return {Object} $resource - Acceso a recursos HTTP
   */
  function PointsListService($resource, TokenService) {
    return $resource(API_BASE_URL + 'points', {}, {
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
    .factory('PointsListService',
      [
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

  // NormsListService.js
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

  // ReferencesListService.js
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

  // PricesListService.js
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