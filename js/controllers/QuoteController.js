function QuoteController(ClientService, ParameterService, NormService,
  SamplingTypeService, QuoteService) {
  this.clients = ClientService.query();
  this.parameters = ParameterService.query();
  this.norms = NormService.query();
  this.samplingTypes = SamplingTypeService.query();
  this.quote = QuoteService.query();
  this.clientDetailsIsShown = false;
  this.totalCost = 0;

  this.toggleClientInfo = function() {
    var id = this.quote.id_cliente;
    this.clientDetailsIsShown = (
      this.quote.id_cliente > 0 &&
      this.selectClient(id).cliente &&
      !this.clientDetailsIsShown
    );
  };

  this.selectClient = function(idClient) {
    var i = 0, l = this.clients.length;
    this.quote.cliente = {};
    for (i; i < l; i += 1) {
      if (this.clients[i].id_cliente == idClient) {
        this.quote.cliente = this.clients[i];
        break;
      }
    }
    return this.quote.cliente;
  };

  this.totalParameter = function(){
    var t = 0;
    angular.forEach(this.parameters, function(s){
      if(s.selected) {
        t += parseFloat(s.precio);
      }
    });
    t = t * this.quote.cliente.tasa;
    this.totalCost = (Math.round(t * 100) / 100);
    this.quote.total = this.totalCost;
    return this.totalCost;
  };

  this.selectNorm = function(idNorm) {
    var i, l, j, m, params;
    l = this.norms.length;
    this.quote.norma = {};
    this.quote.parametros_seleccionados = [];
    for (i = 0; i < l; i += 1) {
      if (this.norms[i].id_norma == idNorm) {
        this.quote.norma = this.norms[i];
        break;
      }
    }
    l = this.parameters.length;
    params = this.quote.norma.parametros;
    for(i = 0; i < l; i += 1) {
      this.parameters[i].selected = false;
      if (params !== undefined) {
        m = params.length;
        for (j = 0; j < m; j += 1) {
          if (this.parameters[i].id_parametro == params[j].id_parametro) {
            this.parameters[i].selected = true;
          }
        }
      }
    }
    return '';
  };

  this.submitQuoteForm = function () {

  };
}

angular
  .module('siclabApp')
  .controller('QuoteController',
 ['ClientService', 'ParameterService', 'NormService',
 'SamplingTypeService', 'QuoteService',
  QuoteController
]);