  //CONTROLLERS
  //LoginController.js
  /**
   * @name LoginController
   * @constructor
   * @desc Controla la vista para Login
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $http - Manejo de peticiones HTTP [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   */
  function LoginController($scope, TokenService) {
    var vm = this;
    vm.message = '';
    vm.user = {username: '', password: ''};
    vm.submitForm = submitForm;

    function submitForm() {
      vm.message = '';
      if (!$scope.loginForm.$valid)
      {
        vm.message = 'Ingrese usuario y/o contraseña';
        return;
      }

      vm.message = TokenService.authenticateUser(
        vm.user.username,
        vm.user.password
      );
    }
  }
  angular
    .module('sislabApp')
    .controller('LoginController',
      [
        '$scope', 'TokenService',
        LoginController
      ]
    );

  //MenuController.js
  /**
   * @name MenuController
   * @constructor
   * @desc Controla la directiva para el Menú principal
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} MenuService - Proveedor de datos, Menú
   */
  function MenuController(MenuService) {
    var vm = this;
    vm.menu = MenuService.query();
  }
  angular
    .module('sislabApp')
    .controller('MenuController',
      [
        'MenuService',
        MenuController
      ]
    );

  //TasksListController.js
  /**
   * @name TasksListController
   * @constructor
   * @desc Controla la vista para Tareas
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} TasksListService - Proveedor de datos, Tareas
   */
  function TasksListController(TokenService, TasksListService) {
    var vm = this,
    userData;
    vm.userName = '';
    vm.tasks = {};
    if (TokenService.isAuthenticated())
    {
      userData = TokenService.getUserFromToken();
      vm.userName = userData.name;
      vm.tasks = TasksListService.query(userData.id);
    }
  }
  angular
    .module('sislabApp')
    .controller('TasksListController',
      [
        'TokenService', 'TasksListService',
        TasksListController
      ]
    );

  //StudiesListController.js
  /**
   * @name StudiesListController
   * @constructor
   * @desc Controla la vista para el listado de Estudios
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudiesListController($location, StudyService) {
    var vm = this;
    vm.studies = StudyService.get();
    vm.addStudy = addStudy;
    vm.viewStudy = viewStudy;

    function addStudy() {
      $location.path('/estudio/estudio/0');
    }

    function viewStudy(id) {
      $location.path('/estudio/estudio/' + parseInt(id));
    }
  }
  angular
    .module('sislabApp')
    .controller('StudiesListController',
      [
        '$location', 'StudyService',
        StudiesListController
      ]
    );

  //StudyController.js
  /**
   * @name StudyController
   * @constructor
   * @desc Controla la vista para capturar un Estudio
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} ClientService - Proveedor de datos, Clientes
   * @param {Object} MatrixService - Proveedor de datos, Matrices
   * @param {Object} SamplingTypeService - Proveedor de datos, Tipos de muestreo
   * @param {Object} NormService - Proveedor de datos, Normas
   * @param {Object} OrderSourceService - Proveedor de datos, Orígenes de orden
   * @param {Object} StudyService - Proveedor de datos, Estudios
   */
  function StudyController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, ClientService, MatrixService,
    SamplingTypeService, NormService, OrderSourceService,
    StudyService) {
    var vm = this;
    vm.study = StudyService.query({studyId: $routeParams.studyId});
    vm.user = TokenService.getUserFromToken();
    vm.clients = ClientService.query();
    vm.matrices = MatrixService.query();
    vm.samplingTypes = SamplingTypeService.query();
    vm.norms = NormService.query();
    vm.orderSources = OrderSourceService.query();
    vm.message = '';
    vm.isDataSubmitted = false;
    vm.selectClient = selectClient;
    vm.getStudyScope = getStudyScope;
    vm.addQuote = addQuote;
    vm.removeQuote = removeQuote;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;


    function selectClient() {
      vm.study.cliente = ArrayUtilsService.selectItemFromCollection(
        vm.clients,
        'id_cliente',
        vm.study.id_cliente
      );
      return vm.study.cliente;
    }

    function getStudyScope() {
      return vm;
    }

    function addQuote() {
      vm.study.solicitudes.push({
        'id_solicitud':vm.study.solicitudes.length + 1,
        'id_estudio':vm.study.id_estudio,
        'id_matriz':0,
        'cantidad_muestras':0,
        'id_tipo_muestreo':1,
        'id_norma':0
      });
    }

    function removeQuote(e) {
      var field = '$$hashKey',
      quoteRow = ArrayUtilsService.extractItemFromCollection(
        vm.study.solicitudes,
        field,
        e[field]
      );
    }

    function approveItem() {
      ValidationService.approveItem(vm.study, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.study, vm.user);
    }

    function isQuoteListValid() {
      var i = 0,
      l = 0,
      quotes = [];
      if (vm.study.solicitudes && vm.study.solicitudes.length > 0)
      {
        quotes = vm.study.solicitudes;
        l = quotes.length;
        for (i = 0; i < l; i += 1) {
          if (quotes[i].id_matriz < 1)
          {
            vm.message += ' Seleccione una matriz, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (isNaN(quotes[i].cantidad_muestras) || quotes[i].cantidad_muestras < 1)
          {
            vm.message += ' Ingrese cantidad de muestras, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (quotes[i].id_tipo_muestreo < 1)
          {
            vm.message += ' Seleccione un tipo de muestreo, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
          if (quotes[i].id_norma < 1)
          {
            vm.message += ' Seleccione una norma, para la solicitud ';
            vm.message += '(Ver fila ' + (i + 1) + ')';
            return false;
          }
        }
      }
      else
      {
        vm.message += ' No tiene relacionada ninguna solicitud';
        return false;
      }
      return true;
    }

    function isFormValid() {
      var validQuotes = false;
      vm.message = '';
      if (!DateUtilsService.isValidDate(new Date(vm.study.fecha)))
      {
        vm.message += ' Ingrese una fecha válida ';
        return false;
      }
      if (vm.study.id_cliente < 1)
      {
        vm.message += ' Seleccione un cliente ';
        return false;
      }
      validQuotes = isQuoteListValid();
      if (!validQuotes)
      {
        return false;
      }
      if (vm.study.id_origen_orden < 1)
      {
        vm.message += ' Seleccione un medio de solicitud de muestreo ';
        return false;
      }
      if (vm.study.id_origen_orden == 1 || vm.study.id_origen_orden == 4)
      {
        if (vm.study.origen_descripcion.length < 1)
        {
          vm.message += ' Ingrese oficio o emergencia ';
          return false;
        }
      }
      if (vm.study.ubicacion.length < 1)
      {
        vm.message += ' Ingrese una ubicación ';
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.study.id_status == 3 && vm.study.motivo_rechaza.length < 1)
        {
          vm.message += ' Ingrese el motivo de rechazo del Informe ';
          return false;
        }
      }
      return true;
    }

    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.study.id_estudio > 0)
        {
          RestUtilsService
            .saveData(
              StudyService,
              vm.study,
              'estudio/estudio',
              'id_estudio'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.study.study.id_status < 2)
          {
            RestUtilsService
              .updateData(
                StudyService,
                vm.study,
                'estudio/estudio',
                'id_estudio'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('StudyController',
      [
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'ClientService', 'MatrixService',
        'SamplingTypeService', 'NormService', 'OrderSourceService',
        'StudyService',
        StudyController
      ]
    );

  //QuotesListController.js
  /**
   * @name QuotesListController
   * @constructor
   * @desc Controla la vista para el listado de Solicitudes/Cotizaciones
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $location - Manejo de URL [AngularJS]
   * @param {Object} QuoteService - Proveedor de datos, Solicitud
   */
  function QuotesListController($location, QuoteService) {
    var vm = this;
    vm.quotes = QuoteService.get();
    vm.viewQuote = viewQuote;

    function viewQuote(id) {
      var itemId = parseInt(id);
      $location.path('/muestreo/solicitud/' + itemId);
    }
  }
  angular
    .module('sislabApp')
    .controller('QuotesListController',
      [
        '$location', 'QuoteService',
        QuotesListController
      ]
    );
