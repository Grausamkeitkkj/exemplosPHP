<?php

    $queryParams = http_build_query([
        'variavel1' => $variavel1,
        'variavel2' => $variavel2,
    ], '', '&', PHP_QUERY_RFC3986);

    $link = 'caminho_do_arquivo.php?' . $queryParams;

?>