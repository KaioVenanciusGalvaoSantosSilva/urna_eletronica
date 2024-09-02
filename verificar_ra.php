<?php
// Iniciar a sessão
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'urna_eletronica');

// Verificar conexão com o banco de dados
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para validar e sanitizar o RA
function sanitizeRA($ra) {
    return filter_var($ra, FILTER_SANITIZE_NUMBER_INT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar e validar o RA
    $ra = sanitizeRA($_POST['ra']);

    if (filter_var($ra, FILTER_VALIDATE_INT) !== false) {
        // Preparar e executar a consulta
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE RA = ?");
        $stmt->bind_param('i', $ra); // Use 'i' se RA é um número inteiro
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        if ($usuario) {
            if ($usuario['votou']) {
                // Se o usuário já votou, mostrar alerta e redirecionar
                echo "<script>
                    alert('Você já votou e não pode votar novamente!');
                    window.location.href = '/';
                </script>";
            } else {
                // Atualizar o status de votou
                //$updateStmt = $conn->prepare("UPDATE usuarios SET votou = 1 WHERE RA = ?");
                //$updateStmt->bind_param('i', $ra);
                //$updateStmt->execute();

                // Armazenar dados do usuário na sessão
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['nome'];
                $_SESSION['user_ra'] = $usuario['RA'];
                $_SESSION['user_votou'] = $usuario['votou'];

                // Redirecionar para a urna
                header("Location: /urna.php");
                exit;
            }
        } else {
            // Se o RA não for encontrado, mostrar alerta e redirecionar
            echo "<script>
                alert('RA não encontrado!');
                window.location.href = '/';
            </script>";
        }
    } else {
        // Se o RA não for um número válido
        echo "<script>
            alert('RA inválido!');
            window.location.href = '/';
        </script>";
    }
}
?>
