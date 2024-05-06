
function ajaxPromise(sUrl, sType, sTData, sData = undefined) {

    return new Promise((resolve, reject) => {
        //console.log("VALOR DE sUrl: ", sUrl);
        //console.log("VALOR DE sType: ", sType);
        //console.log("VALOR DE sTdata: ", sTData);
        //console.log("VALOR DE sData: ", sData); //NO ESTA PASANDO ESTE CAMPO UNDEFINED  
        //alert('Has ENTRADO al ajaxprimomise');

        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData

        }).done((data) => {
            //alert('Has salido del done en el resolve');
            //console.log("Respuesta del servidor en el promise: ", data)
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            console.log("Error en el promise, Valor de sUrl: ", sUrl);
            console.log("VALOR DE sType: ", sType);
            console.log("VALOR DE sTdata: ", sTData);
            console.log("VALOR DE sData: ", sData);
            console.log("Respuesta del servidor en el promise responsetext : ", jqXHR.responseText);
            console.log("Respuesta del servidor en el promise log : ", jqXHR.log);
            //console.log('fail'.textStatus);
            reject(errorThrow);
        });
    });



};


