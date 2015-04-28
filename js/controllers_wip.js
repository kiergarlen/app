  // ReceptionController.js
  /**
   * @name ReceptionController
   * @constructor
   * @desc Controla la vista para capturar la recepción de muestras
   * @this {Object} $scope - Contenedor para el modelo [AngularJS]
   * @param {Object} $routeParams - Proveedor de parámetros de ruta [AngularJS]
   * @param {Object} TokenService - Proveedor para manejo del token
   * @param {Object} ValidationService - Proveedor para manejo de validación
   * @param {Object} RestUtilsService - Proveedor para manejo de servicios REST
   * @param {Object} ArrayUtilsService - Proveedor para manejo de arreglos
   * @param {Object} DateUtilsService - Proveedor para manejo de fechas
   * @param {Object} SamplingEmployeeService - Proveedor de datos, Empleados muestreo
   * @param {Object} ReceptionService - Proveedor de datos, Recepción muestras
   */
  function ReceptionController($scope, $routeParams, TokenService,
    ValidationService, RestUtilsService, ArrayUtilsService,
    DateUtilsService, SamplingEmployeeService, ReceptionService) {
    var vm = this;
    vm.user = TokenService.getUserFromToken();
    vm.receptionists = SamplingEmployeeService.get();
    vm.reception = ReceptionService.query({receptionId: $routeParams.receptionId});
    vm.isDataSubmitted = false;
    vm.approveItem = approveItem;
    vm.rejectItem = rejectItem;
    vm.submitForm = submitForm;
    function selectSample() {
      /*
      var i = 0, l = vm.receptionists.length;
      vm.reception.recepcionista = {};
      for (i = 0; i < l; i += 1) {
        if (vm.receptionists[i].id_empleado == idRecepcionist)
        {
          vm.reception.recepcionista = vm.receptionists[i];
          break;
        }
      }
      return vm.reception.recepcionista;
      */
    }
    function approveItem() {
      ValidationService.approveItem(vm.reception, vm.user);
    }

    function rejectItem() {
      ValidationService.rejectItem(vm.reception, vm.user);
    }

    function isFormValid() {
      vm.message = '';
      if (vm.sheet.id_metodo_muestreo < 1)
      {
        vm.message += ' Seleccione una Norma de referencia ';
        return false;
      }
      return true;
    }


    function submitForm() {
      if (isFormValid() && !vm.isDataSubmitted)
      {
        vm.isDataSubmitted = true;
        if (vm.reception.id_recepcion < 1)
        {
          RestUtilsService
            .saveData(
              ReceptionService,
              vm.reception,
              'recepcion/recepcion',
              'id_recepcion'
            );
        }
        else
        {
          if (vm.user.level < 3 || vm.reception.reception.id_status < 2)
          {
            RestUtilsService
              .updateData(
                ReceptionService,
                vm.reception,
                'recepcion/recepcion',
                'id_recepcion'
              );
          }
        }
      }
    }
  }
  angular
    .module('sislabApp')
    .controller('ReceptionController',
      [
        '$scope', '$routeParams', 'TokenService',
        'ValidationService', 'RestUtilsService', 'ArrayUtilsService',
        'DateUtilsService','SamplingEmployeeService', 'ReceptionService',
        ReceptionController
      ]
    );
