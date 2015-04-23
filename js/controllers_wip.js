  // SheetController.js
  /**
   * @name SheetController
   * @constructor
   * @desc Controla la vista para capturar la hoja de campo
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} CloudService - Proveedor de datos, Coberturas nubes
   * @param {Object} WindService - Proveedor de datos, Direcciones viento
   * @param {Object} WaveService - Proveedor de datos, Intensidades oleaje
   * @param {Object} SamplingNormService - Proveedor de datos, Normas muestreo
   * @param {Object} PreservationService - Proveedor de datos, Preservaciones
   * @param {Object} SheetService - Proveedor de datos, Hojas de campo
   */
  function SheetController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, CloudService, WindService,
    WaveService, SamplingNormService, PreservationService,
    SheetService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.sheet = SheetService.query({sheetId: $routeParams.sheetId});
    vm.cloudCovers = CloudService.get();
    vm.windDirections = WindService.get();
    vm.waveIntensities = WaveService.get();
    vm.samplingNorms = SamplingNormService.get();
    vm.preservations = PreservationService.get();
    /*
    SheetService
      .query({sheetId: $routeParams.sheetId})
      .$promise
      .then(function success(response) {
        vm.sheet = response;
      });
    */
    vm.isPreservationListLoaded = false;
    vm.isDataSubmitted = false;
    vm.selectPreservations = selectPreservations;
    vm.isResultListValid = isResultListValid;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.isFormValid = isFormValid;
    vm.submitForm = submitForm;

    function selectPreservations() {
      var items = [];
      if (vm.preservations.length > 0 && vm.sheet.preservaciones)
      {
        if (vm.sheet.preservaciones.length > 0 && !vm.isPreservationListLoaded)
        {
          ArrayUtilsService.seItemsFromReference(
            vm.preservations,
            vm.sheet.preservaciones,
            'id_preservacion',
            [
              'selected'
            ]
          );
          vm.isPreservationListLoaded = true;
        }
        else
        {
          vm.sheet.preservaciones = [];
          vm.sheet.preservaciones = ArrayUtilsService.selectItemsFromCollection(
            vm.preservations,
            'selected',
            true
          ).slice();
        }
      }
    }

    function approveItem() {
      ValidationService.approveItem(vm.sheet, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.sheet, vm.user);
    }

    function isResultListValid() {
      var i = 0,
      j = 0,
      l = 0,
      m = 0,
      samples = [],
      results = [];
      /*
      if (vm.sheet.muestras && vm.sheet.muestras.length > 0)
      {
        samples = vm.sheet.muestras;
        l = samples.length;
        for (i = 0; i < l; i += 1) {
          if (!DateUtilsService.isValidDate(new Date(samples[i].fecha_muestreo)))
          {
            vm.message += ' Ingrese una fecha/hora válida para el punto ';
            vm.message += samples[i].punto + ' ';
            return false;
          }
          results = samples[i].resultados.slice();
          m = results.length;
          for (j = 0; j < m; j += 1) {
            if (results[j].id_tipo_valor != 1)
            {
              if (results[j].valor_texto.length > 0 && results[j].valor_texto.length < 2)
              {
                vm.message += ' Ingrese un valor para el parámetro ';
                vm.message += results[j].parametro + ' ';
                vm.message += samples[i].punto + ' ';
                return false;
              }
            }
            else
            {
              if (isNaN(results[j].valor) || results[j].valor < 0)
              {
                vm.message += ' Ingrese un valor para el parámetro ';
                vm.message += results[j].parametro + ' ';
                vm.message += samples[i].punto + ' ';
                return false;
              }
            }
            if (isNaN(results[j].valor))
            console.log(results[j].parametro + ': ' + results[j].valor_texto + ' [' + results[j].id_tipo_valor + ']');
          }
        }
      }
      else
      {
        vm.message += ' No hay resultados ';
        return false;
      }
      */
      return true;
    }

    function isFormValid() {
      vm.message = '';
      if (vm.sheet.id_metodo_muestreo < 1)
      {
        vm.message += ' Seleccione una Norma de referencia ';
        return false;
      }
      if (!DateUtilsService.isValidDate(new Date(vm.sheet.fecha_inicio)))
      {
        vm.message += ' Ingrese una fecha/hora de muestreo válida ';
        return false;
      }
      if (!isResultListValid())
      {
        return false;
      }
      if (vm.sheet.id_nubes < 1)
      {
        vm.message += ' Seleccione una cobertura de nubes ';
        return false;
      }
      if (vm.sheet.id_direccion_corriente < 1)
      {
        vm.message += ' Seleccione una dirección de corriente ';
        return false;
      }
      if (vm.sheet.id_oleaje < 1)
      {
        vm.message += ' Seleccione una intensidad del oleaje ';
        return false;
      }
      if (vm.sheet.preservaciones.length < 1)
      {
        vm.message += ' Seleccione al menos un tipo de preservación ';
        return false;
      }
      if (vm.user.level < 3)
      {
        if (vm.sheet.id_status == 3 && vm.sheet.motivo_rechaza.length < 1)
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
        if (vm.sheet.id_hoja < 1)
        {
          //RestUtilsService
          //  .saveData(
          //    SheetService,
          //    vm.sheet,
          //    'recepcion/hoja',
          //    'id_hoja'
          //  );
        }
        else
        {
          if (vm.user.level < 3 || vm.sheet.sheet.id_status < 2)
          {
            //RestUtilsService
            //  .updateData(
            //    SheetService,
            //    vm.sheet,
            //    'recepcion/hoja',
            //    'id_hoja'
            //  );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('SheetController',
      [
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService', 'CloudService', 'WindService',
        'WaveService', 'SamplingNormService', 'PreservationService',
        'SheetService',
        SheetController
      ]
    );
