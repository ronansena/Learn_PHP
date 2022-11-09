<?php

include_once 'conectar.php';

session_start();

if (isset($_SESSION["id"]) && $_SESSION["id"] === true) {
    header("location: ../index.php");
    exit;
}

$idItem = $_SESSION["idItem"];

$query = "select nomeItem,idItem from item where idUser=$idItem";

$result = mysqli_query($conect, $query);

$nomeProdutoArray = mysqli_fetch_all($result);

// Abre o Arquvio no Modo leitura

$arquivo = fopen('in.txt', 'r',);

// Lê o conteúdo do arquivo

while (!feof($arquivo)) {

    //Mostra uma linha do arquivo

    $linha = fgets($arquivo, 1024);

    for ($i = 0; $i < sizeof($nomeProdutoArray); $i++) {
        $nomeProdutoArrayNew = trim($nomeProdutoArray[$i][0]);
        $linhaNew = trim($linha);

        $pattern = '/' . trim($linha) . '/';
        if (preg_match($pattern, $nomeProdutoArrayNew))
            echo " linha arquivo: " . $linha . " - Array: " . $nomeProdutoArray[$i][0] . " - Id: " . $nomeProdutoArray[$i][1] . '<br />';
    }
}

// Fecha arquivo aberto

fclose($arquivo);
$conect->close();
