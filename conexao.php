<?php
$servidor = "tcc_bd40.mysql.dbaas.com.br";
$usuario = "tcc_bd40";
$senha = "ROSA123456a#";
$bd = "tcc_bd40";

$con = new mysqli($servidor, $usuario, $senha, $bd);

if ($con->connect_error) {
    die("Erro na conexão: " . $con->connect_error);
}
?>