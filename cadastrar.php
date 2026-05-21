<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
    {
    echo "<script>window.location.href='cadastrar.html';</script>";
    exit();
    }

include("conexao.php");


//Pega os dados do formulário
$nome = trim($_POST['nome']);
$sobrenome = trim($_POST['sobrenome']);
$usuario = trim($_POST['usuario']);
$datanasc = trim($_POST['datanasc']);
$email = trim($_POST['email']);
$telefone = trim($_POST['telefone']);
$senha = $_POST['senha'];

if (
    empty($nome) || empty($sobrenome) || empty($usuario) || empty($datanasc) ||
     empty($email) || empty($telefone) || strlen($senha) < 6
   ) 
   {
    ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Preencha todos os campos corretamente! Senha deve ter 6+ caracteres.'
        }).then(() => {
            window.history.back();
        });
        </script>
        <?php
        exit();
    }


//checa se usuário ou email já existe
$checkar = mysqli_prepare(
    $con,
    "SELECT id FROM usuarios 
     WHERE LOWER(usuario) = LOWER(?) 
     OR LOWER(email) = LOWER(?)"
);

mysqli_stmt_bind_param($checkar, "ss", $usuario, $email);

mysqli_stmt_execute($checkar);

$result = mysqli_stmt_get_result($checkar);

if (mysqli_num_rows($result) > 0) {

    mysqli_stmt_close($checkar);
?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Erro!',
    text: 'Usuário ou e-mail já cadastrado!'
}).then(() => {
    window.history.back();
});
</script>

<?php
exit();
}

mysqli_stmt_close($checkar);


//criptografa senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);


$stmt = mysqli_prepare(
    $con,
    "INSERT INTO usuarios 
    (nome, sobrenome, usuario, datanasc, email, telefone, senha) 
    VALUES (?, ?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt, "sssssss", $nome, $sobrenome, $usuario, $datanasc, $email, $telefone,$senhaHash
    );



// Executa cadastro
if (mysqli_stmt_execute($stmt)) 
    {
    $id = mysqli_insert_id($con);
    $_SESSION['id'] = $id;

    mysqli_stmt_close($stmt);
    mysqli_close($con);
?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Cadastro realizado!',
    text: 'Bem-vindo(a)!',
    didClose: () => {

        window.location.href = 'logado.html';

    }
});
</script>
<?php

} else {

    $erro = mysqli_error($con);

    mysqli_stmt_close($stmt);
    mysqli_close($con);
?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Erro!',
    text: 'Erro ao cadastrar: <?= $erro ?>'
}).then(() => {
    window.history.back();
});
</script>
<?php
}
?>

</body>
</html>