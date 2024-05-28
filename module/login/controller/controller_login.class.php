<?php
              
include_once("C:/xampp/htdocs/compracasaframework/model/middleware_auth.inc.php");

    class controller_login {

        function view() {
            common::load_view('top_page_login.html', VIEW_PATH_LOGIN . 'login-register.html');
        }
        function recover_view() {
            common::load_view('top_page_login.html', VIEW_PATH_LOGIN . 'recover_pass.html');
        }
        function login_register_view() {
            common::load_view('top_page_login.html', VIEW_PATH_LOGIN . 'login-register.html');

        }    
        function register() {
            echo json_encode(common::load_model('login_model', 'register', [$_POST['username_reg'], $_POST['passwd1_reg'], $_POST['passwd2_reg'],$_POST['email_reg']]));
        }
        function login() {
            echo json_encode(common::load_model('login_model', 'login', [$_POST['username_log'], $_POST['passwd_log']]));
        }                        
        function verify_emailsss() {
         echo json_encode(common::load_model('login_model', 'verify_email', $_POST['token_email']));        
        }

        function verify_email() {
            echo json_encode ("hola token");
            // if (isset($_POST['token_email'])) {
            //     echo json_encode ("hola token");
            //     // Procesa el token_email aquí (por ejemplo, verifica si es válido).
            //     // Luego, devuelve una respuesta JSON apropiada.
            //     //$response = ['message' => 'Token de email válido'];
            //     //cho json_encode($response);
            // } else {
            //     echo json_encode ("no hola token");
            //    ///$response = ['error' => 'Token de email no proporcionado'];
            //    // echo json_encode($response);
            // }
        }

        function logout() {
            unset($_SESSION['username']); //unset destruye la variable, con lo que borramos el usuario
            unset($_SESSION['tiempo']); //unset destruye la variable, con lo que borramos el tiempo
            session_destroy(); //session_destroy destruye la sesion
            echo json_encode('Done');
        } 
        function data_user() {
            echo json_encode(common::load_model('login_model', 'data_user', $_POST['accestoken']));
        }
        function actividad() {
            echo json_encode(common::load_model('login_model', 'activity'));
        }
        function controluser() {
            echo json_encode(common::load_model('login_model', 'controluser', $_POST['accestoken']));
        }

        function refresh_cookie() {
            session_regenerate_id();
            echo json_encode("Done");
        } 
        ///////////////////////////////////////////////////////////

        function social_login() {
            // echo json_encode ('hola'); // funciona
            echo json_encode(common::load_model('login_model', 'social_login', [$_POST['id'], $_POST['username'], $_POST['email'], $_POST['avatar'], $_POST['tipo_login']]));
        } 


        function recover_email() {
            echo json_encode(common::load_model('login_model', 'recover_email', $_POST['email_forg']));
        }

        function verify_token() {
            echo json_encode(common::load_model('login_model', 'verify_token', $_POST['token_email']));
        }

        function new_password() {
            echo json_encode(common::load_model('login_model', 'new_password', [$_POST['token_email'], $_POST['password']]));
        }  

        function refresh_token() {
            echo json_encode(common::load_model('login_model', 'refresh_token', $_POST['token']));
        } 
        
        function token_expires() {
            echo json_encode(common::load_model('login_model', 'token_expires', $_POST['token']));
        }


    
    }
    
?>