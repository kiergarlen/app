(function(window, document, undefined) {
  'use strict';
  var API_BASE_URL = 'api/v1/';
  angular
    .module('sislabApp', [
      'ngRoute',
      'ngResource',
      'ngAnimate',
      'angular-jwt',
      'mgcrea.ngStrap'
    ]
  );
  function TokenService($window, $http, $location, jwtHelper) {
    var tokenKey = 'sislab-token',
    storage = $window.localStorage,
    cachedToken,
    Token = {};
    Token.authenticateUser = authenticateUser;
    Token.isAuthenticated = isAuthenticated;
    Token.setToken = setToken;
    Token.getToken = getToken;
    Token.clearToken = clearToken;
    Token.decodeToken = decodeToken;
    Token.getUserFromToken = getUserFromToken;

    function authenticateUser(username, password) {
      $http({
        url: API_BASE_URL + 'login',
        method: 'POST',
        data: {
          username: username,
          password: password
        }
      }).then(function success(response) {
        var token = response.data || null;
        setToken(token);
        $location.path('main');
      }, function error(response) {
        if (response.status === 404)
        {
          return 'Sin enlace al servidor';
        }
        else
        {
          return 'Error no especificado';
        }
      });
    }

    function isAuthenticated() {
      return !!getToken();
    }

    function setToken(token) {
      cachedToken = token;
      storage.setItem(tokenKey, token);
    }

    function getToken() {
      if (!cachedToken)
      {
        cachedToken = storage.getItem(tokenKey);
      }
      return cachedToken;
    }

    function clearToken() {
      cachedToken = null;
      storage.removeItem(tokenKey);
    }

    function decodeToken() {
      var token = getToken();
      return token && jwtHelper.decodeToken(token);
    }

    function getUserFromToken() {
      var decodedJwt,
      userData;
      if (isAuthenticated())
      {
        decodedJwt = decodeToken();
        userData = {
          name: decodedJwt.nam,
          id: decodedJwt.uid,
          level: decodedJwt.ulv
        };
      }
      return userData;
    }

    return Token;
  }
  angular
    .module('sislabApp')
    .factory('TokenService',
      [
        '$window', '$http', '$location', 'jwtHelper',
        TokenService
      ]
    );
  function ArrayUtilsService() {
    var ArrayUtils = {};
    ArrayUtils.selectItemFromCollection = selectItemFromCollection;
    ArrayUtils.selectItemsFromCollection = selectItemsFromCollection;
    ArrayUtils.extractItemFromCollection = extractItemFromCollection;
    ArrayUtils.seItemsFromReference = seItemsFromReference;
    ArrayUtils.countSelectedItems = countSelectedItems;
    ArrayUtils.averageFromValues = averageFromValues;

    function selectItemFromCollection(collection, field, value) {
      var i = 0,
      l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value)
        {
          item = collection[i];
          break;
        }
      }
      return item;
    }

    function selectItemsFromCollection(collection, field, value) {
      var i = 0,
      l = collection.length,
      items = [];
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value)
        {
          items.push(collection[i]);
        }
      }
      return items;
    }

    function extractItemFromCollection(collection, field, value) {
      var i = 0,
      l = collection.length,
      item = {};
      for (i = 0; i < l; i += 1) {
        if (collection[i][field] == value)
        {
          item = collection.splice(i, 1);
          break;
        }
      }
      return item;
    }

    function seItemsFromReference(collection, referenceCollection, matchField, fields) {
      var i, l, j, m, k, n, field = '';
      l = collection.length;
      n = fields.length;
      for(i = 0; i < l; i += 1) {
        if (referenceCollection !== undefined)
        {
          m = referenceCollection.length;
          for (j = 0; j < m; j += 1) {
            if (collection[i][matchField] ==
              referenceCollection[j][matchField])
            {
              for (k = 0; k < n; k += 1) {
                field = fields[k];
                collection[i][field] = referenceCollection[j][field];
              }
            }
          }
        }
      }
      return collection;
    }

    function countSelectedItems(collection){
      var i, l, count = 0;
      if (!collection)
      {
        return 0;
      }
      l = collection.length;
      for (i = 0; i < l; i += 1) {
        if (collection[i].selected)
        {
          count += 1;
        }
      }
      return count;
    }

    function averageFromValues(collection) {
      var i = 0,
      l = collection.length,
      sum = 0,
      avg = 0;
      if (l > 0)
      {
        for (i; i < l; i++) {
          sum += parseFloat(collection[i]);
        }
        avg = Math.round((sum / l) * 1000 * 1000) / (1000 * 1000);
      }
      return avg;
    }

    return ArrayUtils;
  }
  angular
    .module('sislabApp')
    .factory('ArrayUtilsService',
      [
        ArrayUtilsService
      ]
    );
  function DateUtilsService() {
    var DateUtils = {};

    DateUtils.padNumber = padNumber;
    DateUtils.dateToISOString = dateToISOString;
    DateUtils.isValidDate = isValidDate;

    function padNumber(number, places) {
      var paddedNumber = String(number),
      i = 0,
      l = paddedNumber.length,
      padding = '';
      if (l < places)
      {
        l = places - l;
        for (i = 0; i < l; i += 1) {
          padding += '0';
        }
        return padding + '' + paddedNumber;
      }
      return paddedNumber;
    }

    function dateToISOString(date) {
      return [
        date.getFullYear(),
        '-',
        padNumber(date.getMonth() + 1, 2),
        '-',
        padNumber(date.getDate(), 2),
        'T',
        padNumber(date.getHours(), 2),
        ':',
        padNumber(date.getMinutes(), 2),
        ':',
        padNumber(date.getSeconds(), 2),
        '.',
        (date.getMilliseconds() / 1000).toFixed(3).slice(2, 5),
        (date.getTimezoneOffset() / 60 > -1) ? '+' : '-',
        padNumber(date.getTimezoneOffset() / 60, 2),
        ':00'
      ].join('');
    }

    function isValidDate(date) {
      if (Object.prototype.toString.call(date) !== '[object Date]')
      {
        return false;
      }
      return !isNaN(date.getTime());
    }

    return DateUtils;
  }
  angular
    .module('sislabApp')
    .factory('DateUtilsService',
      [
        DateUtilsService
      ]
    );
  function RestUtilsService($resource, $location) {
    var RestUtils = {};
    RestUtils.saveData = saveData;
    RestUtils.updateData = updateData;

    function saveData(service, data, returnPath, itemIdName) {
      service
        .save(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          $location.path(returnPath);
          return response[itemIdName];
        }, function error(response) {
          if (response.status === 404)
          {
            return 'Recurso no encontrado';
          }
          else
          {
            return 'Error no especificado';
          }
        });
    }

    function updateData(service, data, returnPath, itemIdName) {
      service
        .update(JSON.stringify(data))
        .$promise
        .then(function success(response) {
          $location.path(returnPath + '/' + response[itemIdName]);
          return response[itemIdName];
        }, function error(response) {
          if (response.status === 404)
          {
            return 'Recurso no encontrado';
          }
          else
          {
            return 'Error no especificado';
          }
        });
    }

    return RestUtils;
  }
  angular
    .module('sislabApp')
    .factory('RestUtilsService',
      [
        '$resource', '$location',
        RestUtilsService
      ]
    );
  function FieldParameterService($resource, TokenService) {
    return $resource(API_BASE_URL + 'parameters/field', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('FieldParameterService',
      [
        '$resource', 'TokenService',
        FieldParameterService
      ]
    );
  function PreservationService($resource, TokenService) {
    return $resource(API_BASE_URL + 'preservations', {}, {
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('PreservationService',
      [
        '$resource', 'TokenService',
        PreservationService
      ]
    );
  function SheetService($resource, TokenService) {
    return $resource(API_BASE_URL + 'sheets/:sheetId', {}, {
      query: {
        method: 'GET',
        params: {sheetId: 'id_hoja'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      get: {
        method: 'GET',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      update: {
        method: 'POST',
        params: {sheetId: 'id_hoja'},
        isArray: false,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      },
      save: {
        method: 'POST',
        params: {},
        isArray: true,
        headers: {
          'Auth-Token': TokenService.getToken()
        }
      }
    });
  }
  angular
    .module('sislabApp')
    .factory('SheetService',
      [
        '$resource', 'TokenService',
        SheetService
      ]
    );

  function SheetController($routeParams, TokenService, ArrayUtilsService,
    DateUtilsService, RestUtilsService,
    FieldParameterService, PreservationService,
    SheetService) {
    var vm = this;
    vm.fieldParameters = FieldParameterService.get();
    vm.preservations = PreservationService.get();

    SheetService
      //.query({sheetId: $routeParams.sheetId})
      .query({sheetId: 1})
      .$promise
      .then(function success(response) {
        vm.sheet = response;
        vm.points = vm.sheet.puntos;
      });

    vm.temp1 = 0;
    vm.temp2 = 0;
    vm.temp3 = 0;
    vm.temp = 0;
    vm.tempAmb1 = 0;
    vm.tempAmb2 = 0;
    vm.tempAmb3 = 0;
    vm.tempAmb = 0;
    vm.ph1 = 0;
    vm.ph2 = 0;
    vm.ph3 = 0;
    vm.ph = 0;
    vm.cond1 = 0;
    vm.cond2 = 0;
    vm.cond3 = 0;
    vm.cond = 0;
    vm.od1 = 0;
    vm.od2 = 0;
    vm.od3 = 0;
    vm.od = 0;
    vm.cr1 = 0;
    vm.cr2 = 0;
    vm.cr3 = 0;
    vm.cr = 0;

    vm.tempAvg = tempAvg;
    vm.tempAmbAvg = tempAmbAvg;
    vm.phAvg = phAvg;
    vm.condAvg = condAvg;
    vm.odAvg = odAvg;
    vm.crAvg = crAvg;

    vm.selectPoint = selectPoint;

    vm.submitForm = submitForm;

    function tempAvg(){
      vm.temp = ArrayUtilsService.averageFromValues([
        vm.temp1,
        vm.temp2,
        vm.temp3
      ]);
      return vm.temp;
    }

    function tempAmbAvg(){
      vm.tempAmb = ArrayUtilsService.averageFromValues([
        vm.tempAmb1,
        vm.tempAmb2,
        vm.tempAmb3
      ]);
      return vm.tempAmb;
    }

    function phAvg() {
      vm.ph = ArrayUtilsService.averageFromValues([
        vm.ph1,
        vm.ph2,
        vm.ph3
      ]);
      return vm.ph;
    }

    function condAvg() {
      vm.cond = ArrayUtilsService.averageFromValues([
        vm.cond1,
        vm.cond2,
        vm.cond3
      ]);
      return vm.cond;
    }

    function odAvg() {
      vm.od = ArrayUtilsService.averageFromValues([
        vm.od1,
        vm.od2,
        vm.od3
      ]);
      return vm.od;
    }

    function crAvg() {
      vm.cr = ArrayUtilsService.averageFromValues([
        vm.cr1,
        vm.cr2,
        vm.cr3
      ]);
      return vm.cr;
    }

    function selectPoint() {
      console.log(vm.points);
      vm.punto = ArrayUtilsService.selectItemFromCollection(
        vm.points,
        'id_punto_muestreo',
        parseInt(vm.id_punto)
      );
    }

    function isFormValid() {

    }

    function submitForm() {

    }
  }
  angular
    .module('sislabApp')
    .controller('SheetController',
      [
        '$routeParams', 'TokenService', 'ArrayUtilsService',
        'DateUtilsService', 'RestUtilsService', 'FieldParameterService',
        'PreservationService', 'SheetService',
        SheetController
      ]
    );


})();