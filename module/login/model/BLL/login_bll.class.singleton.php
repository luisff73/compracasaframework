<?php
require ('module/login/model/DAO/login_dao.class.singleton.php');
	
		class login_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = login_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

	
public function get_register_BLL($username, $password, $email) {
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $hashavatar = md5(strtolower(trim($email))); 
    $avatar = "https://robohash.org/$hashavatar";
    $token_email = common::generate_Token_secure(20);
    $id = common::generate_Token_secure(6);

    try {
        $check = $this -> dao -> select_email($this->db, $email);
    } catch (Exception $e) {
        echo json_encode("error");
        exit;
    }

    if ($check) {
        echo json_encode("error_email");
        exit;
    } else {
        try {
            $rdo = $this -> dao -> insert_user($this -> db, $username, $email, $hashed_pass, $avatar, $token_email);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error_user");
            exit;
        } else {
            $message = [ 'type' => 'validate', 
                            'token' => $token_email, 
                            'toEmail' =>  $email];
            $email = json_decode(mail::send_email($message), true);
            if (!empty($email)) {
                return;  
            } else {
                echo json_encode("ok");
                exit;
            }
        }
    }
}


		public function get_login_BLL($args) {
			// if (!empty($this -> dao -> select_user($this->db, $args[0], $args[0]))) {
			// 	$user = $this -> dao -> select_user($this->db, $args[0], $args[0]);
			// 	if (password_verify($args[1], $user[0]['password']) && $user[0]['activate'] == 1) {
			// 		$jwt = jwt_process::encode($user[0]['username']);
			// 		$_SESSION['username'] = $user[0]['username'];
			// 		$_SESSION['tiempo'] = time();
            //         session_regenerate_id();
			// 		return json_encode($jwt);
			// 	} else if (password_verify($args[1], $user[0]['password']) && $user[0]['activate'] == 0) {
			// 		return 'activate error';
			// 	} else {
			// 		return 'error';
			// 	}
            // } else {
			// 	return 'user error';
			// }

			try {
				$rdo = $this->dao->select_user($_POST['username_log'],$_POST['passwd_log']);                                               
				if ($rdo == "error_select_user") {
					echo json_encode("error_select_user"); //devuelve error_select_user para que lo recoga la funcion login
					exit;
				} else {
					if (password_verify($_POST['passwd_log'], $rdo['password'])) { //comprueba que la contraseña sea correcta
					   $accestoken = middleware::create_accestoken($rdo["username"]); //crea el token de la funcion accestoken del middleware_auth.php
					   $refreshtoken = middleware::create_refreshtoken($rdo["username"]); //crea el token create_refreshtoken del middleware_auth.php este token se usa para refrescar el accestoken  
						
						$_SESSION['username'] = $rdo['username']; //Guardamos el usuario en la sesion
						$_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
	
					
						$response = array(
							'accestoken' => $accestoken,
							'refreshtoken' => $refreshtoken
						);
						
						echo json_encode($response);
						
						
						exit;
					} else {
						echo json_encode("error_password");                 
						exit;
					}
				}
			} catch (Exception $e) {
				echo json_encode("error");
				exit;  
			}


		}

		public function get_data_user_BLL($args) {
			// $token = explode('"', $args);
			// $decode = middleware::decode_username($token[1]);
			// return $this -> dao -> select_data_user($this->db, $decode);
			$json = middleware::decode_token($_POST['accestoken']);
			//echo json_encode ($json);
			//exit;
			//$daoLog = new DAOLogin();
			//echo json_encode ($json['username']);
			//exit;
			$rdo = $this->dao->select_data_user($this -> db,$json['username']);
	
			echo json_encode($rdo);
			exit;
		
		
		
		
		}
		public function get_activity_BLL() {
			if (!isset($_SESSION["tiempo"])) { //si no existe la variable tiempo 
				echo json_encode("inactivo"); //devuelve inactivo
				exit();
			} else {
				if ((time() - $_SESSION["tiempo"]) >= 1800) { //1800s=30min CON ESTO SE DELIMITA EL TIEMPO DE LA SESION DEL USUARIO
					//ES EL TIEMPO DE AHORA MENOS EL TIEMPO DEL CREACION DEL TOKEN
					echo json_encode("inactivo");
					exit();
				} else {
					echo json_encode("activo");
					exit();
				}
			}
		}
		public function get_controluser_BLL($args) {
			// $token = explode('"', $args);
			// $void_email = "";
			// $decode = middleware::decode_username($token[1]);
			// $user = $this -> dao -> select_user($this->db, $decode, $void_email);

			// if (!isset ($_SESSION['username']) != $user){
			// 	if(isset ($_SESSION['username']) != $user) {
			// 		return 'not_match';
			// 	}
			// 	return 'match';
			// }
			$token_dec = middleware::decode_token($_POST['accestoken']);

			if ($token_dec['exp'] < time()) {
				echo json_encode("Wrong_User");
				exit();
			}
			 //si existe la variable usuario y es igual al usuario del token 
			 //(o sea que comprobamos que el usuario de localstorage sea el mismo que el del token del servidor)
			if (isset($_SESSION['username']) && ($_SESSION['username']) == $token_dec['username']) { 
				echo json_encode("Correct_User");
				$old_token = middleware::decode_token($_POST['accestoken']);
				$new_token = middleware::create_accestoken($old_token['username']);
				echo json_encode($new_token);
				exit();
			} else {
				echo json_encode("Wrong_User");
				exit();
			}


		}


		///////////////////////////////////////
		// 	public function get_social_login_BLL($args) {
		// 	if (!empty($this -> dao -> select_user($this->db, $args[1], $args[2]))) {
		// 		$user = $this -> dao -> select_user($this->db, $args[1], $args[2]);
		// 		$jwt = jwt_process::encode($user[0]['username']);
		// 		return json_encode($jwt);
        //     } else {
		// 		$this -> dao -> insert_social_login($this->db, $args[0], $args[1], $args[2], $args[3]);
		// 		$user = $this -> dao -> select_user($this->db, $args[1], $args[2]);
		// 		$jwt = jwt_process::encode($user[0]['username']);
		// 		return json_encode($jwt);
		// 	}
		// }

		// public function get_verify_email_BLL($args) {
		// 	if($this -> dao -> select_verify_email($this->db, $args)){
		// 		$this -> dao -> update_verify_email($this->db, $args);
		// 		return 'verify';
		// 	} else {
		// 		return 'fail';
		// 	}
		// }

		// public function get_recover_email_BBL($args) {
		// 	$user = $this -> dao -> select_recover_password($this->db, $args);
		// 	$token = common::generate_Token_secure(20);

		// 	if (!empty($user)) {
		// 		$this -> dao -> update_recover_password($this->db, $args, $token);
        //         $message = ['type' => 'recover', 
        //                     'token' => $token, 
        //                     'toEmail' => $args];
        //         $email = json_decode(mail::send_email($message), true);
		// 		if (!empty($email)) {
		// 			return;  
		// 		}   
        //     }else{
        //         return 'error';
        //     }
		// }

		// public function get_verify_token_BLL($args) {
		// 	if($this -> dao -> select_verify_email($this->db, $args)){
		// 		return 'verify';
		// 	}
		// 	return 'fail';
		// }

		// public function get_new_password_BLL($args) {
		// 	$hashed_pass = password_hash($args[1], PASSWORD_DEFAULT, ['cost' => 12]);
		// 	if($this -> dao -> update_new_passwoord($this->db, $args[0], $hashed_pass)){
		// 		return 'done';
		// 	}
		// 	return 'fail';
		// }
		// public function get_refresh_token_BLL($args) {
		// 	$token = explode('"', $args);
		// 	$void_email = "";
		// 	$decode = middleware::decode_username($token[1]);
		// 	$user = $this -> dao -> select_user($this->db, $decode, $void_email);

		// 	$new_token = jwt_process::encode($user[0]['username']);

        //     return $new_token;
		// }

		// public function get_token_expires_BLL($args) {
		// 	$token = explode('"', $args);
		// 	$decode = middleware::decode_exp($token[1]);
			
        //     if(time() >= $decode) {  
		// 		return "inactivo"; 
		// 	} else{
		// 		return "activo";
		// 	}
		// }
	}