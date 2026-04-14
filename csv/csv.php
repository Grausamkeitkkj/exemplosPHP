<?php
    <?php 
    $aprovadas = fopen("aprovadas.csv", "r");//abre o arquivo

    $cabecalho = fgetcsv($aprovadas);//fgetcsv pega a primeira linha do CSV, sendo essa as "colunas"
    $cabecalho = array_map('trim', $cabecalho);//faz uma função pra cada item(fazendo pois a coluna "STATUS" tem um espaço)

    $resultado = [];

    while(($linha = fgetcsv($aprovadas)) !== false){//vai pegando linha por linha
        $arrayAssociativo = array_combine($cabecalho, $linha);//combina as arrays fazendo uma array associativa, sendo a da esquerda a chave e a direita o valor
        $resultado[] = $arrayAssociativo;//coloca a linha no array
    }
    fclose($aprovadas);//fecha o arquivo

    print_r($resultado);
?>
?>