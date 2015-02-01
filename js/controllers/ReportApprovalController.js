/**
 * @name ReportApprovalController
 * @constructor
 * @desc Controla la vista para validación Reporte
 * @this {Object} $scope - Contenedor para el modelo, AngularJS
 * @param {Object} ReportApprovalService - Proveedor de datos, validación Reporte
 */
function ReportApprovalController(ReportApprovalService) {
  var vm = this;
  vm.reportApproval = ReportApprovalService.query();


  vm.validateReportApprovalForm = validateReportApprovalForm;
  vm.submitReportApprovalForm = submitReportApprovalForm;

  function validateReportApprovalForm() {

  }

  function submitReportApprovalForm() {

  }
}

angular
  .module('siclabApp')
  .controller('ReportApprovalController',
    [
      'ReportApprovalService',
      ReportApprovalController
    ]
  );