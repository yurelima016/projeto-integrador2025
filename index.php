<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="./imagens/relatorio.png" type="image/x-icon">
    <title>InfoEduca - Fapam</title>
</head>

<body>

    <!-- Cabeçalho -->
    <header>
        <div >
        <div class="header-content">
            <img src="./imagens/logo-fapam.png" alt="Logo da Instituição" class="logo">
            <h1>InfoEduca - Projeto Integrador</h1>
        </div>
        </div>
    </header>

    <!-- Conteúdo -->
    <main  >
        <form action="enviaEmail.php" method="POST" enctype="multipart/form-data">
            <div class="courseContainer">
                <img src="./imagens/Banco de Dados I.png" alt="">
                <div>
                    <label for="banco_dados">Banco de Dados I</label><br>
                    <p>Professor: Gabriel</p>
                    <input type="file" name="banco_dados" id="banco_dados" required>
                </div>
            </div>

            <div class="courseContainer">
                <img src="./imagens/Banco de Dados II.png" alt="">
                <div>
                    <label for="banco_dados2">Banco de Dados II</label><br>
                    <p>Professor: Gabriel</p>
                    <input type="file" name="banco_dados2" id="banco_dados2" required>
                </div>
            </div>

            <div class="courseContainer">
                <img src="./imagens/Power BI.png" alt="">
                <div>
                    <label for="power_bi">Power BI</label><br>
                    <p>Professor: César</p>
                    <input type="file" name="power_bi" id="power_bi" required>
                </div>
            </div></div>

            <div class="courseContainer">
                <img src="./imagens/Programação Estruturada.png" alt="">
                <div>
                    <label for="programacao_estruturada">Programação Estruturada</label><br>
                    <p>Professor: Adjenor</p>
                    <input type="file" name="programacao_estruturada" id="programacao_estruturada" required>
                </div>
            </div>

            <div class="courseContainer">
                <img src="./imagens/POO.png" alt="">
                <div>
                    <label for="poo">Programação Orientada a Objetos</label><br><br><br>
                    <p>Professor: Adjenor</p>
                    <input type="file" name="poo" id="poo" required>
                </div>
            </div>

            <div class="courseContainer">
                <img src="./imagens/Programação Web.png" alt="">
                <div>
                    <label for="programacao_web">Programação WEB</label><br><br>
                    <p>Professor: Adjenor</p>
                    <input type="file" name="programacao_web" id="programacao_web" required>
                </div>
            </div>

            <div id="btn-container" class="media">
                <button type="submit">Enviar e-mails alerta</button>
            </div>
        </form>
    </main>

    <!-- Rodapé -->
    <footer>
        <h6>Fapam 2024 ©</h6>
    </footer>

</body>

</html>