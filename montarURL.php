<?php
    $categoria = htmlspecialchars($assuntoProntuario['nome'] ?? 'Categoria não informada');

    $idCategoria = $assuntoProntuario['id'] ?? null;

    if ($idProntuarioBase64 !== null && $idCategoria !== null) {
        $encodedCategoriaId = base64_encode((string) $idCategoria);

        $queryParams = http_build_query([
            'idProntuario' => $idProntuarioBase64,
            'idCategoriaProntuario' => $encodedCategoriaId,
        ], '', '&', PHP_QUERY_RFC3986);

        $link = 'assunto_prontuario.php?' . $queryParams;
        echo '<a href="' . $link . '" class="text-primary">' . $categoria . '</a>';
    } else {
        echo $categoria;
    }
?>