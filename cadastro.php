<?php

$error_message = '';

if (isset($_POST['submit'])) {
    include_once('config.php');

    $nome = $_POST['nome'];
    $senha_plain = $_POST['senha']; 
    $senha = password_hash($senha_plain, PASSWORD_BCRYPT); // Hash da senha para segurança
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $sexo = $_POST['genero'];
    $data_nasc = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO usuarios (nome, senha, email, telefone, genero, data_nascimento, cidade, estado, endereco) 
            VALUES ('$nome', '$senha', '$email', '$telefone', '$sexo', '$data_nasc', '$cidade', '$estado', '$endereco')";

    $result = mysqli_query($conexao, $sql);

    if ($result) {
        // Recuperar o ID do usuário recém-criado
        $user_id = mysqli_insert_id($conexao);

        // Criar o diretório de uploads para o usuário
        $user_directory = "uploads/$user_id/";
        if (!file_exists($user_directory)) {
            mkdir($user_directory, 0777, true);
        }

        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
        header('Location: index.php');  // Redireciona para a página de login após o sucesso
        exit();
    } else {
        $error_message = "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Easy Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <h1><span class="easy">Easy</span> <span class="upload">Upload</span></h1>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="cadastro.php" method="post">
            <fieldset>
                <legend style="color: white;"><b>Cadastro</b></legend>
                <br>
                <div class="inputBox">
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="telefone">Telefone</label>
                    <input type="tel" name="telefone" id="telefone" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                </div>
                <p>Sexo:</p>
                <input type="radio" id="masculino" name="genero" value="masculino" required>
                <label for="masculino">Masculino</label>
                <br>
                <input type="radio" id="feminino" name="genero" value="feminino" required>
                <label for="feminino">Feminino</label>
                <br>
                <input type="radio" id="outro" name="genero" value="outro" required>
                <label for="outro">Outro</label>
                <br><br>
                <label for="data_nascimento"><b>Data de Nascimento:</b></label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
                <br><br>
                <div class="inputBox">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" id="estado" class="inputUser" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="endereco">Endereço</label>
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                </div>
                <br>
                <input type="submit" name="submit" id="submit" value="Cadastrar">
            </fieldset>
        </form>
        <br>
        <form action="index.php" method="get">
            <input type="submit" name="login" id="login" value="Fazer Login">
        </form>
    </div>
</body>
</html>
