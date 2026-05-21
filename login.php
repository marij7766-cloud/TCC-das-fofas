<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>window.location.href='login.html';</script>";
    exit();
}

include("conexao.php");

$email = trim($_POST['email']);
$senha = $_POST['senha'];

if (empty($email) || empty($senha)) {
    ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Erro!',
        text: 'Preencha email e senha!'
    }).then(() => {
        window.history.back();
    });
    </script>
    <?php
    exit();
}

$stmt = mysqli_prepare($con, "SELECT * FROM usuarios WHERE LOWER(email) = LOWER(?)");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);

if ($usuario && password_verify($senha, $usuario['senha'])) {
    session_start();
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['email'] = $usuario['email'];
    mysqli_close($con);
    ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Login',
        text: 'Login realizado com sucesso!',
        didClose: () => {
            window.location.href = 'logado.html';   
        }
    });     
    </script>
    <?php
} else {
    mysqli_close($con);
    ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Erro!',
        text: 'Email ou senha incorretos!'
    }).then(() => {
        window.history.back();
    });
    </script>
    <?php
}
?>

</body>
</html>