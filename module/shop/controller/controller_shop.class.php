<?php
    class controller_shop {
        function view() {
            echo ('Hola view');
            echo ( VIEW_PATH_HOME . 'shop.html');
            common::load_view('top_page_shop.html', VIEW_PATH_SHOP . 'shop.html'); //cargamos la vista del shop
        }
        
        function all_viviendas() {   
            // echo ('Hola all_viviendas');
            echo json_encode(common::load_model('shop_model', 'get_all_viviendas', [$_POST['offset'], $_POST['items_page']]));  //esta funcion get_carrusel se encuentra en el modelo home_model.class.singleton.php
        }              
        function filters_shop() {
            //echo json_encode(common::load_model('shop_model', 'get_filters_shop'));
            echo json_encode(common::load_model('shop_model', 'get_filters_shop', [$_POST['filters'], $_POST['offset'],$_POST['items_page']]));
        }
        
        function count_all_viviendas() {
            //echo ('Hola count_all_viviendas');
            echo json_encode(common::load_model('shop_model', 'get_count_all_viviendas'));
        }

        function filters_home() {
            echo json_encode(common::load_model('shop_model', 'get_filters_home', [$_POST['filters'], $_POST['offset'],$_POST['items_page']]));
        }
        
        function count_filters_home() {
            echo json_encode(common::load_model('shop_model', 'get_count_filters_home', $_POST['filters_home']));
        }

        
        function filters_search() {
            echo json_encode(common::load_model('shop_model', 'get_filters_search', [$_POST['filters'], $_POST['offset'],$_POST['items_page']]));
        }

        function count_filters_shop() {
             echo json_encode(common::load_model('shop_model', 'get_count_filters_shop', $_POST['filters_shop']));
            // echo json_encode(common::load_model('shop_model', 'get_count_filters_shop', $_POST['filters_shop'],$_POST['filters_search'],$_POST['filters_home']));
            // echo json_encode(common::load_model('shop_model', 'get_count_filters_shop', [$_POST['filters_shop'],$_POST['filters_search'],$_POST['filters_home']]));
            //echo json_encode(common::load_model('shop_model', 'get_count_filters_shop', [$_POST['filters_shop'], $_POST['filters_search'], $_POST['filters_home']]));
        }

        function count_filters_search() {
            echo json_encode(common::load_model('shop_model', 'get_count_filters_search', $_POST['filters_search']));
        }

        function details_viviendas() {
            echo json_encode(common::load_model('shop_model', 'get_details_viviendas'));

            // case 'details_vivienda':  //request al servidor

            //     try {
            //         $daoshop = new DAOShop();
            //         $Details_viviendas = $daoshop->select_one_vivienda($_GET['id']);
            //     } catch (Exception $e) {
            //         echo json_encode("error");
            //     }
        
            //     try {
            //         $daoshop_img = new DAOShop();
            //         $Date_images = $daoshop_img->select_img_viviendas($_GET['id']);
            //     } catch (Exception $e) {
            //         echo json_encode("error");
            //     }
        
            //     if (!empty($Details_viviendas || $Date_images)) { // si hay datos details e images
            //         $resultado = array();
            //         $resultado[0] = $Details_viviendas;
            //         $resultado[1][] = $Date_images;
            //         echo json_encode($resultado);
            //     } else {
        
            //         echo json_encode("error");
            //     }
            //     break;
        }

        function select_categories() {
            echo json_encode(common::load_model('shop_model', 'get_select_categories'));
        }

        function select_city() {
            echo json_encode(common::load_model('shop_model', 'get_select_city'));
        }


        function select_type() {
            echo json_encode(common::load_model('shop_model', 'get_select_type'));
        }

        function select_operation() {
            echo json_encode(common::load_model('shop_model', 'get_select_operation'));
        }

        function select_price() {
            echo json_encode(common::load_model('shop_model', 'get_select_price'));
        }

        function incrementa_visita() {
            echo json_encode(common::load_model('shop_model', 'get_incrementa_visita', $_GET['id']));
            echo json_encode("Visita incrementada con éxito");
        }

        function viviendas_related() {
            echo json_encode(common::load_model('shop_model', 'get_viviendas_related', [$_POST['id_city'],$_POST['offset'],$_POST['items_page']]));
        }

        function count_viviendas_related() {
            echo json_encode(common::load_model('shop_model', 'get_viviendas_related', [$_POST['id_city'],$_POST['offset'],$_POST['items_page']]));
        }

        function incrementa_like() {
           
            $token_dec = (middleware::decode_token($_POST['accestoken'])); //decodificamos el token
            //echo json_encode($token_dec ['username']); //devolvemos el token decodificado
            //echo json_encode($_POST['id_vivienda']);
            //exit();
   
           try {
               //$json = decode_token($_POST['accestoken']);
               //var_dump($_POST['id']);
               //var_dump($token_dec['username']);
               echo json_encode(common::load_model('shop_model', 'get_incrementa_like', $_POST['id_vivienda'], $token_dec['username']));

               //echo json_encode("Like incrementado con éxitoA");  
           } catch (Exception $e) {
               echo json_encode("Error incrementando el like: " . $e->getMessage());
               
           }
        }
    }
?>