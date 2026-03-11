<?php
include_once 'Database.php';
include_once 'Emprestimo.php';
include_once 'User.php';
include_once 'Veiculo.php';

$database = new Database();
$db = $database->getConnection();

$emprestimo = new Emprestimo($db);
$user = new User($db);
$veiculo = new Veiculo($db);

$emprestimos = [];
$usuario = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];
    $usuario = $user->buscarPorCpf($cpf);

    if ($usuario) {
        $emprestimos = $emprestimo->listarEmprestimosPorUsuario($usuario['id']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvarTudo'])) {
    // Atualizar usuário
    $user->id = $_POST['id_usuario'];
    $user->nome = $_POST['nome'];
    $user->email = $_POST['email'];
    $user->cpf = $_POST['cpf'];
    $user->alterarUser();

    // Atualizar empréstimos
    if (isset($_POST['emprestimos']) && is_array($_POST['emprestimos'])) {
        foreach ($_POST['emprestimos'] as $emprestimoData) {
            $emprestimo->id = $emprestimoData['id'];
            $emprestimo->veiculo_id = $emprestimoData['veiculo_id'];
            $emprestimo->diaHora_alocado = $emprestimoData['diaHora_alocado'];
            $emprestimo->diaHora_devolucao = $emprestimoData['diaHora_devolucao'];
            $emprestimo->valorKm = $emprestimoData['valorKm'];
            $emprestimo->valorDia = $emprestimoData['valorDia'];
            $emprestimo->alterarEmprestimo();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Consulta de Empréstimos</title>
    <link rel="stylesheet" href="style_alter.css">
</head>
<body>
    <div class="container">
        <h1>Painel de Consulta de Empréstimos</h1>
        
        <form method="POST" class="consulta-form">
            <div>
                <label for="cpf">Digite o CPF do usuário:</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>
            <button type="submit">Consultar</button>
        </form>

        <?php if ($usuario): ?>
            <h2>Informações do Usuário</h2>
            <form method="POST">
                <input type="hidden" name="salvarTudo" value="1">
                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id']) ?>">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>
                <div>
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($usuario['cpf']) ?>" required>
                </div>

                <h2>Empréstimos e Veículos</h2>
                <?php if (count($emprestimos) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Empréstimo</th>
                                <th>Veículo</th>
                                <th>Data Alocação</th>
                                <th>Data Devolução</th>
                                <th>Valor Km</th>
                                <th>Valor Dia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($emprestimos as $emp): ?>
                                <tr>
                                    <td><?= htmlspecialchars($emp['id']) ?></td>
                                    <td>
                                        <input type="hidden" name="emprestimos[<?= $emp['id'] ?>][id]" value="<?= htmlspecialchars($emp['id']) ?>">
                                        <select name="emprestimos[<?= $emp['id'] ?>][veiculo_id]" required>
                                            <?php
                                                $veiculos = $veiculo->consultarVeiculos();
                                                foreach ($veiculos as $v) {
                                                    $selected = $v['id'] == $emp['veiculo_id'] ? 'selected' : '';
                                                    echo "<option value='{$v['id']}' $selected>{$v['modelo']} ({$v['placa']})</option>";
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="datetime-local" name="emprestimos[<?= $emp['id'] ?>][diaHora_alocado]" value="<?= htmlspecialchars($emp['diaHora_alocado']) ?>" required>
                                    </td>
                                    <td>
                                        <input type="datetime-local" name="emprestimos[<?= $emp['id'] ?>][diaHora_devolucao]" value="<?= htmlspecialchars($emp['diaHora_devolucao']) ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="emprestimos[<?= $emp['id'] ?>][valorKm]" value="<?= htmlspecialchars($emp['valorKm']) ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="emprestimos[<?= $emp['id'] ?>][valorDia]" value="<?= htmlspecialchars($emp['valorDia']) ?>" required>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Este usuário não tem empréstimos registrados.</p>
                <?php endif; ?>
                <button type="submit">Salvar Tudo</button>
            </form>
        <?php else: ?>
            <p>Nenhum usuário encontrado com esse CPF.</p>
        <?php endif; ?>
    </div>

    <div style="width: 100%; text-align: center; margin: 30px 0;">
        <a href="inserirUser.php">
            <button type="button">Ir para Usuários</button>
        </a>
        <a href="inserirVeiculo.php">
            <button type="button">Ir para Veículos</button>
        </a>
            <div style="width: 100%; text-align: center; margin: 30px 0;">
        <a href="inserirEmprestimo.php">
            <button type="button">Ir para Empréstimos</button>
        </a>
    </div>
</body>
</html>
