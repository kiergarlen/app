/**
 * @name QuoteController
 * @constructor
 * @desc Controla la vista para capturar una Solicitud/Cotización
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ClientService - Proveedor de datos, Clientes
 * @param {Object} ParameterService - Proveedor de datos, Parámetros
 * @param {Object} NormService - Proveedor de datos, Normas
 * @param {Object} SamplingTypeService - Proveedor de datos, Tipos muestreo
 * @param {Object} QuoteService - Proveedor de datos, Cotizaciones
 */
function QuoteController(ClientService, ParameterService, NormService,
  SamplingTypeService, QuoteService) {
  var vm = this;
  vm.clients = ClientService.query();
  vm.parameters = ParameterService.query();
  vm.norms = NormService.query();
  vm.samplingTypes = SamplingTypeService.query();
  vm.quote = QuoteService.query();
  vm.clientDetailVisible = false;
  vm.parametersDetailVisible = false;
  vm.allParametersSelected = false;
  vm.totalCost = 0;

  vm.toggleClientDetail = toggleClientDetail;
  vm.toggleParametersDetail = toggleParametersDetail;
  vm.selectClient = selectClient;
  vm.totalParameter = totalParameter;
  vm.selectNorm = selectNorm;
  vm.selectNormParameters = selectNormParameters;
  vm.selectAllParameters = selectAllParameters;
  vm.selectSamplingType = selectSamplingType;
  vm.submitQuoteForm = submitQuoteForm;

  function selectItemFromCollection(id, collection, field) {
    var i = 0,
    l = collection.length,
    item = {};
    for (i; i < l; i += 1) {
      if (collection[i][field] == id)
      {
        item = collection[i];
        break;
      }
    }
    return item;
  }

  function toggleClientDetail() {
    var id = vm.quote.id_cliente;
    vm.clientDetailVisible = (
      vm.quote.id_cliente > 0 &&
      vm.selectClient(id).cliente &&
      !vm.clientDetailVisible
    );
  }

  function toggleParametersDetail() {
    vm.parametersDetailVisible = !vm.parametersDetailVisible;
  }

  function selectClient() {
    vm.quote.cliente = selectItemFromCollection(
      vm.quote.id_cliente,
      vm.clients,
      'id_cliente'
    );
    return vm.quote.cliente;
  }

  function totalParameter(){
    var i = 0, l = 0, t = 0;
    if (vm.parameters)
    {
      l = vm.parameters.length;
      for (i; i < l; i += 1) {
        if (vm.parameters[i].selected)
        {
          t = t + parseInt(vm.parameters[i].precio, 10);
        }
      }
      t = t * vm.quote.cliente.tasa;
      vm.totalCost = (Math.round(t * 100) / 100);
      vm.quote.total = vm.totalCost;
    }
    return vm.totalCost;
  }

  function selectNorm(idNorm) {
    var i, l;
    l = vm.norms.length;
    vm.quote.norma = {};
    vm.quote.parametros_seleccionados = [];
    vm.quote.allParametersSelected = false;
    for (i = 0; i < l; i += 1) {
      if (vm.norms[i].id_norma == idNorm)
      {
        vm.quote.norma = vm.norms[i];
        break;
      }
    }
    vm.selectNormParameters();
    return '';
  }

  function selectNormParameters() {
    var i, l, j, m;
    l = vm.parameters.length;
    for(i = 0; i < l; i += 1) {
      vm.parameters[i].selected = false;
      if (vm.quote.norma.parametros !== undefined)
      {
        m = vm.quote.norma.parametros.length;
        for (j = 0; j < m; j += 1) {
          if (vm.parameters[i].id_parametro ==
            vm.quote.norma.parametros[j].id_parametro)
          {
            vm.parameters[i].selected = true;
          }
        }
      }
    }
  }

  function selectAllParameters() {
    var i, l, j, m;
    l = vm.parameters.length;
    vm.quote.allParametersSelected = !vm.quote.allParametersSelected;
    for(i = 0; i < l; i += 1) {
      vm.parameters[i].selected = vm.quote.allParametersSelected;
    }
  }

  function selectSamplingType() {
    var i, l;
    l = vm.samplingTypes.length;
    for (i = 0; i < l; i += 1) {
      vn.samplingTypes[i].selected =
      (vm.samplingTypes[i].id_tipo_muestreo ==
        vm.quote.id_tipo_muestreo);
    }
  }

  function submitQuoteForm() {

  }
}

angular
  .module('siclabApp')
  .controller('QuoteController',
    [
      'ClientService', 'ParameterService', 'NormService',
      'SamplingTypeService', 'QuoteService',
      QuoteController
    ]
  );