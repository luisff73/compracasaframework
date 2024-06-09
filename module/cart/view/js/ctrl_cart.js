

function click_compra() {
    $(document).on('click', '.button_cesta', function () {
        console.log("click");
        var id_vivienda = $(this).attr('id');

        localStorage.setItem('id_vivienda_cart', id_vivienda);

        let totalCarrito = parseInt(localStorage.getItem('totalcarrito')) || 0;
        totalCarrito += 1;
        localStorage.setItem('totalcarrito', totalCarrito);
        actualizarContadorCarrito()


        if (localStorage.getItem('accestoken') == null) {
            toastr["info"]("Debes estar logeado para comprar una vivienda", "Control de acceso")

            setTimeout(function () {
                window.location.href = friendlyURL("?module=login&op=view");
            }, 3000);
        }
        let username = localStorage.getItem('username');
        console.log(id_vivienda);
        console.log(username);
        //ajaxPromise(friendlyURL('?module=cart&op=agrega_carrito'), 'POST', 'JSON', { 'id_vivienda': id_vivienda, 'accestoken': accestoken }) //enviamos el id_vivienda y el accesstoken para decodificar el usuario
        ajaxPromise('?module=cart&op=agrega_carrito', 'POST', 'JSON', { 'id_vivienda': id_vivienda, 'username': username }) //provisional

            .then(function (data) {
                //console.log(data);
                console.log('Vivienda agregada correctamente al carrito');
            })
            .catch(function () {
                console.log('Error al agregar la vivienda');
            });
    });


}

function lista_carrito() {
    $(document).on('click', '#btn_carrito', function () {
        let username = localStorage.getItem('username');
        let total_carrito = 0


        ajaxPromise(friendlyURL("?module=cart&op=lista_carrito"), 'POST', 'JSON', { 'username': username })
            .then(function (data) {
                $('#carrito').empty();
                for (row in data) {
                    total_carrito += parseInt(data[row].quantity); // suma el total de las viviendas
                    let fila1 = $('<tr class="carrito-row"></tr>').appendTo("#carrito");
                    $('<td class="carrito-img" rowspan="4"><img src="http://localhost/compracasaframework/' + data[row].image_name + '" alt="Imagen de la vivienda"></td>').appendTo(fila1);
                    $('<td class="carrito-name" colspan="2"></td>').text("Descripción: " + data[row].vivienda_name).appendTo(fila1);

                    let fila2 = $('<tr class="carrito-row" id_vivienda="' + data[row].id_vivienda + '"></tr>').appendTo("#carrito");
                    $('<td class="carrito-quantity"></td>').text("Cantidad: " + data[row].quantity).appendTo(fila2);
                    $('<td class="carrito-stock"></td>').text("Stock: " + data[row].stock).appendTo(fila2);

                    let fila3 = $('<tr class="carrito-row"></tr>').appendTo("#carrito");
                    $('<td class="carrito-price" colspan="2"></td>').text("Precio : " + data[row].vivienda_price + " €").appendTo(fila3);

                    let fila4 = $('<tr class="carrito-row"></tr>').appendTo("#carrito");
                    $('<td class="carrito-estado"></td>').text(data[row].status).appendTo(fila4);
                    $('<td class="carrito-actions"></td>')
                        .append('<button class="increment-button" onclick="incrementar(\'' + data[row].id_vivienda + '\')">+</button>')
                        .append('<button class="decrement-button" onclick="decrementar(\'' + data[row].id_vivienda + '\')">-</button>')
                        .append('<button class="delete-button" onclick="borra_compra(\'' + data[row].id_vivienda + '\', \'' + data[row].username + '\')">Borrar</button>')
                        .appendTo(fila4);
                }
                localStorage.setItem('totalcarrito', total_carrito);
                actualizarContadorCarrito()
            })
            .catch(function () {

                console.log('Error en la carga del carrito');
            });
    });
}

function incrementar(id_vivienda) {
    // Encuentra la fila de la tabla con el id_vivienda correspondiente
    var fila = document.querySelector('tr[id_vivienda="' + id_vivienda + '"]');
    var cantidad = fila.querySelector('.carrito-quantity');
    var stock = fila.querySelector('.carrito-stock');
    var valorActual = parseInt(cantidad.innerText.split(": ")[1]);
    var valorStock = parseInt(stock.innerText.split(": ")[1]);
    // Incrementa la cantidad pero no la deja subir de 3 ni que sea mayor que el stock
    if (valorActual <= (valorStock - 1)) {
        cantidad.innerText = "Cantidad: " + Math.min(3, valorActual + 1);
    }
}

function decrementar(id_vivienda) {
    // Encuentra la fila de la tabla con el id_vivienda correspondiente
    var fila = document.querySelector('tr[id_vivienda="' + id_vivienda + '"]');
    var cantidad = fila.querySelector('.carrito-quantity');
    var valorActual = parseInt(cantidad.innerText.split(": ")[1]);
    cantidad.innerText = "Cantidad: " + Math.max(1, valorActual - 1);
}

function borra_compra(id_vivienda, username) {

    let totalCarrito = parseInt(localStorage.getItem('totalcarrito')) || 0;
    totalCarrito -= 1;
    localStorage.setItem('totalcarrito', totalCarrito);
    actualizarContadorCarrito()

    ajaxPromise(friendlyURL('?module=cart&op=borra_vivienda'), 'POST', 'JSON', { 'id_vivienda': id_vivienda, 'username': username })

        .then(function (data) {
            toastr.options.timeOut = 3000;
            toastr.success("Vivienda borrada correctamente");
            setTimeout(location.reload, 3900);
            setTimeout('window.location.href = friendlyURL("?module=cart&op=view"); ', 4000);


            //location.reload();
        })
        .catch(function (data) {
            console.log(data)
            console.log('Error al agregar la vivienda');
        });

}
function cierra_carrito() {
    let username = localStorage.getItem('username');
    let filasCarrito = $('.carrito-row'); // Obtiene todas las filas del carrito

    filasCarrito.each(function () {
        let idVivienda = $(this).attr('id_vivienda'); // Obtiene el id de la vivienda
        let cantidad = $(this).find('.carrito-quantity').text().substring(10); // Obtiene la cantidad sin el literal

        if (idVivienda !== undefined) {
            ajaxPromise(friendlyURL("?module=cart&op=cierra_carrito"), 'POST', 'JSON', { 'username': username, 'id_vivienda': idVivienda, 'cantidad': cantidad })
                .then(function (data) {
                    console.log(data);
                    console.log('Datos enviados con éxito');
                    setTimeout(function () {
                        toastr["info"]("Compra finalizada correctamente", "Información");
                        window.location.href = friendlyURL("?module=home&op=view");
                    }, 1000);
                })
                .catch(function (error) {
                    console.log(error);
                    console.log('Error al enviar los datos');
                    setTimeout(function () {
                        toastr["errp"]("No ha sido posible finalizar la compra", "Información");
                        window.location.href = friendlyURL("?module=home&op=view");
                    }, 1000);
                });
        }
    });

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

function actualizarContadorCarrito() {
    $('#item-count').text(localStorage.getItem('totalcarrito'));
}

$(document).ready(function () {

    $('#cierra_carrito').click(function () {
        cierra_carrito();
    });

    lista_carrito();
    click_compra();
    actualizarContadorCarrito()


});

