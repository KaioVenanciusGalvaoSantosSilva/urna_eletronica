<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar ao banco de dados
    $pdo = new PDO('mysql:host=localhost;dbname=urna_eletronica', 'root', '');

    // Obter dados do formulário
    $nome = $_POST['nome'];
    $partido = $_POST['partido'];
    $numero = $_POST['numero'];
    $foto = $_POST['foto'];

    // Obter dados do vice
    $nome_vice = $_POST['nome_vice'];
    $foto_vice = $_POST['foto_vice'];

    // Verificar se o número do candidato já existe
    $query = $pdo->prepare("SELECT COUNT(*) as total FROM candidatos WHERE numero_eleitoral = ?");
    $query->execute([$numero]);
    $total = $query->fetch(PDO::FETCH_ASSOC)['total'];

    if ($total > 0) {
        // Número já existe
        echo '<script>alert("Número de candidato já existe."); window.location.href="cadastrar_candidato.html";</script>';
        exit();
    }

    // Função para mover o arquivo para o diretório de uploads
    function moverArquivo($fileInput, $uploadDir) {
        if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$fileInput]['tmp_name'];
            $fileName = $_FILES[$fileInput]['name'];
            $fileNameCmps = explode('.', $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Definir o caminho para salvar o arquivo
            $destPath = $uploadDir . $fileName;

            // Mover o arquivo para o diretório de uploads
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                return '/img/' . $fileName; // Retorna o caminho da foto a ser armazenado no banco
            } else {
                return false; // Retorna false se houver erro ao mover o arquivo
            }
        }
        return false; // Retorna false se não houver arquivo enviado
    }

    // Caminho do diretório de uploads
    $uploadFileDir = './img/';

    // Mover a foto do candidato
    $fotoPath = moverArquivo('file-input', $uploadFileDir);

    // Mover a foto do vice
    $fotoVicePath = moverArquivo('file-input-vice', $uploadFileDir);

    // Verificar se ambos os uploads foram bem-sucedidos
    if ($fotoPath && $fotoVicePath) {
        // Inserir dados no banco de dados
        $stmt = $pdo->prepare("INSERT INTO candidatos (nome, partido, numero_eleitoral, votos, foto, nome_vice, foto_vice) VALUES (?, ?, ?, 0, ?, ?, ?)");
        $stmt->execute([$nome, $partido, $numero, $fotoPath, $nome_vice, $fotoVicePath]);

        // Redirecionar para a página de cadastro após o sucesso
        echo '<script>alert("Candidato e vice cadastrados com sucesso!"); window.location.href="cadastrar_candidato.html";</script>';
        exit();
    } else {
        echo '<script>alert("Erro ao mover os arquivos para o diretório de uploads."); window.location.href="cadastrar_candidato.html";</script>';
    }
}
?>
