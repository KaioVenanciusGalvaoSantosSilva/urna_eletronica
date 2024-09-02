<?php
session_start(); // Inicia a sessão
header('Content-Type: application/json; charset=utf-8');

// Função para validar e sanitizar entrada
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Verifica o método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['erro' => 'Método HTTP não permitido.'], JSON_UNESCAPED_UNICODE);
    exit();
}

// Obtém e sanitiza os dados enviados pela requisição POST
$numeroEleitoral = sanitize_input($_POST['numeroEleitoral']);
$votoTipo = sanitize_input($_POST['votoTipo']);
$userId = isset($_POST['user_id']) ? sanitize_input($_POST['user_id']) : null;

// Valida o número eleitoral e o tipo de voto
if (!preg_match('/^\d{1,2}$/', $numeroEleitoral) && $votoTipo !== 'branco' && $votoTipo !== 'nulo') {
    echo json_encode(['erro' => 'Dados inválidos.'], JSON_UNESCAPED_UNICODE);
    exit();
}

// Conecta ao banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=urna_eletronica', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Início da transação
    $pdo->beginTransaction();

    if ($votoTipo === 'branco' || $votoTipo === 'nulo') {
        // Inserção para voto branco ou nulo
        $query = $pdo->prepare("INSERT INTO votos (numero_eleitoral, voto_tipo) VALUES (?, ?)");
        $query->execute([null, $votoTipo]);
    } else {
        // Transação para voto de candidato
        $query = $pdo->prepare("INSERT INTO votos (numero_eleitoral, voto_tipo) VALUES (?, 'candidato')");
        $query->execute([$numeroEleitoral]);

        $query = $pdo->prepare("UPDATE candidatos SET votos = votos + 1 WHERE numero_eleitoral = ?");
        $query->execute([$numeroEleitoral]);
    }

    // Atualizar o status do usuário para indicar que ele votou
    $updateUser = $pdo->prepare("UPDATE usuarios SET votou = 1 WHERE id = ?");
    $updateUser->execute([$userId]);

    // Commit da transação
    $pdo->commit();

    echo json_encode('Voto registrado com sucesso!', JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    // Rollback em caso de erro
    $pdo->rollBack();
    echo json_encode(['erro' => 'Falha na conexão com o banco de dados.'], JSON_UNESCAPED_UNICODE);
    exit();
}
?>
