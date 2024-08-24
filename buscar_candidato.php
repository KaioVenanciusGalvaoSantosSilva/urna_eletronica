<?php
header('Content-Type: application/json; charset=utf-8');

// Função para validar e sanitizar entrada
function sanitize_input($data) {
    // Remove espaços em branco do início e do fim
    $data = trim($data);
    // Remove barras invertidas
    $data = stripslashes($data);
    // Converte caracteres especiais em HTML
    $data = htmlspecialchars($data);
    return $data;
}

// Verifica o método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['erro' => 'Método HTTP não permitido.'], JSON_UNESCAPED_UNICODE);
    exit();
}

// Conecta ao banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=urna_eletronica', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtém o número eleitoral enviado pela requisição POST
    $numeroEleitoral = sanitize_input($_POST['numeroEleitoral']);

    // Valida o número eleitoral
    if (!preg_match('/^\d{1,2}$/', $numeroEleitoral)) {
        echo json_encode(['erro' => 'Número eleitoral inválido.'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Verifica se o número eleitoral é "00" (voto nulo)
    if ($numeroEleitoral === '00') {
        // Retorna resposta JSON para voto nulo
        echo json_encode([
            'nome' => 'Voto Nulo',
            'partido' => '',
            'foto' => ''
        ], JSON_UNESCAPED_UNICODE);
    } else {
        // Prepara e executa a consulta para buscar o candidato
        $query = $pdo->prepare("SELECT nome, partido, foto FROM candidatos WHERE numero_eleitoral = ?");
        if (!$query->execute([$numeroEleitoral])) {
            echo json_encode(['erro' => 'Falha ao executar a consulta.'], JSON_UNESCAPED_UNICODE);
            exit();
        }

        // Obtém o resultado da consulta
        $candidato = $query->fetch(PDO::FETCH_ASSOC);

        if ($candidato) {
            // Retorna os dados do candidato em formato JSON
            echo json_encode($candidato, JSON_UNESCAPED_UNICODE);
        } else {
            // Retorna uma resposta JSON vazia se o candidato não for encontrado
            echo json_encode(null, JSON_UNESCAPED_UNICODE);
        }
    }
} catch (PDOException $e) {
    // Retorna um erro JSON se não conseguir se conectar ao banco de dados
    echo json_encode(['erro' => "Falha na conexão com o banco de dados."], JSON_UNESCAPED_UNICODE);
    exit();
}
?>
