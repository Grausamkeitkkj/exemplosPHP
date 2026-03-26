<?php
    //1. Inicializar o cURL
    $ch = curl_init();

    $dados = ['nome' => 'Guilherme', 'cargo' => 'Dev'];
    $corpoJson = json_encode($dados);


    $headers = [
        'Content-Type: application/json',     // Diz que estamos enviando JSON
        'Accept: application/json'            // Diz que queremos receber JSON
    ];

    // 2. Define as opчѕes
    curl_setopt($ch, CURLOPT_URL, "https://api.exemplo.com/dados");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $corpoJson); // Enviando o JSON pronto
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);            // Evita que o script fique "eterno"

    //3. Executa a requisiчуo e armazena a respoosta
    $res = curl_exec($ch);

    //4. Fecha a conexуo
    curl_close($ch);
?>