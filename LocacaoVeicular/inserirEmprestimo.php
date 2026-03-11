<?php
    include_once 'Database.php';
    include_once 'Emprestimo.php';

    $database = new Database();
    $db = $database->getConnection();
    $emprestimo = new Emprestimo($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        $emprestimo->diaHora_alocado = $_POST['diaHora_alocado'];
        $emprestimo->diaHora_devolucao = $_POST['diaHora_devolucao'];
        $emprestimo->valorKm = $_POST['valorKm'];
        $emprestimo->valorDia = $_POST['valorDia'];
        $emprestimo->veiculo_id = $_POST['veiculo_id'];
        $emprestimo->usuario_id = $_POST['usuario_id'];

        $emprestimo->inserirEmprestimo();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
        $emprestimo->id = $_POST['id'];
        $emprestimo->deletarEmprestimo();
    }

    $emprestimos = $emprestimo->consultarEmprestimos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Empréstimos</title>
    <link rel="stylesheet" href="style_insertEmprestimo.css">
</head>
<body>
    <div class="container">
        <h1>Gestão de Empréstimos</h1>
        <form method="POST" class="emprestimo-form">
            <input type="hidden" name="action" value="create">
            <div>
                <label for="veiculo_id">ID do Veículo:</label>
                <input type="number" id="veiculo_id" name="veiculo_id" required>
            </div>
            <div>
                <label for="usuario_id">ID do Usuário:</label>
                <input type="number" id="usuario_id" name="usuario_id" required>
            </div>
            <div>
                <label for="diaHora_alocado">Data e Hora da Alocação:</label>
                <input type="datetime-local" id="diaHora_alocado" name="diaHora_alocado" required>
            </div>
            <div>
                <label for="diaHora_devolucao">Data e Hora da Devolução:</label>
                <input type="datetime-local" id="diaHora_devolucao" name="diaHora_devolucao" required>
            </div>
            <div>
                <label for="valorKm">Valor por Km (R$):</label>
                <input type="number" step="0.01" id="valorKm" name="valorKm" required>
            </div>
            <div>
                <label for="valorDia">Valor por Dia (R$):</label>
                <input type="number" step="0.01" id="valorDia" name="valorDia" required>
            </div>
            <button type="submit">Cadastrar Empréstimo</button>
        </form>

        <h2>Lista de Empréstimos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Veículo</th>
                    <th>ID Usuário</th>
                    <th>Data Alocação</th>
                    <th>Data Devolução</th>
                    <th>Valor por Km</th>
                    <th>Valor por Dia</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprestimos as $emprestimo): ?>
                    <tr>
                        <td><?= htmlspecialchars($emprestimo['id']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['veiculo_id']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['usuario_id']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['diaHora_alocado']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['diaHora_devolucao']) ?></td>
                        <td>R$ <?= htmlspecialchars($emprestimo['valorKm']) ?></td>
                        <td>R$ <?= htmlspecialchars($emprestimo['valorDia']) ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($emprestimo['id']) ?>">
                                <button type="submit" class="delete-button">Deletar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="width: 100%; text-align: center; margin: 30px 0;">
        <a href="inserirUser.php">
            <button type="button">Ir para Usuários</button>
        </a>
    <div style="width: 100%; text-align: center; margin: 30px 0;">
        <a href="inserirVeiculo.php">
            <button type="button">Ir para Veículos</button>
        </a>
    <div style="width: 100%; text-align: center; margin: 30px 0;"></div>
        <a href="alteracao.php">
            <button type="button">Ir para Consulta de Empréstimos</button>
        </a>
    </div>
</body>
</html>