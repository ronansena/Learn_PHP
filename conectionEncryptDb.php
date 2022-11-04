<?php

include_once(__DIR__ . '/../rep.php');

$getBox = new getBox();

$envFile = getenv('ENVFILE');

if (isset($envFile)) {

    $db_database = 'nome do seu DB';
    $arrayString = array();
    $arrayStringEncrypt = array();

    $myfile = fopen($envFile, "r") or die("Unable to open file!");
    $inc = 0;

    while (!feof($myfile)) {

        $strGetFile = trim(fgets($myfile));

        $arrayString[] = $getBox->decryptionKey($strGetFile);

        $inc++;
    }
    fclose($myfile);

    $conect = @mysqli_connect($arrayString[0], $arrayString[1], $arrayString[2], $db_database);

    mysqli_query($conect, "SET NAMES 'utf8'");
    mysqli_query($conect, 'SET character_set_connection=utf8');
    mysqli_query($conect, 'SET character_set_client=utf8');
    mysqli_query($conect, 'SET character_set_results=utf8');
} else {

    echo ("<SCRIPT LANGUAGE='JavaScript'>window.alert('Variável de ambiente de conexão não configurada!');</SCRIPT>");
}
