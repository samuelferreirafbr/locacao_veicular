<?php
    include_once 'Database.php';
    include_once 'User.php';

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        $user->nome = $_POST['nome'];
        $user->email = $_POST['email'];
        $user->cpf = $_POST['cpf'];

        $user->inserirUser();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
        $user->id = $_POST['id'];
        $user->deletarUser();
    }

    $users = $user->consultarUsers();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="style_insertUser.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuários</h1>
        <form method="POST" class="user-form">
            <input type="hidden" name="action" value="create">
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div>
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" maxlength="14" required>
            </div>
            <button type="submit">Cadastrar</button>
        </form>

        <h2>Lista de Usuários</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['nome']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['cpf']) ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                <button type="submit" class="delete-button">Deletar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="width: 100%; text-align: center; margin: 30px 0;">
        <a href="inserirEmprestimo.php">
            <button type="button">Ir para Empréstimos</button>
        </a>
    <div style="width: 100%; text-align: center; margin: 30px 0;"></div>
        <a href="inserirVeiculo.php">
            <button type="button">Ir para Veículos</button>
        </a>
    <div style="width: 100%; text-align: center; margin: 30px 0;">
        <a href="alteracao.php">
            <button type="button">Ir para Consulta de Empréstimos</button>
    </div>
</body>
</html>