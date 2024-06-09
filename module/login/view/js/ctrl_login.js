function login() {
    if (validate_login() != 0) {  //si la validacion es distinta de 0, es decir, si no hay errores

        var username_log = document.getElementById('username_log').value;
        var passwd_log = document.getElementById('passwd_log').value;
        localStorage.setItem('username', document.getElementById('username_log').value)

        ajaxPromise("?module=login&op=login", 'POST', 'JSON', { 'username_log': username_log, 'passwd_log': passwd_log }) //data lleva el usuario y la contraseña

            .then(function (data) {//data es lo que devuelve el php
                console.log('Data: ', data);
                //return;
                var accestoken = data.accestoken; //accestoken es el token que devuelve el php EN UN ARRAY
                var refreshtoken = data.refreshtoken; //refreshtoken es el token que devuelve el php EN UN ARRAY

                if (data == "Usuario_inexistente") {
                    document.getElementById('error_username_log').innerHTML = "El usario no existe en la base de datos o no esta activo"
                } else if (data.Password_incorrecta == "Password_incorrecta") {
                    document.getElementById('error_passwd_log').innerHTML = "La contraseña es incorrecta, dispone de " + data.attempts + " intentos para hacer login";

                    if (data.attempts == 1) {

                        var OTP = [];
                        OTP.push({ name: 'otp', value: '5682' });


                        alert('demasiados intentos')
                        $.ajax({
                            url: 'utils/ultrmsg.inc.php',
                            type: 'POST',
                            dataType: "JSON",
                            data: OTP, // codigo otp

                        })
                            .done(function (response) {
                                console.log(response);
                            })
                            .fail(function (response) {
                                console.log(response);
                            })
                    }
                } else {

                    localStorage.setItem("accestoken", accestoken);
                    localStorage.setItem("refreshtoken", refreshtoken);

                    toastr.success("Login completado con exito");
                    //document.getElementById('btn_carrito').style.display = 'flex';

                    $('.log-icon').empty();
                    $('#des_inf_user').empty();
                    $('<img src="' + data.avatar + '">').appendTo('.log-icon');
                    // $('<p></p>').attr('id', data.username).appendTo('#des_inf_user')
                    $('#des_inf_user').text(data.username);

                    setTimeout(' window.location.href = friendlyURL("?module=shop&op=view"); ', 3000);

                }
            }).catch(function (error, textStatus, sData, errorThrown, jqXHR, data) {
                if (console && console.log) {
                    // console.log(error);

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

    $("#register").keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which); //comprobamos si se ha pulsado la tecla enter
        if (code == 13) {
            e.preventDefault(); //El método .preventDefault() es un método en JavaScript que se utiliza para prevenir la acción predeterminada del navegador en respuesta a un evento.
            register();
        }
    });

    $('#register').on('click', function (e) {
        e.preventDefault();
        register();
    });

    $('#login').on('click', function (e) {
        e.preventDefault();//evita que se recargue la pagina, en JavaScript se utiliza para prevenir la ejecución de la acción predeterminada del evento.
        login();
    });

    $('#icon-logout').on('click', function (e) {
        e.preventDefault();
        toastr.success("Logout exitoso");
        setTimeout(logout, 1000); //llama la funcion logout
    });

    $('#google').on('click', function (e) {
        e.preventDefault();
        social_login('google');
    });

    $('#github').on('click', function (e) {
        e.preventDefault();
        social_login('github');
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

        ajaxPromise("?module=login&op=register", 'POST', 'JSON', { 'username_reg': username_reg, 'passwd1_reg': passwd1_reg, 'passwd2_reg': passwd2_reg, 'email_reg': email_reg })
            .then(function (data) {
                console.log('Data promise correcta: ', data);
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
                    setTimeout(' window.location.href = friendlyURL("?module=login&op=view"); ', 4000);
                }
            }).catch(function (textStatus) {
                if (console && console.log) {
                    console.log("La solicitud ha fallado en el register: " + textStatus);
                }
            });
    }
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
    if (validate_recover_password() != 0) { // Si el resultado es distinto de 0

        //var mail = $('#email_forg').serialize();
        var mail = document.getElementById('email_forg').value;

        console.log('email recover: ', mail);

        ajaxPromise("?module=login&op=recover_email", 'POST', 'JSON', { 'email_forg': mail }) //data lleva el usuario y la contraseña

            // $.ajax({
            //     //url: friendlyURL("?module=login&op=recover_email"),
            //     url: "?module=login&op=recover_email",
            //     dataType: 'JSON',
            //     type: "POST",
            //     data: mail,
            // }).done(function (data) {

            .then(function (data) {
                console.log(data);
                console.log('Data recover: ', data.message);
                //return;
                if (data == "error") {
                    $("#error_email_forg").html("The email doesn't exist");
                } else {
                    console.log(data);
                    toastr.options.timeOut = 3000;
                    toastr.success("Email sended");
                    setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 1000);
                }
            }).catch(function (error, textStatus, jqXHR, data) {
                console.log(data);
                console.log('Error: ' + error.message);
                // console.log('Error: ' + errorThrown);
                // console.log('url: ' + url);
                console.log('Response: ' + jqXHR.responseText);
                console.log('Error: Recover password error ' + textStatus);
            });
    }
    else {
        console.log('Error: Recover password error');
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
function social_login(param) {  // aqui recibe el tipo de red social GOOGLE o GITHUB
    authService = firebase_config();
    authService.signInWithPopup(provider_config(param))
        .then(function (result) {

            email_name = result.user.email;
            let username = email_name.split('@');
            // console.log(username[0]); //jvrluis
            // console.log(result.user.uid) //ujKODRPDJaLVdaxS6Lkrph2
            // console.log(username[0]); //jvrluis
            // console.log(username[1]); //gmail.com
            // console.log(result.user.email); //jvrluis@gmail.com
            // console.log(result.user.photoURL); //ok
            // console.log(email_name.split('@')); // jvrluis  /  gmail.com

            if (result) {
                ajaxPromise(friendlyURL("?module=login&op=social_login"), 'POST', 'JSON', { 'id': result.user.uid, 'username': username[0], 'email': result.user.email, 'avatar': result.user.photoURL, 'tipo_login': username[1] })

                    .then(function (data) {

                        data = JSON.parse(data);
                        //console.log(data);
                        localStorage.setItem("accestoken", data.accestoken);
                        localStorage.setItem("refreshtoken", data.refreshtoken);
                        localStorage.setItem("username", data.username)
                        toastr.options.timeOut = 3000;
                        toastr.success("Inicio de sesión realizado");
                        $('.log-icon').empty();
                        $('#des_inf_user').empty();
                        $('<img src="' + data.avatar + '">').appendTo('.log-icon');
                        $('<p></p>').attr('id', data.username).appendTo('#des_inf_user')

                        setTimeout('window.location.href = friendlyURL("?module=shop&op=view")', 6000);

                    })
                    .catch(function (data) {
                        // console.log(data);
                        console.log('Error: Social login error');
                    });
            }
        })
        .catch(function (error) {
            // console.log(error);
            // var errorCode = error.code;
            // console.log(errorCode);
            // var errorMessage = error.message;
            // console.log(errorMessage);
            // var email = error.email;
            // console.log(email);
            // var credential = error.credential;
            // console.log(credential);
        });
}
function firebase_config() {

    if (!firebase.apps.length) {
        firebase.initializeApp(config); // config es una variable global que tenemos en credentials.js
    } else {
        firebase.app();
    }
    return authService = firebase.auth();
}
function provider_config(param) {
    if (param === 'google') {
        var provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('email');
        return provider;
    } else if (param === 'github') {
        return provider = new firebase.auth.GithubAuthProvider();
    }
}
function load_content() {

    let path = window.location.pathname.split('/'); //split para separar la url por el caracter "/" y lo asignamos al array path
    //console.log(path);

    if (path[3] === 'recover_email') {
        //console.log('recover_email');
        window.location.href = friendlyURL("?module=login&op=recover_view");
        //window.location.href = "?module=login&op=recover_view";
        localStorage.setItem('token_email', path[4]);

    } else if (path[3] === 'verify_email') {
        alert(path[4]);
        var token_email = path[4];
        console.log('token_email en verify_email: ' + token_email);

        //ajaxPromise(friendlyURL("?module=login&op=verify_email", 'POST', 'JSON', { 'token_email': token_email }))
        //ajaxPromise("?module=login&op=verify_email", 'POST', 'JSON', { token_email: path[4] })
        ajaxPromise('index.php?module=login&op=verify_email', 'POST', 'JSON', { 'token_email': path[4] })

            .then(function (data) {//data es lo que devuelve el php
                console.log('data en verify_email: ' + data);
                // return;
                toastr.options.timeOut = 3000;
                toastr.success('Email verificado');
                //setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 4000);
            })
            .catch(function (data, jqXHR, textStatus, errorThrow, url, type, dataType) {
                console.log('ERROR data en verify_email: ' + data);
                // //console.log('jqXHR.responseText: ' + jqXHR.responseText);
                // console.log('textStatus: ' + textStatus);
                // console.log('errorThrow: ' + errorThrow);
                // console.log('url: ' + url);
                // console.log('type: ' + type);
                // console.log('dataType: ' + dataType);
                toastr.options.timeOut = 3000;
                toastr.error('Email no verificado');
            });

    } else if (path[3] === 'view') {
        $(".login-wrap").show();
        $(".forget_html").hide();
    } else if (path[3] === 'recover_view') {
        load_form_new_password();
    }
}
function logout() {
    ajaxPromise(friendlyURL("?module=login&op=logout", 'POST', 'JSON'))
        .then(function (data) {
            localStorage.removeItem('username');
            localStorage.removeItem('totalcarrito');
            localStorage.removeItem('id_vivienda_cart');
            localStorage.removeItem('accestoken');
            localStorage.removeItem('refreshtoken');
            toastr.success("Logout Exitoso");
            window.location.href = friendlyURL("?module=home&op=view");
        }).catch(function () {
            console.log('No se ha podido cerrar la sesión');
        });
}

$(document).ready(function () {
    load_content();
    key_login();
    click_recover_password();
});