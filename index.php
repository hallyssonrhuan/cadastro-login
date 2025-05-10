<div class="container mt-5 form-container"><?php
@session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = strtolower(trim($_POST['email']));
    $senha = $_POST['senha'];
    $usuarios = file("usuarios.txt");
    foreach ($usuarios as $usuario) {
        list($nomeSalvo, $emailSalvo, $senhaHash) = array_map('trim', explode("|", $usuario));
        if ($email === $emailSalvo && password_verify($senha, $senhaHash)) {
            $_SESSION['usuario'] = $nomeSalvo;
            header("Location: logado.php");
            exit;
        }
    }
    echo "<div class='alert alert-danger'>E-mail ou senha inválidos.</div>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastro'])) {
    $nome = strip_tags($_POST['nome']);
    $email = strip_tags($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $arquivo = 'usuarios.txt';
    function check_cadastro($email, $arquivo) {
        if (file_exists($arquivo)) {
            $usuarios = file($arquivo, FILE_IGNORE_NEW_LINES);
            foreach ($usuarios as $usuario) {
                list($nome, $emailCadastrado, $senha) = explode(" | ", $usuario);
                if ($emailCadastrado == $email) {
                    return true;
                }
            }
        }
        return false;
    }

    if (check_cadastro($email, $arquivo)) {
        echo "<div class='alert alert-danger'>Este e-mail já está cadastrado!</div>";
    } else {
        $linha = "$nome | $email | $senha" . PHP_EOL;
        file_put_contents($arquivo, $linha, FILE_APPEND | LOCK_EX);
        echo "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
    }
}
?></div>

<html>
<head>
    <meta charset="UTF-8">
    <title>Acesso</title>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 form-container">
        <div id="login">
            <h3>Login</h3>
            <form method="post" class="bg-white p-4 rounded shadow">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success" name="login">Entrar</button>
                <a href="javascript:void(0);" onclick="forms()" class="btn btn-link">Não tem conta?</a>
            </form>
        </div>
        <div id="cad" class="hidden">
            <h3>Cadastro</h3>
            <form method="post" class="bg-white p-4 rounded shadow">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" name="cadastro">Cadastrar</button>
                <a href="javascript:void(0);" onclick="forms()" class="btn btn-link">Já tem conta?</a>
            </form>
        </div>

    </div>

    <script>
        function forms() {
            const login = document.getElementById('login');
            const cad = document.getElementById('cad');
            login.classList.toggle('hidden');
            cad.classList.toggle('hidden');
        }
    </script>

</body>
</html>
