
function click_compra() {
    $(document).on('click', '.button_cesta', function () {
        var id_vivienda = $(this).attr('id');

        localStorage.setItem('id_vivienda_cart', id_vivienda);


        if (localStorage.getItem('accestoken') == null) {
            toastr["info"]("Debes estar logeado para comprar una vivienda", "Control de acceso")

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "100",
                "hideDuration": "500",
                "timeOut": "3000",
                "extendedTimeOut": "2000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            setTimeout(function () {
                window.location.href = friendlyURL("?module=login&op=view");
            }, 3000);

            return;
        }
        let accestoken = localStorage.getItem('accestoken');  //obtenemos el token de acceso del localstorage
        let username = localStorage.getItem('username'); // de momento obtenemos el username de localstorage mas adelante hay que recogerlo del acesstoken
        console.log(id_vivienda);
        console.log(username);
        //ajaxPromise(friendlyURL('?module=cart&op=agrega_carrito'), 'POST', 'JSON', { 'id_vivienda': id_vivienda, 'accestoken': accestoken }) //enviamos el id_vivienda y el accesstoken para decodificar el usuario
        ajaxPromise('?module=cart&op=agrega_carrito', 'POST', 'JSON', { 'id_vivienda': id_vivienda, 'username': username }) //provisional

            .then(function (data) {
                console.log(data);
                console.log('Vivienda agregada correctamente al carrito');
                // $("#boton_like").load(location.href + " #boton_like>*", "");
            })
            .catch(function (data) {
                console.log(data)
                console.log('Error al agregar la vivienda');
            });
    });


}

function lista_carrito() {
    $(document).on('click', '#btn_carrito', function () {
        let username = localStorage.getItem('username');

        ajaxPromise(friendlyURL("?module=cart&op=lista_carrito"), 'POST', 'JSON', { 'username': username })
            .then(function (data) {
                for (row in data) {
                    let columna1 = $('<tr class="carrito-row"></tr>').appendTo("#carrito");
                    $('<td class="carrito-img" rowspan="4"><img src="http://localhost/compracasaframework/' + data[row].image_name + '" alt="Imagen de la vivienda"></td>').appendTo(columna1);
                    $('<td class="carrito-name"></td>').text("Descripción: " + data[row].vivienda_name).appendTo(columna1);

                    let columna2 = $('<tr class="carrito-row"></tr>').appendTo("#carrito");
                    $('<td class="carrito-quantity"></td>').text("Cantidad: " + data[row].quantity).appendTo(columna2);

                    let columna3 = $('<tr class="carrito-row"></tr>').appendTo("#carrito"); 2
                    $('<td class="carrito-price"></td>').text("Precio : " + data[row].vivienda_price + " €").appendTo(columna3);

                    let columna4 = $('<tr class="carrito-row"></tr>').appendTo("#carrito");
                    $('<td class="carrito-actions"><button class="increment-button" onclick="incrementar(\'' + data[row].id_vivienda + '\')">+</button><button class="decrement-button" onclick="decrementar(\'' + data[row].id_vivienda + '\')">-</button></td>').appendTo(columna4);
                }       // $('<td></td>').text(data[row].username).appendTo(tr);
                // $('<td></td>').text(data[row].id_vivienda).appendTo(tr);

            })
            .catch(function () {
                console.log('Error en la carga del carrito');
            });
    });
}


$(document).ready(function () {
    lista_carrito();
    click_compra();

});

