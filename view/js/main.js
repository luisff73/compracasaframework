
//htaccess 


function ajaxPromise(sUrl, sType, sTData, sData = undefined) {

    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData,


            // beforeSend: function () {
            //     $("#overlay").fadeIn(300); // Muestra el loader EN EL MENU
            // }
        }).done((data) => {
            console.log('data ok en el promise: ' + data);
            // setTimeout(function () {
            //     $("#overlay").fadeOut(300); // Oculta el loader EN EL MENU
            // }, 500);
            resolve(data);

        }).fail((data, jqXHR, textStatus, errorThrow) => {
            console.log('fail en ajaxpromise data ' + data);
            reject(errorThrow);
        });
    });
}

//================LOAD-HEADER================
function load_menu() {

    document.getElementById('home-link').href = friendlyURL("?module=home&op=view");
    document.getElementById('shop-link').href = friendlyURL("?module=shop&op=view");
    document.getElementById('login-register').href = friendlyURL("?module=login&op=view");


    var accestoken = localStorage.getItem('accestoken');
    if (accestoken) { //si hay un valor en token
        //console.log('accestoken en load menu: ' + accestoken);
        //ajaxPromise(friendlyURL('?module=login&op=data_user', 'POST', 'JSON', { 'accestoken': accestoken }))
        ajaxPromise('?module=login&op=data_user', 'POST', 'JSON', { 'accestoken': accestoken })

            .then(function (data) {
                //console.log('valor de data en main js: ');
                //console.log(data);
                if (data.type_user == "client") {
                    console.log("Cliente logeado");
                    $('#login-register').empty();
                    // $('.opc_CRUD').empty();
                    // $('.opc_exceptions').empty();
                } else {
                    console.log("Admin loged");
                    // $('.opc_CRUD').show();
                    // $('.opc_exceptions').show();
                }

                $('.log-icon').empty();
                $('#user_info').empty();
                $('login-register').empty();
                $('<img src="' + data.avatar + '"alt="Robot">').appendTo('.log-icon');
                $('<p></p>').attr({ 'id': 'username' }).appendTo('#des_inf_user')
                    .html('<a>' + data.username + '<a/>&nbsp;&nbsp;' +
                        '<a id="logout"><i id="icon-logout" class="fa-solid fa-right-from-bracket"></i></a>'
                    )

            }).catch(function () {
                //console.log('valor de data en el main error js: ' + data);
                console.log("Error al cargar los datos del user");
                console.log(data);
            });
    } else {
        //console.log("No hay token disponible");
        $('.opc_CRUD').empty();
        $('.opc_exceptions').empty();
        $('#user_info').hide();
        $('.log-icon').empty();
        $('<a href="?module=login&op=login"><i id="col-ico" class="fa-solid fa-user fa-2xl"></i></a>').appendTo('.log-icon'); //añadimos el icono de login

    }
}


//================CLICK-LOGUT================
function click_logout() {

    $(document).on('click', '#logout', function () {

        toastr.success("Logout succesfully");

        setTimeout('logout(); ', 1000);
    });
}

//================LOG-OUT================
function logout() {
    ajaxPromise(friendlyURL('?module=login&op=logout', 'POST', 'JSON'))
        .then(function (data) {
            //localStorage.removeItem('token');
            localStorage.removeItem('accestoken');   /// usamos siempre el accestoken
            localStorage.removeItem('refreshtoken');
            localStorage.removeItem('total_prod');
            console.log('Logout succesfully');
            window.location.href = friendlyURL("?module=home&op=list");
        }).catch(function () {
            console.log('No se ha podido cerrar la sesión');
        });
}

// Remove localstorage('page') with click in shop
function click_shop() {
    $(document).on('click', '#opc_shop', function () {
        localStorage.removeItem('page');
        localStorage.removeItem('total_prod');
    });
}

/* FRIENDLY URL */
function friendlyURL(url) {
    var link = "";
    url = url.replace("?", "");
    url = url.split("&");
    cont = 0;
    for (var i = 0; i < url.length; i++) {
        cont++;
        var aux = url[i].split("=");
        if (cont == 2) {
            link += "/" + aux[1] + "/";
        } else {
            link += "/" + aux[1];
        }
    }
    //alert("http://localhost/compracasaframework" + link);
    return "http://localhost/compracasaframework" + link;
}

function load_content() {

    let path = window.location.pathname.split('/'); //split para separar la url por el caracter "/" y lo asignamos al array path
    //console.log(path);

    if (path[3] === 'recover_email') {
        //console.log('recover_email');
        // window.location.href = friendlyURL("?module=login&op=recover_view");
        window.location.href = "?module=login&op=recover_view";
        localStorage.setItem('token_email', path[4]);

    } else if (path[3] === 'verify_email') {
        var token_email = path[4];
        console.log('token_email en verify_email: ' + token_email);

        //ajaxPromise(friendlyURL("?module=login&op=verify_email", 'POST', 'JSON', { 'token_email': $token_email }))
        ajaxPromise('?module=login&op=verify_email', 'POST', 'JSON', { 'token_email': token_email })

            .then(function (data) {//data es lo que devuelve el php
                console.log('Data: ', data);
                return;

                console.log('data en verify_email: ' + data);

                toastr.options.timeOut = 3000;
                toastr.success('Email verified');
                setTimeout('window.location.href = friendlyURL("?module=login&op=view")', 1000);
            })
            .catch(function (data, jqXHR, textStatus, errorThrow, url, sUrl, type, dataType) {
                console.log('data en verify_email error: ' + data);

                // console.log('data en verify_email error: ' + data);
                console.log("Error en el promise, Valor de Url: ", url);
                // console.log("VALOR DE sType: ", type);
                // console.log("VALOR DE sTdata: ", dataType);
                // console.log("VALOR DE sData: ", data);
                // console.log("Importante Respuesta del servidor en el promise responsetext : ", jqXHR.responseText);
                // console.log("Código de estado HTTP: ", jqXHR.status);
                // console.log("Descripción del estado HTTP: ", jqXHR.statusText);
                // console.log("Cuerpo de la respuesta como JSON: ", jqXHR.responseJSON);
                console.log("Tipo de error: ", textStatus);

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
    load_menu();
    click_logout();
    click_shop();
    load_content();
});