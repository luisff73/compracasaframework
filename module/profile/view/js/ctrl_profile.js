


function lista_profile() {
    $(document).on('click', '#des_inf_user', function () {
        let username = localStorage.getItem('username');
        //let total_facturas = 0


        ajaxPromise(friendlyURL("?module=profile&op=lista_facturas"), 'POST', 'JSON', { 'username': username })
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

                    let fila4 = $('<tr class="facturas-row" contador="' + data[row].contador + '"></tr>').appendTo("#facturas");
                    //$('<td class="facturas-estado"></td>').text(data[row].status).appendTo(fila4);
                    //$('<td class="facturas-estado"rowspan="2"></td>').text("Compra finalizada").appendTo(fila4);
                    $('<td class="facturas-numero"></td>').text("Factura Numero : " + data[row].contador).appendTo(fila4);

                    $('<td class="facturas-actions"></td>')
                        .append('<button class="pdf_button" onclick="factura_pdf(\'' + data[row].contador + '\')">Imprime Factura</button>')
                        .append('<button class="qr_button" onclick="factura_qr(\'' + data[row].contador + '\')">Genera QR</button>')
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
function aafactura_pdf(contador) {
    var factura = document.querySelector('tr[contador="' + contador + '"]')?.getAttribute('contador');
    console.log(factura);
    fetch('C:/xampp/htdocs/compracasaframework/utils/generar_pdf_copy.php', {
        //fetch('utils/generar_pdf_copy.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=generate_pdf&factura=${factura}`
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Algo ha ido mal.');
            }
            return response.blob();
        })
        .then(blob => {
            const newBlob = new Blob([blob], { type: 'application/pdf' });
            const url = window.URL.createObjectURL(newBlob);
            //const a = document.createElement('a');
            //a.style.display = 'none';
            //a.href = url;
            //a.download = 'facturas.pdf';
            //document.body.appendChild(a);
            //a.click();
            //window.URL.revokeObjectURL(url);
            window.open(url, '_blank');

        })
        .catch(error => console.error('There was a problem with the fetch operation:', error));
}

function factura_pdf(contador) {
    var factura = document.querySelector('tr[contador="' + contador + '"]')?.getAttribute('contador');
    console.log(factura);

    fetch('http://localhost/compracasaframework/utils/generar_pdf.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=generate_pdf&factura=${factura}`
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Algo ha ido mal.');
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            window.open(url, '_blank');
        })
        .catch(error => console.error('There was a problem with the fetch operation:', error));
}



function factura_qr(id_vivienda) {
    // Encuentra la fila de la tabla con la factura correspondiente
    var factura = document.querySelector('tr[contador="' + contador + '"]')?.getAttribute('contador');
    console.log(factura);

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




