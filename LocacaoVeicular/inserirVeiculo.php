<?php
    include_once 'Database.php';
    include_once 'Veiculo.php';

    $database = new Database();
    $db = $database->getConnection();
    $veiculo = new Veiculo($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
        $veiculo->modelo = $_POST['modelo'];
        $veiculo->fabricante = $_POST['fabricante'];
        $veiculo->placa = $_POST['placa'];
        $veiculo->cor = $_POST['cor'];

        $veiculo->inserirVeiculo();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
        $veiculo->id = $_POST['id'];
        $veiculo->deletarVeiculo();
    }

    $veiculos = $veiculo->consultarVeiculos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Veículos</title>
    <link rel="stylesheet" href="style_insertVeiculo.css">
</head>
<body>
    <div class="container">
        <h1>Gestão de Veículos</h1>
        <form method="POST" class="veiculo-form">
            <input type="hidden" name="action" value="create">
            <div>
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" required>
            </div>
            <div>
                <label for="fabricante">Fabricante:</label>
                <input type="text" id="fabricante" name="fabricante" required>
            </div>
            <div>
                <label for="placa">Placa:</label>
                <input type="text" id="placa" name="placa" required>
            </div>
            <div>
                <label for="cor">Cor:</label>
                <input type="text" id="cor" name="cor" required>
            </div>
            <button type="submit">Cadastrar Veículo</button>
        </form>

        <h2>Lista de Veículos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Fabricante</th>
                    <th>Placa</th>
                    <th>Cor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                    <tr>
                        <td><?= htmlspecialchars($veiculo['id']) ?></td>
                        <td><?= htmlspecialchars($veiculo['modelo']) ?></td>
                        <td><?= htmlspecialchars($veiculo['fabricante']) ?></td>
                        <td><?= htmlspecialchars($veiculo['placa']) ?></td>
                        <td><?= htmlspecialchars($veiculo['cor']) ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($veiculo['id']) ?>">
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
        <a href="inserirEmprestimo.php">
            <button type="button">Ir para Empréstimos</button>
        </a>
    <div style="width: 100%; text-align: center; margin: 30px 0;">
        <a href="alteracao.php">
            <button type="button">Ir para Consulta de Empréstimos</button>
    </div>
    </div>
</body>
</html>
