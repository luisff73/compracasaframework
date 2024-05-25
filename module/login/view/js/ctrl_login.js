function login() {
    if (validate_login() != 0) {  //si la validacion es distinta de 0, es decir, si no hay errores

        var username_log = document.getElementById('username_log').value;
        var passwd_log = document.getElementById('passwd_log').value;

        // console.log(data);
        //return;

        ajaxPromise('?module=login&op=login', 'POST', 'JSON', { 'username_log': username_log, 'passwd_log': passwd_log }) //data lleva el usuario y la contraseña

            .then(function (data) {//data es lo que devuelve el php
                console.log('Data: ', data);
                //return;
                var accestoken = data.accestoken; //accestoken es el token que devuelve el php EN UN ARRAY
                var refreshtoken = data.refreshtoken; //refreshtoken es el token que devuelve el php EN UN ARRAY


                if (data == "error_select_user") {
                    document.getElementById('error_username_log').innerHTML = "El usario no existe en la base de datos o no es activo"
                } else if (data == "error_password") {
                    document.getElementById('error_passwd_log').innerHTML = "La contraseña es incorrecta"
                } else {

                    localStorage.setItem("accestoken", accestoken);
                    localStorage.setItem("refreshtoken", refreshtoken);

                    toastr.success("Loged succesfully");
                    setTimeout(' window.location.href = "?module=shop&op=view"; ', 3000);

                }
            }).catch(function (textStatus, sData, errorThrown, jqXHR, data) {
                if (console && console.log) {
                    reject(errorThrow);
                }
            });
    }
}

function key_login() {
    $("#login").keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            login();
        }
    });
}
function button_login() {
    $('#login').on('click', function (e) {
        e.preventDefault();//evita que se recargue la pagina, en JavaScript se utiliza para prevenir la ejecución de la acción predeterminada del evento.
        login();
    });
}
function validate_login() {
    var error = false;

    if (document.getElementById('username_log').value.length === 0) {
        document.getElementById('error_username_log').innerHTML = "Por favor, introduce el usuario";
        error = true;
    } else {
        if (document.getElementById('username_log').value.length < 5) {
            document.getElementById('error_username_log').innerHTML = "El usuario tiene que tener 5 caracteres como minimo";
            error = true;
        } else {
            document.getElementById('error_username_log').innerHTML = "";
        }
    }

    if (document.getElementById('passwd_log').value.length === 0) {
        document.getElementById('error_passwd_log').innerHTML = "Por favor, introduce la contraseña";
        error = true;
    } else {
        document.getElementById('error_passwd_log').innerHTML = "";
    }

    if (error == true) {
        return 0;
    }
}
function register() {
    if (validate_register() != 0) {
        var username_reg = document.getElementById('username_reg').value;
        var passwd1_reg = document.getElementById('passwd1_reg').value;
        var passwd2_reg = document.getElementById('passwd2_reg').value;
        var email_reg = document.getElementById('email_reg').value;

        ajaxPromise('?module=login&op=register', 'POST', 'JSON', { 'username_reg': username_reg, 'passwd1_reg': passwd1_reg, 'passwd2_reg': passwd2_reg, 'email_reg': email_reg })
            .then(function (data) {
                console.log('Data: ', data);
                if (data == "error_email_reg") {
                    document.getElementById('error_email_reg').innerHTML = "El email ya esta en uso, asegurate de no tener ya una cuenta"
                } else if (data == "error_user_exist") {
                    document.getElementById('error_username_reg').innerHTML = "El usuario ya esta en uso, intentalo con otro"
                } else {
                    toastr.options = {
                        closeButton: true,
                        debug: false,
                        newestOnTop: false,
                        progressBar: true,
                        positionClass: "toast-center-center",
                        preventDuplicates: true,
                        showDuration: "4000",
                        hideDuration: "3000",
                        timeOut: "4000",
                        extendedTimeOut: "4000",
                    };

                    toastr.success("Registro satisfactorio, porfavor comprueba tu correo para activar la cuenta");
                    setTimeout(' window.location.href = "?module=login&op=login_register_view"; ', 4000);
                }
            }).catch(function (textStatus) {
                if (console && console.log) {
                    console.log("La solicitud ha fallado en el register: " + textStatus);
                }
            });
    }
}
function key_register() {
    $("#register").keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which); //comprobamos si se ha pulsado la tecla enter
        if (code == 13) {
            e.preventDefault(); //El método .preventDefault() es un método en JavaScript que se utiliza para prevenir la acción predeterminada del navegador en respuesta a un evento.
            register();
        }
    });
}
function button_register() {
    $('#register').on('click', function (e) {

        e.preventDefault();
        register();
    });
}
function validate_register() {
    var username_exp = /^(?=.{5,}$)(?=.*[a-zA-Z0-9]).*$/;
    var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    // COMENTO PARA PRUEBAS var pssswd_exp = /^(?=.{7,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
    var pssswd_exp = /^(?=.{6,}$)(?=.*[A-Z]).*$/;
    var error = false;

    if (document.getElementById('username_reg').value.length === 0) {
        document.getElementById('error_username_reg').innerHTML = "Tienes que escribir el usuario";
        error = true;
    } else {
        if (document.getElementById('username_reg').value.length < 5) {
            document.getElementById('error_username_reg').innerHTML = "El username tiene que tener 5 caracteres como minimo";
            error = true;
        } else {
            if (!username_exp.test(document.getElementById('username_reg').value)) {
                document.getElementById('error_username_reg').innerHTML = "No se pueden poner caracteres especiales";
                error = true;
            } else {
                document.getElementById('error_username_reg').innerHTML = "";
            }
        }
    }

    if (document.getElementById('email_reg').value.length === 0) {
        document.getElementById('error_email_reg').innerHTML = "Tienes que escribir un correo";
        error = true;
    } else {
        if (!mail_exp.test(document.getElementById('email_reg').value)) {
            document.getElementById('error_email_reg').innerHTML = "El formato del mail es invalido";
            error = true;
        } else {
            document.getElementById('error_email_reg').innerHTML = "";
        }
    }

    if (document.getElementById('passwd1_reg').value.length === 0) {
        document.getElementById('error_passwd1_reg').innerHTML = "Tienes que escribir la contraseña";
        error = true;
    } else {
        if (document.getElementById('passwd1_reg').value.length < 6) {
            document.getElementById('error_passwd1_reg').innerHTML = "La password tiene que tener 7 caracteres como minimo";
            error = true;
        } else {
            if (!pssswd_exp.test(document.getElementById('passwd1_reg').value)) {
                document.getElementById('error_passwd1_reg').innerHTML = "Debe de contener minimo 7 caracteres, mayusculas, minusculas y simbolos especiales";
                error = true;
            } else {
                document.getElementById('error_passwd1_reg').innerHTML = "";
            }
        }
    }

    if (document.getElementById('passwd2_reg').value.length === 0) {
        document.getElementById('error_passwd2_reg').innerHTML = "Tienes que repetir la contraseña";
        error = true;
    } else {
        if (document.getElementById('passwd2_reg').value.length < 7) {
            document.getElementById('error_passwd2_reg').innerHTML = "La password tiene que tener 7 caracteres como minimo";
            error = true;
        } else {
            if (document.getElementById('passwd2_reg').value === document.getElementById('passwd1_reg').value) {
                document.getElementById('error_passwd2_reg').innerHTML = "";
            } else {
                document.getElementById('error_passwd2_reg').innerHTML = "La password's no coinciden";
                error = true;
            }
        }
    }

    if (error == true) {
        return 0;
    }
}
function load_form_recover_password() {
    $(".login-wrap").hide();
    $(".forget_html").show();
    $('html, body').animate({ scrollTop: $(".forget_html") });
    click_recover_password();
}
function click_recover_password() {
    $(".forget_html").keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            send_recover_password();
        }
    });

    $('#button_recover').on('click', function (e) {

        e.preventDefault();
        send_recover_password();
    });
}
function validate_recover_password() {
    var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    var error = false;

    if (document.getElementById('email_forg').value.length === 0) {
        document.getElementById('error_email_forg').innerHTML = "Tienes que escribir un correo";
        error = true;
    } else {
        if (!mail_exp.test(document.getElementById('email_forg').value)) {
            document.getElementById('error_email_forg').innerHTML = "El formato del mail es invalido";
            error = true;
        } else {
            document.getElementById('error_email_forg').innerHTML = "";
        }
    }

    if (error == true) {
        return 0;
    }
}
function send_recover_password() {
    if (validate_recover_password() != 0) {

        var data = $('#email_forg').serialize();
        //var data = $('#form_recover_password').serialize();

        $.ajax({
            //url: friendlyURL('?module=login&op=recover_email'),
            url: '?module=login&op=recover_email',
            dataType: 'JSON',
            type: "POST",
            data: data,
        }).done(function (data) {

            if (data == "error") {
                $("#error_email_forg").html("The email doesn't exist");
            } else {
                console.log(data);
                toastr.options.timeOut = 3000;
                toastr.success("Email sended");
                //setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 1000);
                setTimeout('window.location.href = "?module=login&op=view"', 1000);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {

            console.log('Error: ' + textStatus);
            console.log('Error: ' + errorThrown);
            console.log('Response: ' + jqXHR.responseText);
            console.log('Error: Recover password error ' + textStatus);
        })
            .always(function () {
                // Esta función se ejecuta cuando la llamada AJAX se completa, independientemente del éxito o el fracaso.
                console.log('AJAX call completed');
            });

    }
}
function load_form_new_password() {
    token_email = localStorage.getItem('token_email');
    localStorage.removeItem('token_email');
    $.ajax({
        url: friendlyURL('?module=login&op=verify_token'),
        dataType: 'json',
        type: "POST",
        data: { token_email: token_email },
    }).done(function (data) {
        if (data == "verify") {
            click_new_password(token_email);
        } else {
            console.log("error");
        }
    }).fail(function (textStatus) {
        console.log("Error: Verify token error");
    });
}
function click_new_password(token_email) {
    $(".recover_html").keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            send_new_password(token_email);
        }
    });

    $('#button_set_pass').on('click', function (e) {
        e.preventDefault();
        send_new_password(token_email);
    });
}
function validate_new_password() {
    var error = false;

    if (document.getElementById('pass_rec').value.length === 0) {
        document.getElementById('error_password_rec').innerHTML = "You have to write a password";
        error = true;
    } else {
        if (document.getElementById('pass_rec').value.length < 8) {
            document.getElementById('error_password_rec').innerHTML = "The password must be longer than 8 characters";
            error = true;
        } else {
            document.getElementById('error_password_rec').innerHTML = "";
        }
    }

    if (document.getElementById('pass_rec_2').value != document.getElementById('pass_rec').value) {
        document.getElementById('error_password_rec_2').innerHTML = "Passwords don't match";
        error = true;
    } else {
        document.getElementById('error_password_rec_2').innerHTML = "";
    }

    if (error == true) {
        return 0;
    }
}
function send_new_password(token_email) {
    if (validate_new_password() != 0) {
        var data = { token_email: token_email, password: $('#pass_rec').val() };
        $.ajax({
            url: friendlyURL("?module=login&op=new_password"),
            type: "POST",
            dataType: "JSON",
            data: data,
        }).done(function (data) {
            if (data == "done") {
                toastr.options.timeOut = 3000;
                toastr.success('New password changed');
                setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 1000);
            } else {

                toastr.options.timeOut = 3000;
                toastr.error('Error seting new password');
            }
        }).fail(function (textStatus) {
            console.log("Error: New password error");

        });
    }
} // Path: module/login/view/js/ctrl_login.js


$(document).ready(function () {
    key_login();
    button_login();
    key_register();
    button_register();
    click_recover_password()
});