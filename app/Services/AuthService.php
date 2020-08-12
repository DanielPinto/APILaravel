<?php

namespace App\Services;


class AuthService{


    private $senha = '';

    public function makePassword($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){

        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%¨&*()_+="; // $si contem os símbolos
       
        if ($maiusculas){
              // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
              $this->senha .= str_shuffle($ma);
        }
       
          if ($minusculas){
              // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
              $this->senha .= str_shuffle($mi);
          }
       
          if ($numeros){
              // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
              $this->senha .= str_shuffle($nu);
          }
       
          if ($simbolos){
              // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
              $this->senha .= str_shuffle($si);
          }
       
          // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
          return substr(str_shuffle($this->senha),0,$tamanho);
      }




    
    public function sendEmail($senha, $to){

        $message = 'Sua nova Senha: '. $senha;
        $subject = 'Recuperação de Senha';
        $headers = 'From: suporte@danptec.com' . "\r\n" .
            'Reply-To: suporte@danptec.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        

        $enviaremail = mail($to, $subject, $message, $headers);
        
        if($enviaremail){
            return 'email enviado!';
        } else {
            return  'erro ao enviar!';
        }

    }

}