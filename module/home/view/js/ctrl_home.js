
function carousel_operation() {
    //ajaxPromise(friendlyURL("?module=home&op=carousel"), 'GET', 'JSON') //llamamos al ctr_home_ y ejecuta el DAO que nos devolverá la promesa
    ajaxPromise("?module=home&op=carousel", 'GET', 'JSON') //llamamos al ctr_home_ y ejecuta el DAO que nos devolverá la promesa

        .then(function (data) {
            //console.log(data);
            for (row in data) {
                $('<div></div>').attr('class', "carousel__elements").attr('id', data[row].id_operation).appendTo(".carousel_operaciones")
                    .html(
                        "<img class='carousel__img' id='' src='http://localhost/compracasaframework/" + data[row].image_name + "' alt='' >" +
                        "<h5>" + data[row].operation_name + "</h5>"
                    )

            }

            new Glider(document.querySelector('.carousel_operaciones'), {
                slidesToShow: 6,
                slidesToScroll: 1,
                draggable: true,
                dots: '.dots',
                arrows: {
                    prev: '.carousel__prev',
                    next: '.carousel__next',
                }
            });



        })
        .catch(function () {
            console.log('Error en la carga del carrusel de operaciones');
            //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Carrousel_Brand HOME";
        });
}
function loadCategories() {
    ajaxPromise(friendlyURL("?module=home&op=category"), 'GET', 'JSON') //llamamos al ctr_home_ y ejecuta el DAO que nos devolverá la promesa
        //ajaxPromise("?module=home&op=category", 'GET', 'JSON') //llamamos al ctr_home_ y ejecuta el DAO que nos devolverá la promesa
        .then(function (data) {
            for (row in data) {

                $('<div></div>').attr('class', "div_cate").attr({ 'id': data[row].id_category }).appendTo('#containercategories')
                    .html(
                        "<li class='portfolio-item'>" +
                        "<div class='item-main'>" +
                        "<div class='portfolio-image'>" +
                        "<img src = " + data[row].image_name + " alt='foto' </img> " +
                        "</div>" +
                        "<h5>" + data[row].category_name + "</h5>" +
                        "</div>" +
                        "</li>"
                    )

            }
        }).catch(function () {
            console.log('Error en la carga de las categorias');
            //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        });
}
function loadcatcity() {
    ajaxPromise(friendlyURL("?module=home&op=city"), 'GET', 'JSON')
        //ajaxPromise("?module=home&op=city", 'GET', 'JSON')
        .then(function (data) {
            //console.log(data);
            for (row in data) {
                $('<div></div>').attr('class', "div_city").attr({ 'id': data[row].id_city }).appendTo('#containercity')
                    .html(
                        "<li class='portfolio-item'>" +
                        "<div class='item-main2'>" +
                        "<div class='portfolio-image'>" +
                        "<img src = " + data[row].image_name + " alt='foto' </img> " +
                        "</div>" +
                        "<h5>" + data[row].city_name + "</h5>" +
                        "</div>" +
                        "</li>"
                    )
            }
        }).catch(function () {
            //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Types_car HOME";
        });
}
function loadCatTypes() {
    ajaxPromise(friendlyURL("?module=home&op=type"), 'GET', 'JSON')
        //ajaxPromise("?module=home&op=type", 'GET', 'JSON')
        .then(function (data) {
            for (row in data) {
                $('<div></div>').attr('class', "div_type").attr({ 'id': data[row].id_type }).appendTo('#containertype')
                    .html(
                        "<li class='portfolio-item'>" +
                        "<div class='item-main3'>" +
                        "<div class='portfolio-image'>" +
                        "<img src = " + data[row].image_name + " alt='foto' </img> " +
                        "</div>" +
                        //"<h5>" + data[row].type_name + "</h5>" +
                        "</div>" +
                        "</li>"
                    )

            }
        }).catch(function () {
            //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Types_car HOME";
        });
}
function loadoperation() {
    ajaxPromise(friendlyURL("?module=home&op=operation"), 'GET', 'JSON')
        //ajaxPromise("?module=home&op=operation", 'GET', 'JSON')
        .then(function (data) {
            for (row in data) {
                $('<div></div>').attr('class', "div_operation").attr({ 'id': data[row].id_operation }).appendTo('#containeroperation')
                    .html(
                        "<li class='portfolio-item'>" +
                        "<div class='item-main'>" +
                        "<div class='portfolio-image'>" +
                        "<img src = " + data[row].image_name + " alt='foto' </img> " +
                        "</div>" +
                        "<h5>" + data[row].operation_name + "</h5>" +
                        "</div>" +
                        "</li>"
                    )
            }
        }).catch(function () {
            //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        });
}
function mas_visitadas() {
    ajaxPromise(friendlyURL("?module=home&op=mas_visitadas"), 'GET', 'JSON')
        //ajaxPromise("?module=home&op=mas_visitadas", 'GET', 'JSON')
        .then(function (data) {
            for (row in data) {
                $('<div></div>').attr('class', "div_busquedas").attr({ 'id': data[row].id_vivienda }).appendTo('#containermasvisitadas')
                    .html(
                        "<li class='portfolio-item'>" +
                        "<div class='item-main'>" +
                        "<div class='portfolio-image'>" +
                        "<img src = " + data[row].image_name + " alt='foto' </img> " +
                        "</div>" +
                        "<h5>" + data[row].city_name + "</h5>" +
                        "<p>Precio: " + data[row].vivienda_price + " Visitas: " + data[row].visitas + "</p>" +
                        "</div>" +
                        "</li>"
                    )
            }
        }).catch(function () {
            //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        });
}
function ultimas_busquedas() {

    var filters_shop = localStorage.getItem('filters_shop');


    ajaxPromise(friendlyURL("?module=home&op=ultimas_busquedas"), 'GET', 'JSON', { filters_shop })
        //ajaxPromise("?module=home&op=ultimas_busquedas", 'GET', 'JSON', { filters_shop })
        .then(function (data) {
            for (row in data) {
                $('<div></div>').attr('class', "div_busquedas").attr({ 'id': data[row].id_vivienda }).appendTo('#containerbusquedas')
                    .html(
                        "<li class='portfolio-item'>" +
                        "<div class='item-main'>" +
                        "<div class='portfolio-image'>" +
                        "<img src = " + data[row].image_name + " alt='foto' </img> " +
                        "</div>" +
                        "<h5>" + data[row].state + "</h5>" +
                        "<p>Precio: " + data[row].vivienda_price + "</p>" +
                        "</div>" +
                        "</li>"
                    )
            }
        }).catch(function () {
            //window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Type_Categories HOME";
        });
}
function clicks() { //función que se encarga de redirigir a la página de shop con los filtros seleccionados


    $(document).on("click", 'div.carousel__elements', function () { //recoge el click en el carrousel con el div.carousel__elements
        remove_filters_home();
        localStorage.setItem('filter_operation', this.getAttribute('id'));
        var filters_home = [];
        filters_home.push(["id_operation", this.getAttribute('id')]);//añade el id del elemento seleccionado al array de filtros
        //localStorage.setItem('filters_home', JSON.stringify(filters_home))
        localStorage.setItem('filters_shop', JSON.stringify(filters_home));
        setTimeout(function () {
            //window.location.href = 'index.php?page=ctrl_shop&op=view'; //redirige a la página de shop con la opcion de ver los productos filtrados.
            window.location.href = '?module=shop&op=view'; //redirige a la página de shop con la opcion de ver los productos filtrados.
        }, 200);
    });

    $(document).on("click", 'div.div_cate', function () {  //recoge el click en el div.div_cate
        remove_filters_home();
        localStorage.setItem('filter_category', this.getAttribute('id'));
        var filters_home = [];
        filters_home.push(["id_category", this.getAttribute('id')]);
        //localStorage.setItem('filters_home', JSON.stringify(filters_home));
        localStorage.setItem('filters_shop', JSON.stringify(filters_home));
        setTimeout(function () {
            window.location.href = '?module=shop&op=view'; //redirige a la página de shop con la opcion de ver los productos filtrados.
        }, 200);
    });

    $(document).on("click", 'div.div_city', function () { //recoge el click en el div.div_city
        remove_filters_home();
        localStorage.setItem('filter_city', this.getAttribute('id'));
        var filters_home = [];
        filters_home.push(["id_city", this.getAttribute('id')]);
        //localStorage.setItem('filters_home', JSON.stringify(filters_home));
        localStorage.setItem('filters_shop', JSON.stringify(filters_home));
        setTimeout(function () {
            window.location.href = '?module=shop&op=view'; //redirige a la página de shop con la opcion de ver los productos filtrados.
        }, 200);
    });

    $(document).on("click", 'div.div_type', function () { //recoge el click en el div.div_type
        remove_filters_home();
        localStorage.setItem('filter_type', this.getAttribute('id'));
        var filters_home = [];
        filters_home.push(["id_type", this.getAttribute('id')]);
        //localStorage.setItem('filters_home', JSON.stringify(filters_home));
        localStorage.setItem('filters_shop', JSON.stringify(filters_home));
        setTimeout(function () {
            window.location.href = '?module=shop&op=view'; //redirige a la página de shop con la opcion de ver los productos filtrados.
        }, 200);
    });

    $(document).on('click', '#regreso_home', function () {
        remove_filters_home();
    });
}
function remove_filters_home() {
    localStorage.removeItem('filters_home');
    localStorage.removeItem('filters_shop');
    localStorage.removeItem('filters_search');
    localStorage.removeItem('filter_category');
    localStorage.removeItem('filter_operation');
    localStorage.removeItem('filter_type');
    localStorage.removeItem('filter_city');
    localStorage.removeItem('filter_price');
    localStorage.removeItem('filter_order');
    localStorage.removeItem('page');
}

$(document).ready(function () {
    carousel_operation();
    loadCategories();
    loadcatcity();
    loadCatTypes();
    loadoperation();
    //ultimas_busquedas();
    mas_visitadas();
    clicks();
});                