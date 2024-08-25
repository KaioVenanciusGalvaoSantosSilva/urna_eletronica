<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar ao banco de dados
    $pdo = new PDO('mysql:host=localhost;dbname=urna_eletronica', 'root', '');

    // Obter dados do formulário
    $nome = $_POST['nome'];
    $partido = $_POST['partido'];
    $numero = $_POST['numero'];
    $foto = $_POST['foto'];

    // Verificar se o número do candidato já existe
    $query = $pdo->prepare("SELECT COUNT(*) as total FROM candidatos WHERE numero_eleitoral = ?");
    $query->execute([$numero]);
    $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

    if ($total > 0) {
        // Número já existe
        echo '<script>alert("Número de candidato já existe."); window.location.href="cadastrar_candidato.html";</script>';
        exit();
    }

    // Verificar se um arquivo foi enviado
    if (isset($_FILES['file-input']) && $_FILES['file-input']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file-input']['tmp_name'];
        $fileName = $_FILES['file-input']['name'];
        $fileSize = $_FILES['file-input']['size'];
        $fileType = $_FILES['file-input']['type'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Definir o caminho para salvar o arquivo
        $uploadFileDir = './img/';
        $dest_path = $uploadFileDir . $fileName;
        $fotoPath = '/img/' . $fileName; // Caminho da foto a ser armazenado no banco

        // Mover o arquivo para o diretório de uploads
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Inserir dados no banco de dados
            $stmt = $pdo->prepare("INSERT INTO candidatos (nome, partido, numero_eleitoral, votos, foto) VALUES (?, ?, ?, 0, ?)");
            $stmt->execute([$nome, $partido, $numero, $fotoPath]);

            // Redirecionar para a página de cadastro após o sucesso
            echo '<script>alert("Candidato cadastrado com sucesso!"); window.location.href="cadastrar_candidato.html";</script>';
            exit();
        } else {
            echo '<script>alert("Erro ao mover o arquivo para o diretório de uploads."); window.location.href="cadastrar_candidato.html";</script>';
        }
    } else {
        echo '<script>alert("Nenhum arquivo enviado ou erro no upload."); window.location.href="cadastrar_candidato.html";</script>';
    }
}
?>
