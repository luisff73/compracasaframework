<?php

require __DIR__ . '/vendor/autoload.php';

    class mail {
        public static function send_email($email) {
            switch ($email['type']) { // type es el tipo de email que se va a enviar, de validacion o de recuperacion
                
                case 'validate';
                    $email['fromEmail'] = 'onboarding@resend.dev';
                    $email['inputEmail'] = 'onboarding@resend.dev';
                    $email['inputMatter'] = 'Email verification';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://localhost/compracasaframework/login/verify_email/$email[token]'>Haga click aqui para verificar su correo.</a>";
                    break;
                case 'recover';
                    $email['fromEmail'] = 'onboarding@resend.dev';
                    $email['inputEmail'] = 'onboarding@resend.dev';
                    $email['inputMatter'] = 'Recover password';
                    $email['inputMessage'] = "<a href='http://localhost/compracasaframework/login/recover_email/$email[token]'>Click here for recover your password.</a>";
                    break;
            }
            return self::send_resend($email);
            
        }    

        public static function send_resend($values){
             $reenvio = parse_ini_file(UTILS . "jwt.ini");  // modificar el ini y ver el UTILS EN paths
             $api_key = $reenvio['api_key']; // busca en el ini 'api_key'

            
           $resend = Resend::client($api_key);   // busca en el ini 're_kt8KKNEG_JQd5Qfx2HejwfHKWDFNMvjQn'
        

            try {
                $result = $resend->emails->send([
                    'from' => $values['inputEmail'],
                    'to' => 'jvrluis@hotmail.com', // Esto lo pongo fijo por que solo tengo un correo
                    'subject' => $values['inputMatter'],
                    'html' => $values['inputMessage'] ,
                ]);
                
            } catch (\Exception $e) {
                exit('Error: ' . $e->getMessage());
            }   

            // Show the response of the sent email to be saved in a log...
                return $result->toJson();
        }
    }