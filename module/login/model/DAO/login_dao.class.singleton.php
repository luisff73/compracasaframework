<?php
    class login_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function select_email($db, $email){

			$sql = "SELECT email FROM users WHERE email='$email'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function insert_user($db, $username, $email, $password) {

            $hashed_pass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]); //funcion de php para encriptar la contraseña
            $hashavatar = md5(strtolower(trim($email))); //genera un hash a partir del email
            $avatar = "https://i.pravatar.cc/500?u=$hashavatar"; //genera un avatar aleatorio con el nombre de usuario
            $sql ="   INSERT INTO `users`(`username`, `password`, `email`, `type_user`, `avatar`) 
            VALUES ('$username','$hashed_pass','$email','client','$avatar')";
            return $stmt = $db->ejecutar($sql);
        }
       
        public function select_user($db, $username){

			$sql = "SELECT `username`, `password`, `email`, `type_user`, `avatar`, 'token_email','activate' FROM `users` WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
            //return $sql;
        }

        public function select_data_user($db, $username){

			$sql = "SELECT * FROM users WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_social_login($db, $id){

			$sql = "SELECT * FROM users WHERE id='$id'";
            $stmt = $db->ejecutar($sql);

            return $db->listar($stmt);
        }

        public function insert_social_login($db, $id, $username, $email, $avatar){

            $sql ="INSERT INTO users (id, username, password, email, user_type, avatar, token_email, activate)     
                VALUES ('$id', '$username', '', '$email', 'client', '$avatar', '', 1)";

            return $stmt = $db->ejecutar($sql);
        }

        public function select_verify_email($db, $token_email){

			$sql = "SELECT token_email FROM users WHERE token_email = '$token_email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        } 

        public function update_verify_email($db, $token_email){

            $sql = "UPDATE users SET activate = 1, token_email= '' WHERE token_email = '$token_email'";

            $stmt = $db->ejecutar($sql);
            return "update";
        }

        public function select_recover_password($db, $email){
			$sql = "SELECT `email` FROM `users` WHERE email = '$email' AND password NOT LIKE ('')";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function update_recover_password($db, $email, $token_email){
			$sql = "UPDATE `users` SET `token_email`= '$token_email' WHERE `email` = '$email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }

        public function update_new_passwoord($db, $token_email, $password){
            $sql = "UPDATE `users` SET `password`= '$password', `token_email`= '' WHERE `token_email` = '$token_email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }

    }

?>