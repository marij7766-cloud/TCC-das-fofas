<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id'])) {
    exit("Não logado");
}

$id = (int) $_SESSION['id'];

$stmt = mysqli_prepare($con, "UPDATE usuarios SET foto = NULL WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    echo "Foto removida com sucesso";
} else {
    echo "Erro ao remover foto";
}