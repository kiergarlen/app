
/**
 * @name siclabMenu
 * @desc Directiva para menú principal
 */
function siclabMenu() {
  return {
    restrict: 'EA',
    require: '^ngModel',
    templateUrl: 'partials/sistema/menu.html'
  };
}

angular
  .module('siclabApp')
  .directive('siclabMenu', siclabMenu);

/**
 * @name siclabBanner
 * @desc Directiva para banner superior
 */
function siclabBanner() {
  return {
    restrict: 'EA',
    templateUrl: 'partials/sistema/banner.html'
  };
}

angular
  .module('siclabApp')
  .directive('siclabBanner', siclabBanner);

/**
 * @name siclabFooter
 * @desc Directiva para pie de página
 */
function siclabFooter() {
  return {
    restrict: 'EA',
    templateUrl: 'partials/sistema/footer.html'
  };
}

angular
  .module('siclabApp')
  .directive('siclabFooter', siclabFooter);


/**
 * @name siclabBannerBottom
 * @desc Directiva para banner inferior
 */
function siclabBannerBottom() {
  return {
    restrict: 'EA',
    templateUrl: 'partials/sistema/banner-bottom.html'
  };
}

angular
  .module('siclabApp')
  .directive('siclabBannerBottom', siclabBannerBottom);
