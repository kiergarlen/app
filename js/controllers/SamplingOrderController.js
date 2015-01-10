function SamplingOrderController(QuoteService, OrderSourceService,
  MatrixService, ParameterService, SamplingSupervisorService,
  SamplingOrderService) {
  this.order = SamplingOrderService.query();
  this.quote = QuoteService.query();
  this.orderSources = OrderSourceService.query();
  this.matrices = MatrixService.query();
  this.supervisors = SamplingSupervisorService.query();
  this.parameters = ParameterService.query();

  this.selectOrderSource = function(idSource) {
  var i = 0, l = this.orderSources.length;
    this.order.origen_orden = {};
    for (i; i < l; i += 1) {
      if (this.orderSources[i].id_origen_orden == idSource)
      {
        this.order.origen_orden = this.orderSources[i];
        break;
      }
    }
    return this.order.origen_orden;
  };

  this.selectMatrix = function(idMatrix) {
  var i = 0, l = this.matrices.length;
    this.order.matriz = {};
    for (i; i < l; i += 1) {
      if (this.matrices[i].id_matriz == idMatrix)
      {
        this.order.matriz = this.matrices[i];
        break;
      }
    }
    return this.order.matriz;
  };

  this.selectSupervisor = function(idSupervisor) {
  var i = 0, l = this.supervisors.length;
    this.order.id_responsable_muestreo = {};
    for (i; i < l; i += 1) {
      if (this.supervisors[i].id_id_responsable_muestreo == idSupervisor)
      {
        this.order.id_responsable_muestreo = this.supervisors[i];
        break;
      }
    }
    return this.order.id_responsable_muestreo;
  };

  this.validateOrderForm = function() {

  };

  this.submitOrderForm = function() {

  };
}

angular
  .module('siclabApp')
  .controller('SamplingOrderController',
  ['$scope', 'QuoteService', 'OrderSourceService', 'MatrixService',
  SamplingPlanController
]);