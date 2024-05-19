function login() {
    if (validate_login() != 0) {
        var data = [];
        data.push({ name: 'username_log', value: document.getElementById('username_log').value });
        data.push({ name: 'passwd_log', value: document.getElementById('passwd_log').value });
        console.log('valor de data ');
        console.log(data)
        ajaxPromise('?module=login&op=login', 'POST', 'JSON', data) //data lleva el usuario y la contraseña
            .then(function (result) {//result es lo que devuelve el php
                var accestoken = result.accestoken; //accestoken es el token que devuelve el php EN UN ARRAY
                var refreshtoken = result.refreshtoken; //refreshtoken es el token que devuelve el php EN UN ARRAY


                if (result == "error_select_user") {
                    document.getElementById('error_username_log').innerHTML = "El usario no existe,asegurase de que lo a escrito correctamente"
                } else if (result == "error_password") {
                    document.getElementById('error_passwd_log').innerHTML = "La contraseña es incorrecta"
                } else {

                    localStorage.setItem("accestoken", accestoken);
                    localStorage.setItem("refreshtoken", refreshtoken);

                    toastr.success("Loged succesfully");
                    setTimeout(' window.location.href = "?module=shop&op=list"; ', 3000);

                }
            }).catch(function (textStatus) {
                if (console && console.log) {
                    console.log("La solicitud ha fallado en el login : " + textStatus);
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
        var data = [];
        data.push({ name: 'username_reg', value: document.getElementById('username_reg').value });
        data.push({ name: 'passwd1_reg', value: document.getElementById('passwd1_reg').value });
        data.push({ name: 'passwd2_reg', value: document.getElementById('passwd2_reg').value });
        data.push({ name: 'email_reg', value: document.getElementById('email_reg').value });


        //console.log(data);

        ajaxPromise('?module=login&op=register', 'POST', 'JSON', data)
            .then(function (result) {
                if (result == "error_email_reg") {
                    document.getElementById('error_email_reg').innerHTML = "El email ya esta en uso, asegurate de no tener ya una cuenta"
                } else if (result == "error_user_exist") {
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
                console.log(document.getElementById('passwd1_reg').value);
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

        //var data = $('#recover_email_form').serialize();
        var data = $('#email_forg').serialize();
        //alert(data);
        $.ajax({
            //url: friendlyURL('?module=login&op=recover_email'),
            url: '?module=login&op=recover_email',
            dataType: 'JSON',
            type: "POST",
            data: data,
        }).done(function (data) {
            console.log(data);
            alert(data);
            if (data == "error") {
                $("#error_email_forg").html("The email doesn't exist");
            } else {
                toastr.options.timeOut = 3000;
                toastr.success("Email sended");
                //setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 1000);
                setTimeout('window.location.href = "?module=login&op=view"', 1000);
            }
        }).fail(function (textStatus) {
            console.log('Error: Recover password error');
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
}
// function load_content() {
//     let path = window.location.pathname.split('/');

//     if (path[5] === 'recover') {
//         window.location.href = friendlyURL("?module=login&op=recover_view");
//         localStorage.setItem("token_email", path[6]);
//     } else if (path[5] === 'verify') {
//         ajaxPromise("?module=login&op=verify_email", 'POST', 'JSON', { token_email: path[6] })
//             .then(function (data) {
//                 toastr.options.timeOut = 3000;
//                 toastr.success('Email verified');
//                 setTimeout('window.location.href = "?module=home&op=view"', 1000);
//             })
//             .catch(function () {
//                 console.log('Error: verify email error');
//             });
//     } else if (path[4] === 'view') {
//         $(".login-wrap").show();
//         $(".forget_html").hide();
//     } else if (path[4] === 'recover_view') {
//         load_form_new_password();
//     }
// }

$(document).ready(function () {
    key_login();
    button_login();
    key_register();
    button_register();
    load_content();
    click_recover_password()
});