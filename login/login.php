<?php

$conexao = new Conexao();
$pdo = $conexao->getPdo();
$usuarioPesquisa = new UsuarioPesquisa($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['emailnome'] ?? null;
    $senha = $_POST['senha'] ?? null;

    $usuario = $usuarioPesquisa->getUsuarioPorEmail($email);

    if ($usuario && password_verify($senha, $usuario->getSenhaUsuario())) {
        Auth::login($usuario);
        header('Location: relatorio_gasto.php');
        exit();
    } else {
        header('Location: index.php?erro=1');
        exit();
    }
}