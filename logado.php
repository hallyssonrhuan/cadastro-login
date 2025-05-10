<?php
@session_start();
if (!isset($_SESSION['usuario'])) {
    @header("Location: index.php");
    exit;
}
$usuarios = file("usuarios.txt", FILE_IGNORE_NEW_LINES);
$nome = "";
$email = "";
foreach ($usuarios as $usuario) {
    list($nomex, $emailx, $senhax) = array_map('trim', explode(" | ", $usuario));
    if ($_SESSION['usuario'] === $nomex) {
        $nome = $nomex;
        $email = $emailx;
        break;
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Logado</title>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    </style>
</head>
<body class="bg-light">
    <div class="container mt-3" style="width:400px">
    <div class="bg-white p-4 rounded shadow">
        <h2>Olá, <?php echo $nome; ?>!</h2>
        <p><strong>Nome:</strong> <?php echo $nome; ?></p>
        <p><strong>E-mail:</strong> <?php echo $email; ?></p>
        <a href="?sair=true" class="btn btn-danger">Sair</a></div>
    </div>
    <?php
    if (isset($_GET['sair'])) {
        @session_destroy();
        @header("Location: index.php");
        exit;
    }
    ?>
</div>
</body>
</html>
