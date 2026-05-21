<?php

include "conexao.php";

// Recebe os dados do perfil
$email = trim($_POST['email']);


// SQL para inserir (ajuste os nomes das colunas conforme sua tabela)
$sql = "SELECT * FROM usuarios WHERE id = $email";



if(mysqli_query($con, $sql))
{
    echo json_encode(array("status" => "ok"));
} 
else 
{
    echo json_encode(array("status" => "erro"));
}

mysqli_close($con);
?>