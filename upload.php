<?php
session_start();
include_once('config.php');

// Função para verificar se o arquivo é seguro
function isSafeFile($filePath) {
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'text/plain', 'video/mp4', 'video/avi'];
    $fileType = mime_content_type($filePath);
    return in_array($fileType, $allowedTypes);
}

// Função para listar arquivos no diretório de uploads
function listUploadedFiles($directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    $files = array_diff(scandir($directory), array('.', '..'));
    return $files;
}

// Variável para mensagem de erro
$error_message = '';

// Lógica de login
if (isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($senha, $row['senha'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            header('Location: upload.php');
            exit();
        } else {
            $error_message = "Senha incorreta. Tente novamente.";
        }
    } else {
        $error_message = "Email não encontrado. Verifique se você se cadastrou corretamente.";
    }
}

// Verificação do ID do usuário antes de tentar acessar diretórios de usuário
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$user_id) {
    header('Location: index.php');
    exit();
}

// Lógica de upload
if (isset($_POST['upload'])) {
    $uploadDirectory = "uploads/$user_id/";

    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $fileName = basename($_FILES['file']['name']);
    $uploadFilePath = $uploadDirectory . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
        if (isSafeFile($uploadFilePath)) {
            echo "<script>alert('Arquivo enviado com sucesso!');</script>";
        } else {
            unlink($uploadFilePath);
            echo "<script>alert('O arquivo não é seguro e foi excluído.');</script>";
        }
    } else {
        echo "<script>alert('Erro ao enviar o arquivo.');</script>";
    }
}

$uploadedFiles = listUploadedFiles("uploads/$user_id/");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Arquivos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <h1><span class="easy">Easy</span> <span class="upload">Upload</span></h1>

        <?php if (!isset($_SESSION['nome'])): ?>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="upload.php" method="post">
                <fieldset>
                    <legend style="color: white;"><b>Login</b></legend>
                    <div class="inputBox">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="inputUser" required>
                    </div>
                    <br>
                    <div class="inputBox">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" class="inputUser" required>
                    </div>
                    <br>
                    <input type="submit" name="login_submit" value="Entrar">
                </fieldset>
            </form>
        <?php else: ?>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend style="color: white;"><b>Upload de Arquivos</b></legend>
                    <input type="file" name="file" required>
                    <br><br>
                    <input type="submit" name="upload" value="Upload">
                </fieldset>
            </form>
            <br>
            <fieldset>
                <legend style="color: white;"><b>Arquivos Enviados</b></legend>
                <?php foreach ($uploadedFiles as $file): ?>
                    <p>
                        <?php echo $file; ?>
                        <a href="uploads/<?php echo $user_id; ?>/<?php echo $file; ?>" download>Download</a>
                        <a href="delete.php?file=<?php echo $file; ?>&user_id=<?php echo $user_id; ?>">Excluir</a>
                    </p>
                <?php endforeach; ?>
            </fieldset>
            <br>
            <form action="logout.php" method="post">
                <input type="submit" name="logout" value="Sair">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
