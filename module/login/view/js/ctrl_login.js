function login() {
    if (validate_login() != 0) {  //si la validacion es distinta de 0, es decir, si no hay errores

        var username_log = document.getElementById('username_log').value;
        var passwd_log = document.getElementById('passwd_log').value;

        ajaxPromise("?module=login&op=login", 'POST', 'JSON', { 'username_log': username_log, 'passwd_log': passwd_log }) //data lleva el usuario y la contraseña

            .then(function (data) {//data es lo que devuelve el php
                // console.log('Data: ', data);
                // return;
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
                    //setTimeout(' window.location.href = friendlyURL("?module=shop&op=view"); ', 3000);

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

    $('#login').on('click', function (e) {
        e.preventDefault();//evita que se recargue la pagina, en JavaScript se utiliza para prevenir la ejecución de la acción predeterminada del evento.
        login();
    });

    $('#google').on('click', function (e) {
        social_login('google');
    });

    $('#github').on('click', function (e) {
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
                    setTimeout(' window.location.href = friendlyURL("?module=login&op=login_register_view"); ', 4000);
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
                console.log('Data recover: ', data.message);
                return;
                if (data == "error") {
                    $("#error_email_forg").html("The email doesn't exist");
                } else {
                    console.log(data);
                    toastr.options.timeOut = 3000;
                    toastr.success("Email sended");
                    setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 1000);
                }
            }).catch(function (error) {

                console.log('Error: ' + error.message);
                // console.log('Error: ' + errorThrown);
                // console.log('url: ' + url);
                // console.log('Response: ' + jqXHR.responseText);
                // console.log('Error: Recover password error ' + textStatus);
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
} // Path: module/login/view/js/ctrl_login.js


function social_login(param) {  // aqui recibe el tipo de red social GOOGLE o GITHUB
    authService = firebase_config();
    authService.signInWithPopup(provider_config(param))
        .then(function (result) {
            alert('login  satisfactorio')
            console.log('Hemos autenticado al usuario ', result.user);
            email_name = result.user.email;
            let username = email_name.split('@');
            console.log(username[0]);

            //social_user = { id: result.user.uid, username: username[0], email: result.user.email, avatar: result.user.photoURL };
            console.log(result.user.uid) //jvrluis
            console.log(username[0]); //jvrluis
            console.log(result.user.mail); //undefined
            console.log(result.user.photoURL); //ok
            console.log(email_name.split('@')); // jvrluis  /  gmail.com
            console.log(result.accestoken); //undefined
            console.log(result.avatar); //undefined

            social_user = { id: result.user.uid, username: username[0], email: result.user.email, avatar: result.user.photoURL };
            if (result) {
                ajaxPromise(friendlyURL("?module=login&op=social_login"), 'POST', 'JSON', social_user)
                    .then(function (data) {
                        localStorage.setItem("token", data);
                        toastr.options.timeOut = 3000;
                        toastr.success("Inicio de sesión realizado");
                        if (localStorage.getItem('likes') == null) {
                            setTimeout('window.location.href = friendlyURL("?module=home&op=view")', 1000);
                        } else {
                            setTimeout('window.location.href = friendlyURL("?module=shop&op=view")', 1000);
                        }
                    })
                    .catch(function () {
                        console.log('Error: Social login error');
                    });
            }
        })
        .catch(function (error) {
            var errorCode = error.code;
            console.log(errorCode);
            var errorMessage = error.message;
            console.log(errorMessage);
            var email = error.email;
            console.log(email);
            var credential = error.credential;
            console.log(credential);
        });
}

function firebase_config() {
    var config = {
        apiKey: "AIzaSyDzaMB7Om42JuxeZ6PqIOYhp3iuww5QlVE",
        authDomain: "compracasaframework.firebaseapp.com",
        databaseURL: "https://compracasaframework.firebaseio.com",
        projectId: "compracasaframework",
        storageBucket: "compracasaframework.appspot.com",
        messagingSenderId: "525136586549",
        // appId: "1:495514694215:web:b183cd7f513ce8b0d6f762",
        // measurementId: "G-JXEGLTGLTC"
    };
    if (!firebase.apps.length) {
        firebase.initializeApp(config);
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
        var token_email = path[4];
        console.log('token_email en verify_email: ' + token_email);

        //ajaxPromise(friendlyURL("?module=login&op=verify_email", 'POST', 'JSON', { 'token_email': $token_email }))
        //ajaxPromise("?module=login&op=verify_email", 'POST', 'JSON', { 'token_email': token_email })
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "?module=login&op=verify_email",
            data: { 'token_email': token_email },
        })

            .done(function (response) {//data es lo que devuelve el php
                //.then(function (data) {//data es lo que devuelve el php
                console.log('Data: ', response);
                return;

                console.log('data en verify_email: ' + data);

                toastr.options.timeOut = 3000;
                toastr.success('Email verified');
                setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 1000);
            })
            .fail(function (response, jqXHR, textStatus, errorThrow, url, type, dataType) {
                console.log('data en verify_email error: ' + response);
                console.log(JSON.stringify(response));
                console.log("Error en el promise, Valor de Url: ", url);
                console.log("VALOR DE sType: ", type);
                console.log("VALOR DE sTdata: ", dataType);
                console.log("VALOR DE sData: ", data);
                console.log("Importante Respuesta del servidor en el promise responsetext : ", jqXHR.responseText);
                console.log("Código de estado HTTP: ", jqXHR.status);
                console.log("Descripción del estado HTTP: ", jqXHR.statusText);
                console.log("Cuerpo de la respuesta como JSON: ", jqXHR.responseJSON);
                console.log("Tipo de error: ", textStatus, errorThrown);

                toastr.options.timeOut = 3000;
                toastr.error('Email no verificado');
            });

    } else if (path[4] === 'view') {
        $(".login-wrap").show();
        $(".forget_html").hide();
    } else if (path[3] === 'recover_view') {
        load_form_new_password();
    }
}


$(document).ready(function () {
    load_content();
    key_login();
    key_register();
    button_register();
    click_recover_password()

});