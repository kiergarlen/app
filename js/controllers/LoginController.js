//LoginController
function LoginController(Loginservice) {
  this.message = '';
  this.user = {
    username: '',
    password: ''
  };

  this.submit = function(form) {
    this.message += ' USR ' + form.username.$modelValue;
    this.message += ' PSW ' + form.password.$modelValue;
  };

  this.login = function() {
    this.message = '...';
    if (this.loginForm.$valid)
    {
      if (this.user.username == 'rgarcia' &&
        this.user.password == '123'
      )
      {
        this.message = 'Enviando credenciales secretas...';
        this.submit(this.loginForm);
      }
      else
      {
        this.message = 'Usuario o contraseña incorrectos';
      }
    }
    else
    {
      this.message = 'Debe ingresar usuario y/o contraseña';
    }
  };
}

angular
  .module('siclabApp')
  .controller('LoginController',
  ['LoginService',
  LoginController
]);