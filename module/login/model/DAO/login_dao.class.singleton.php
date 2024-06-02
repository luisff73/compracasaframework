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
        public function insert_user($db, $username, $email, $hashed_pass, $avatar, $token_email,$tipo_login) {

            $sql ="INSERT INTO `users`(`username`, `password`, `email`, `type_user`, `avatar`, `token_email`, `activate`,`tipo_login`) 
            VALUES ('$username','$hashed_pass','$email','client','$avatar','$token_email',0,'$tipo_login')";
            $stmt = $db->ejecutar($sql);
        }   
        public function select_user($db, $username){
           $sql = "SELECT `username`, `password`, `email`, `type_user`, `avatar`, `token_email`,`activate`,`attempts` FROM `users` WHERE `activate`=1 and `attempts`>0 and username='$username'";
 
            $stmt = $db->ejecutar($sql);
            return $db->listar_object($stmt);  
        }     
        public function decrementa_attempts($db, $username) {
            $sql = "UPDATE `users` SET `attempts` = `attempts` - 1 WHERE `username` = '$username'";
            return $stmt = $db->ejecutar($sql);
        }
        public function select_verify_email($db, $token_email){

			$sql = "SELECT `token_email` FROM `users` WHERE `token_email` = '$token_email'";
            // return $sql;
            // exit;

            $stmt = $db->ejecutar($sql);
            return $db->listar_object($stmt);
        } 

        public function update_verify_email($db, $token_email){

            $sql = "UPDATE `users` SET activate = 1, `token_email`= '' WHERE `token_email` = '$token_email'";
            $stmt = $db->ejecutar($sql);
            //return "update";
        }

        public function select_data_user($db, $username){

			$sql = "SELECT * FROM users WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_social_login($db, $username){

            $sql = "SELECT `username`, `password`, `email`, `type_user`, `avatar`, `token_email`,`activate` FROM `users` WHERE activate=1 and username='$username'";
 
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);  
        }

        public function insert_social_login($db, $username, $email, $avatar, $tipo_login){   
            $sql ="INSERT INTO `users`(`username`, `password`, `email`, `type_user`, `avatar`, `activate`,`tipo_login`) 
            VALUES ('$username',' ','$email','client','$avatar',1,'$tipo_login')";
            return $stmt = $db->ejecutar($sql);
            //return $sql;
        }

        public function select_recover_password($db, $email){
			$sql = "SELECT `email` FROM `users` WHERE email = '$email' AND password NOT LIKE ('')";
            //echo 'valor de select_verify_email';
            //echo $sql;
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function update_recover_password($db, $email, $token_email){
			$sql = "UPDATE `users` SET `token_email`= '$token_email' WHERE `email` = '$email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }

        public function update_new_password($db, $token_email, $password){
            $sql = "UPDATE `users` SET `password`= '$password', `token_email`= '' WHERE `token_email` = '$token_email'";
            $stmt = $db->ejecutar($sql);
            return "ok";
        }

    }

?>