
var elements = document.getElementsByTagName('INPUT');

var ventanaCalendario=false

function muestraCalendario(raiz,formulario_destino,campo_destino,mes_destino,ano_destino){
    if (typeof ventanaCalendario.document == "object") {
        ventanaCalendario.close()
    }
    ventanaCalendario = window.open("calendario/index.php?formulario=" + formulario_destino + "&nomcampo=" + campo_destino,"calendario","width=300,height=300,left=100,top=100,scrollbars=no,menubars=no,statusbar=NO,status=NO,resizable=YES,location=NO")
}

for (i = 0; i < elements.length; i++) {
    elements[i].oninvalid = function (e) {
        if (!e.target.validity.valid) {
            switch (e.target.id) {
                case 'username':
                    e.target.setCustomValidity('Ingrese un nombre de usuario.');
                    break;
                case 'password':
                    e.target.setCustomValidity('Ingrese una contraseña');
                    break;
                case 'email':
                    e.target.setCustomValidity('Ingrese un email valido.');
                    break;
                case 'nombre':
                    e.target.setCustomValidity('Ingrese su nombre.');
                    break;
                case 'apellido':
                    e.target.setCustomValidity('Ingrese su apellido.');
                    break;
                case 'cedula':
                    e.target.setCustomValidity('Ingrese su cédula.');
                    break;
                case 'cod_carne':
                    e.target.setCustomValidity('Ingrese el código de su carné.');
                    break;
                case 'anio':
                    e.target.setCustomValidity('Debe ingresar un año.');
                    break;
                case 'telefono_celu':
                    e.target.setCustomValidity('Debe ingresar su teléfono celular.');
                    break;
                case 'telefono_habi':
                    e.target.setCustomValidity('Debe ingresar su teléfono de habitación.');
                    break;
                default:
                    e.target.setCustomValidity('');
                    break;
            }
        }
        if (e.target.validity.patternMismatch) {
            switch (e.target.id) {
                case 'username':
                    e.target.setCustomValidity('Debe tener de 6 a 20 caracteres.');
                    break;
                case 'password':
                    e.target.setCustomValidity('Debe tener 6 caracteres mínimos.');
                    break;
                case 'cod_carne':
                    e.target.setCustomValidity('El código de carné tiene 11 digitos.');
                    break;
                case 'anio':
                    e.target.setCustomValidity('Debe ingresar un año entre el 2000 y el 2999.');
                    break;
                default:
                    e.target.setCustomValidity('');
                    break;
            }
        }
    };

    elements[i].oninput = function (e) {
        if (e.target.validity.patternMismatch) {
            switch (e.target.id) {
                case 'username':
                    e.target.setCustomValidity('Debe tener de 6 a 20 caracteres.');
                    break;
                case 'password':
                    e.target.setCustomValidity('Debe tener 6 caracteres mínimos.');
                    break;
                case 'cod_carne':
                    e.target.setCustomValidity('El código de carné tiene 11 digitos.');
                    break;
                case 'anio':
                    e.target.setCustomValidity('Debe ingresar un año entre el 2000 y el 2999.');
                    break;
                default:
                    e.target.setCustomValidity('');
                    break;
            }
        } else {
            e.target.setCustomValidity('');
        }
    };
}


/**********AJAX*************/

$(document).ready(function () {
    var jVal = {
        'username' : function () {
            $('body').append('<div id="userInfo" class="info"></div>');
            var userInfo = $('#userInfo');
            var ele = $('#username');
            var pos = ele.offset();
            userInfo.css({
                top: pos.top - 3,
                left: pos.left + ele.width() + 15
            });
            if (ele.val().length < 6) {
                userInfo.removeClass('ajax');
            } else {
                var dataString = 'username=' + $('#username').val();
                $.ajax({
                    type: "POST",
                    url: "existe_usuario.php",
                    data: dataString,
                    success: function (data) {
                        userInfo.removeClass('error').addClass('ajax').html(data).show();
                    }
                });
            }
        },
        'email' : function () {
            $('body').append('<div id="emailInfo" class="info"></div>');
            var emailInfo = $('#emailInfo');
            var ele = $('#email');
            var pos = ele.offset();
            emailInfo.css({
                top: pos.top - 3,
                left: pos.left + ele.width() + 15
            });
            var patt = /^.+@.+[.].{2,}$/i;

            if (!patt.test(ele.val())) {
                emailInfo.removeClass('ajax');
            } else {
                var email = ele;
                var dataString = 'email=' + $('#email').val();
                $.ajax({
                    type: "POST",
                    url: "existe_email.php",
                    data: dataString,
                    success: function (data) {
                        emailInfo.removeClass('error').addClass('ajax').html(data).show();

                    }
                });
            }
        }
    };

    $('#username').change(jVal.username);
    $('#email').change(jVal.email);
});
