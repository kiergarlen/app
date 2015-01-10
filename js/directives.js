//DIRECTIVES

function mainMenu() {
  return {
    restrict: 'EA',
    require: '^ngModel',
    templateUrl: 'partials/sistema/menu.html'
  };
}

angular
  .module('siclabApp')
  .directive('mainMenu', mainMenu);