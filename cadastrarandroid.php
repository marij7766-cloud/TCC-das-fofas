<?php
/*
include "conexao.php";

//$loginx=$_POST["usuario"];
//$senhax=$_POST["senha"];
//$fotox=$_POST["fotox"];

$loginx="ANA";
$senhax="123";

$fotox="imagem.jpg";
    $comando="Insert into tab(login,senha,foto) values
    ( '$loginx','$senhax','$fotox')";
    $resulta = mysqli_query($con,$comando);

    if ($resulta!=0)
    {
        $dados=array("status"=>"ok");
    }
    else
    {
        $dados=array("status"=>"erro");
    }

$close = mysqli_close($con);
echo json_encode($dados);

<?php

*/
include "conexao.php";

// Recebe os dados da MainActivity2
$nome = trim($_POST['nome']);
$sobrenome = trim($_POST['sobrenome']);
$usuario = trim($_POST['usuario']);
$datanasc = trim($_POST['datanasc']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];




if(!empty($email) && !empty($senha)){
    // SQL para inserir (ajuste os nomes das colunas conforme sua tabela)
    $sql = "INSERT INTO usuarios (nome, sobrenome, usuario, datanasc, email, senha) VALUES ('$nome','$sobrenome','$usuario','$datanasc','$email', '$senha')";

    if(mysqli_query($con, $sql)){
        echo json_encode(array("status" => "ok"));
    } else {
        echo json_encode(array("status" => "erro"));
    }
} else {
    echo json_encode(array("status" => "vazio"));
}
mysqli_close($con);
?>