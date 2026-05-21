<?php 
session_start();
include("conexao.php");

// Verifica se usuário está logado
if (!isset($_SESSION['id'])) 
    {
    exit("Não está logado");
    }

$id = (int) $_SESSION['id'];

$stmt = mysqli_prepare($con, "DELETE FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    session_destroy();
    echo "Perfil apagado com sucesso";
} else {
    echo "Erro ao apagar perfil";
}

?>
