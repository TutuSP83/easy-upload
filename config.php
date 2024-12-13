<?php
$dbHost = 'localhost';  // Certifique-se de usar letras minúsculas
$dbUsername = 'root';
$dbPassword = '';  // Insira a senha correta do MySQL, se houver
$dbName = 'cadastro';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//if ($conexao->connect_errno) {
//    echo "Erro: " . $conexao->connect_error;
//} else {
//    echo "Conexão efetuada com sucesso";
//}
//?>
