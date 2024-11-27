<?php
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

function gerarNomeImagem($nome_item) {
    // Remover acentos
    $nome_item = preg_replace(
        '/[áàãâä]/i', 'a', preg_replace(
        '/[éèêë]/i', 'e', preg_replace(
        '/[íìîï]/i', 'i', preg_replace(
        '/[óòôõö]/i', 'o', preg_replace(
        '/[úùûü]/i', 'u', $nome_item)))));

    // Converter para minúsculas
    $nome_item = strtolower($nome_item);

    // Substituir espaços por underscores
    $nome_item = str_replace(' ', '_', $nome_item);

    // Adicionar a extensão .jpg ou .png (dependendo do formato desejado)
    return $nome_item . '.jpg';
}

?>