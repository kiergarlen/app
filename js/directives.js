//DIRECTIVES

function mainNav() {
  return {
    restrict: 'EA',
    require: '^ngModel',
    templateUrl: 'partials/sistema/nav.html'
  };
}

angular
  .module('siclabApp')
  .directive('mainNav', mainNav);