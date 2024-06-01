

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

    document.getElementById('home-link').href = friendlyURL("?module=home&op=view");
    document.getElementById('shop-link').href = friendlyURL("?module=shop&op=view");
    document.getElementById('login-register').href = friendlyURL("?module=login&op=view");
    document.getElementById('btn_carrito').href = friendlyURL("?module=cart&op=view")


    var accestoken = localStorage.getItem('accestoken');
    if (accestoken) { //si hay un valor en token
        //console.log('accestoken en load menu: ' + accestoken);
        ajaxPromise(friendlyURL('?module=login&op=data_user'), 'POST', 'JSON', { 'accestoken': accestoken })

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
                //$('login-register').empty();
                $('<img src="' + data.avatar + '"alt="Robot">').appendTo('.log-icon');
                $('<p></p>').attr({ 'id': 'username' }).appendTo('#des_inf_user')
                    .html('<a>' + data.username + '<a/>&nbsp;&nbsp;' +
                        '<a id="logout"><i id="icon-logout" class="fa-solid fa-right-from-bracket"></i></a>'
                    )

            }).catch(function () {
                //console.log('valor de data en el main error js: ' + data);
                console.log("Error al cargar los datos del user");
                //console.log(data);
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




$(document).ready(function () {
    load_menu();
    click_shop();

});