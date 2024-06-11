

function ajaxPromise(sUrl, sType, sTData, sData = undefined) {

    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData,


            beforeSend: function () {
                $("#overlay").fadeIn(300); // Muestra el loader EN EL MENU
            }
        }).done((data) => {
            console.log('data ok en el promise: ' + data);
            setTimeout(function () {
                $("#overlay").fadeOut(300); // Oculta el loader EN EL MENU
            }, 500);
            resolve(data);

        }).fail((data, jqXHR, textStatus, errorThrow) => {
            console.log('fail en ajaxpromise data ' + data);
            reject(errorThrow);
        });
    });
}

//================LOAD-HEADER================
function load_menu() {

    // document.getElementById('home-link').href = friendlyURL("?module=home&op=view");
    // document.getElementById('shop-link').href = friendlyURL("?module=shop&op=view");
    // document.getElementById('login-register').href = friendlyURL("?module=login&op=view");

    // //document.getElementById('btn_carrito').href = friendlyURL("?module=cart&op=view")
    // document.getElementById('btn_carrito').href = friendlyURL("?module=cart")








    var accestoken = localStorage.getItem('accestoken');
    if (accestoken) { //si hay un valor en token
        //console.log('accestoken en load menu: ' + accestoken);
        ajaxPromise(friendlyURL('?module=login&op=data_user'), 'POST', 'JSON', { 'accestoken': accestoken })

            .then(function (data) {
                console.log('valor de data en main js: ');
                console.log(data[0].username);
                if (data[0].type_user == "client") {
                    console.log("Cliente logeado");
                    $('#login-register').empty();

                } else {
                    console.log("Admin loged");
                }

                $('.log-icon').empty();
                $('#des_inf_user').empty();
                $('<img src=' + data[0].avatar + '>').appendTo('.log-icon');
                // $('<p></p>').attr({ 'id': data[0].username }).appendTo('#des_inf_user')
                //     .html('<a>' + data[0].username + '<a/>&nbsp;&nbsp;' +
                //         '<a id="logout"><i id="icon-logout" class="fa-solid fa-right-from-bracket"></i></a>'
                //     )
                // Primera parte: Crear y añadir el párrafo con el nombre de usuario
                $('<p></p>').attr({ 'id': data[0].username }).appendTo('#des_inf_user')
                    .html('<a>' + data[0].username + '</a>&nbsp;&nbsp;');

                // Segunda parte: Crear y añadir el enlace de cierre de sesión
                $('<a></a>').appendTo('#logout')
                    .html('<i id="logout" class="fa-solid fa-right-from-bracket"></i>');


            }).catch(function () {
                console.log("Error al cargar los datos del user");
                //console.log(data);
            });
    } else {
        $('#des_inf_user').hide();
        $('.log-icon').hide();
        $('<a href="?module=login&op=login"><i id="col-ico" class="fa-solid fa-user fa-2xl"></i></a>').appendTo('.log-icon'); //añadimos el icono de login

    }
}

$('#logout').on('click', function (e) {
    e.preventDefault();
    toastr.success("Logout exitoso");
    setTimeout(logout, 1000); //llama la funcion logout
});


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
    return "http://localhost/compracasaframework" + link;
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
    $('header').on('click', '#logout', function () {
        logout();
    });
    load_menu();
    //click_shop();

});