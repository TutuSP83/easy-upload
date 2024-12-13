<?php

    if(isset($_POST['submit']))
    {
        print_r($_POST['nome']);
        print_r($_POST['email']);
        print_r($_POST['telefone']);

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
        <form action="cadastro.php" method="POST">
            <fieldset>
                <legend style="color: white;"><b>Cadastro<br>Easy Upload</b></legend>
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
    </div>
</body>
</html>
