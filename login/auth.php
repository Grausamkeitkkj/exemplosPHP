<?php

class Auth {
    public static function login($usuario){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);

        $_SESSION['idUsuario'] = $usuario->getIdUsuario();
        $_SESSION['tempoDeSessao'] = time()+3600;
    }
     
    //Verifica se a sessao existe, se nao existir, cira a sessao e retorna o id do usuario
    //Se nao retornar id, nao existe sessao criaada anteriormente
    public static function isLoggedIn(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['idUsuario']);
    }

    // Se nao retornar nada da funcao, redireciona
    public static function requireLogin(){
        if (!self::isLoggedIn()) {
            header("Location: index.php");
            exit();
        }
    }

    public static function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
}
