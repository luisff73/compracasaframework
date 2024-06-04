

// function click_compra() {
//     $(document).on('click', '.button_cesta', function () {
//         var id_vivienda = $(this).attr('id');

//         localStorage.setItem('id_vivienda_cart', id_vivienda);

//         let totalfacturas = parseInt(localStorage.getItem('totalfacturas')) || 0;
//         totalfacturas += 1;
//         localStorage.setItem('totalfacturas', totalfacturas);
//         actualizarContadorfacturas()


//         if (localStorage.getItem('accestoken') == null) {
//             toastr["info"]("Debes estar logeado para comprar una vivienda", "Control de acceso")

//             setTimeout(function () {
//                 window.location.href = friendlyURL("?module=login&op=view");
//             }, 3000);
//         }
//         let username = localStorage.getItem('username');
//         console.log(id_vivienda);
//         console.log(username);
//         //ajaxPromise(friendlyURL('?module=cart&op=agrega_facturas'), 'POST', 'JSON', { 'id_vivienda': id_vivienda, 'accestoken': accestoken }) //enviamos el id_vivienda y el accesstoken para decodificar el usuario
//         ajaxPromise('?module=cart&op=agrega_facturas', 'POST', 'JSON', { 'id_vivienda': id_vivienda, 'username': username }) //provisional

//             .then(function (data) {
//                 //console.log(data);
//                 console.log('Vivienda agregada correctamente al facturas');
//             })
//             .catch(function () {
//                 console.log('Error al agregar la vivienda');
//             });
//     });


// }

function lista_factura() {
    $(document).on('click', '#des_inf_user', function () {
        let username = localStorage.getItem('username');
        //let total_facturas = 0



        ajaxPromise(friendlyURL("?module=profile&op=listafacturas"), 'POST', 'JSON', { 'username': username })
            .then(function (data) {
                $('#facturas').empty();
                for (row in data) {
                    //total_facturas += parseInt(data[row].quantity); // suma el total de las viviendas
                    let fila1 = $('<tr class="facturas-row"></tr>').appendTo("#facturas");
                    $('<td class="facturas-img" rowspan="4"><img src="http://localhost/compracasaframework/' + data[row].image_name + '" alt="Imagen de la vivienda"></td>').appendTo(fila1);
                    $('<td class="facturas-name" colspan="2"></td>').text("Descripción: " + data[row].vivienda_name).appendTo(fila1);

                    let fila2 = $('<tr class="facturas-row" id_vivienda="' + data[row].id_vivienda + '"></tr>').appendTo("#facturas");
                    $('<td class="facturas-quantity" colspan="2"</td>').text("Cantidad comprada: " + data[row].quantity).appendTo(fila2);

                    let fila3 = $('<tr class="facturas-row"></tr>').appendTo("#facturas");
                    $('<td class="facturas-price" colspan="2"></td>').text("Total operación : " + data[row].vivienda_price + " €").appendTo(fila3);

                    let fila4 = $('<tr class="facturas-row"></tr>').appendTo("#facturas");
                    //$('<td class="facturas-estado"></td>').text(data[row].status).appendTo(fila4);
                    $('<td class="facturas-estado"></td>').text("Compra finalizada").appendTo(fila4);
                    $('<td class="facturas-actions"></td>')
                        .append('<button class="increment-button" onclick="factura_pdf(\'' + data[row].id_vivienda + '\')">Imprime Factura</button>')
                        .append('<button class="decrement-button" onclick="factura_qr(\'' + data[row].id_vivienda + '\')">Genera QR</button>')
                        // .append('<button class="delete-button" onclick="borra_compra(\'' + data[row].id_vivienda + '\', \'' + data[row].username + '\')">Borrar</button>')
                        .appendTo(fila4);
                }
                //localStorage.setItem('totalfacturas', total_facturas);
                //actualizarContadorfacturas()
            })
            .catch(function () {

                console.log('Error en la carga de las facturas');
            });
    });
}

function factura_pdf(id_vivienda) {
    // Encuentra la fila de la tabla con el id_vivienda correspondiente
    var fila = document.querySelector('tr[id_vivienda="' + id_vivienda + '"]');
    var cantidad = fila.querySelector('.facturas-quantity');
    var stock = fila.querySelector('.facturas-stock');
    var valorActual = parseInt(cantidad.innerText.split(": ")[1]);
    var valorStock = parseInt(stock.innerText.split(": ")[1]);
    // Incrementa la cantidad pero no la deja subir de 3 ni que sea mayor que el stock
    if (valorActual <= (valorStock - 1)) {
        cantidad.innerText = "Cantidad: " + Math.min(3, valorActual + 1);
    }
}

function factura_qr(id_vivienda) {
    // Encuentra la fila de la tabla con el id_vivienda correspondiente
    var fila = document.querySelector('tr[id_vivienda="' + id_vivienda + '"]');
    var cantidad = fila.querySelector('.facturas-quantity');
    var valorActual = parseInt(cantidad.innerText.split(": ")[1]);
    cantidad.innerText = "Cantidad: " + Math.max(1, valorActual - 1);
}


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


$(document).ready(function () {

    lista_factura();
});

