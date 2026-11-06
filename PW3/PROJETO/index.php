<?php
    require_once 'Usuario.php';

    $erro = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';

        if ($nome !== '') {
            Usuario::adicionarUsuario($nome);

            header('Location: index.php?sucesso=1');
            exit;
        } else {
            $erro = 'Informe um nome válido.';
        }
    }

    $usuarios = Usuario::listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .alerta {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        form {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            max-width: 400px;
        }

        input[type="text"] {
            padding: 8px;
            width: 220px;
        }

        button {
            padding: 8px 12px;
            cursor: pointer;
        }

        ul {
            line-height: 1.8;
        }
    </style>
</head>
<body>

    <h1>Lista de Usuários</h1>

    <?php
        if (isset($_GET['sucesso'])) {
            echo '<div class="sucesso">Nome cadastrado com sucesso.</div>';
        }

        if ($erro !== '') {
            echo '<div class="erro">' . htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') . '</div>';
        }
    ?>

    <div id="formulario">
        <h2>Adicionar novo nome</h2>

        <form method="post" action="">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <button type="submit">Adicionar</button>
        </form>
    </div>

    <?php
        if (count($usuarios) === 0) {
            echo '<div class="alerta">';
            echo 'Não há registros.<br><br>';
            echo 'Use o formulário acima para incluir um nome.';
            echo '</div>';

            echo '<script>alert("Não há registros.");</script>';
        } else {
            echo '<h2>Nomes cadastrados</h2>';
            echo '<ul>';

            foreach ($usuarios as $usuario) {
                echo '<li>' . htmlspecialchars($usuario->getNome(), ENT_QUOTES, 'UTF-8') . '</li>';
            }

            echo '</ul>';
        }
    ?>

</body>
</html>