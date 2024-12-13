<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Easy Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <h1><span class="easy">Easy</span> <span class="upload">Upload</span></h1>
        <?php if (isset($_GET['logged_out']) && $_GET['logged_out'] == 'true'): ?>
            <p class="success-message">Você saiu com sucesso.</p>
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
        <br>
        <form action="cadastro.php" method="get">
            <input type="submit" name="login" id="login" value="Cadastrar">
        </form>
    </div>
</body>
</html>
