/**
 * @name OrderController
 * @constructor
 * @desc Controla la vista para capturar una Orden de muestreo
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
 * @param {Object} OrderSourceService - Proveedor de datos, Orígenes orden
 * @param {Object} MatrixService - Proveedor de datos, Tipos matriz
 * @param {Object} ParameterService - Proveedor de datos, Parámetros
 * @param {Object} SamplingSupervisorService - Proveedor de datos, Supervisores muestreo
 * @param {Object} OrderService - Proveedor de datos, Orden muestreo
 */
function OrderController(QuoteService, OrderSourceService,
  MatrixService, ParameterService, SamplingSupervisorService,
  OrderService) {
  var vm = this;
  vm.order = OrderService.query();
  vm.quote = QuoteService.query();
  vm.orderSources = OrderSourceService.query();
  vm.matrices = MatrixService.query();
  vm.supervisors = SamplingSupervisorService.query();
  vm.parameters = ParameterService.query();
  vm.parametersDetailVisible = false;

  vm.toggleParametersDetail = toggleParametersDetail;
  vm.selectOrderSource = selectOrderSource;
  vm.selectMatrix = selectMatrix;
  vm.selectSupervisor = selectSupervisor;
  vm.validateOrderForm = validateOrderForm;
  vm.submitOrderForm = submitOrderForm;

  function toggleParametersDetail() {
    vm.parametersDetailVisible = !vm.parametersDetailVisible;
  }

  function selectOrderSource(idSource) {
    var i = 0, l = vm.orderSources.length;
    vm.order.origen_orden = {};
    for (i; i < l; i += 1) {
      if (vm.orderSources[i].id_origen_orden == idSource)
      {
        vm.order.origen_orden = vm.orderSources[i];
        break;
      }
    }
    return vm.order.origen_orden;
  }

  function selectMatrix(idMatrix) {
    var i = 0, l = vm.matrices.length;
    vm.order.matriz = {};
    for (i; i < l; i += 1) {
      if (vm.matrices[i].id_matriz == idMatrix)
      {
        vm.order.matriz = vm.matrices[i];
        break;
      }
    }
    return vm.order.matriz;
  }

  function selectSupervisor(idSupervisor) {
    var i = 0, l = vm.supervisors.length;
    vm.order.id_responsable_muestreo = {};
    for (i; i < l; i += 1) {
      if (vm.supervisors[i].id_id_responsable_muestreo == idSupervisor)
      {
        vm.order.id_responsable_muestreo = vm.supervisors[i];
        break;
      }
    }
    return vm.order.id_responsable_muestreo;
  }

  function validateOrderForm() {

  }

  function submitOrderForm() {

  }
}

angular
  .module('siclabApp')
  .controller('OrderController',
    [
      'QuoteService','OrderSourceService','MatrixService',
      'ParameterService','SamplingSupervisorService','OrderService',
      OrderController
    ]
  );