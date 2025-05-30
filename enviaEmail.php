<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $materias = [
        'banco_dados' => 'Banco de Dados I',
        'banco_dados2' => 'Banco de Dados II',
        'programacao_estruturada' => 'Programação Estruturada',
        'power_bi' => 'Power BI',
        'poo' => 'Programação Orientada a Objetos',
        'programacao_web' => 'Programação WEB'
    ];

    $alunos = [];

    foreach ($materias as $chave => $materia) {
        if (isset($_FILES[$chave]) && $_FILES[$chave]['error'] == 0) {
            $tempFilePath = $_FILES[$chave]['tmp_name'];
            $dadosArray = file($tempFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $headers = explode(',', $dadosArray[0]);

            for ($i = 1; $i < count($dadosArray); $i++) {
                $dados = explode(',', $dadosArray[$i]);
                $email = trim($dados[1], ' "'); // Remove espaços e aspas
                $statusAtividades = [];
                for ($j = 2; $j < count($headers); $j += 2) {
                    if (isset($headers[$j]) && !empty($dados[$j])) {
                        $nomeAtividade = trim($headers[$j]);
                        $statusAtividades[$nomeAtividade] = trim($dados[$j]);
                    }
                }

                if (!isset($alunos[$email])) {
                    $alunos[$email] = [
                        'email' => $email,
                        'atividades' => []
                    ];
                }
                $alunos[$email]['atividades'][$materia] = $statusAtividades;
            }
        } else {
            echo "Erro no upload do arquivo para a matéria: $materia.<br>";
        }
    }

    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    require("./phpmailer/class.phpmailer.php");
    require("./phpmailer/class.smtp.php");

    $todosEnviados = true; // Variável para monitorar o envio

    foreach ($alunos as $aluno) {
        $mail = new PHPMailer();
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Host = "email-ssl.com.br";
        $mail->SMTPAuth = true;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Port = 465;
        $mail->Username = 'fapam@bitsolucoesweb.com.br';
        $mail->Password = 'Fap@m*V1rtual24';
        $mail->SMTPDebug = false;
        $mail->From = "fapam@bitsolucoesweb.com.br";
        $mail->FromName = utf8_decode("Atividades Fapam Virtual");

        // destinatário dinamico
        $mail->AddAddress($aluno['email']);
        $mail->IsHTML(true);
        $mail->SetLanguage("br");
        $mail->CharSet = 'UTF-8'; // correção para caracteres especiais
        $mail->Subject = "Atividades Fapam Virtual"; 

        // corpo da mensagem personalizada
        $body = "<p>Olá, estudante!</p>";
        $body .= "<p>Aqui vai seu resumo semanal. Vamos dar aquela atenção especial nas pendências pra ficar tudo em dia! Não vai esquecer, hein? 😉</p>";

        // Inicializa listas de atividades pendentes e concluídas
        $pendentes = "";
        $concluidas = "";

        foreach ($aluno['atividades'] as $materia => $atividades) {
            // Inicializa as listas para cada matéria
            $atividadesPendentes = "";
            $atividadesConcluidas = "";

            foreach ($atividades as $atividade => $status) {
                $strAtividades = trim($atividade, ' "');
                $strStatus = trim($status, ' "');

                // Adiciona atividade à lista correspondente
                if ($strStatus == "Não concluído") {
                    $atividadesPendentes .= "<li>$strAtividades</li>";
                } elseif ($strStatus == "Concluído") {
                    $atividadesConcluidas .= "<li>$strAtividades</li>";
                }
            }

            // Se houver pendentes para a matéria, adiciona à seção pendente
            if ($atividadesPendentes) {
                $pendentes .= "<li><strong>$materia</strong><ul>$atividadesPendentes</ul></li>";
            }

            // Se houver concluídas para a matéria, adiciona à seção concluída
            if ($atividadesConcluidas) {
                $concluidas .= "<li><strong>$materia</strong><ul>$atividadesConcluidas</ul></li>";
            }
        }

        // Monta o corpo com seções de pendentes e concluídas
        if ($pendentes) {
            $body .= "<h3>📌 Atividades Pendentes:</h3><ul>$pendentes</ul>";
        }
        if ($concluidas) {
            $body .= "<h3>✅ Atividades Concluídas:</h3><ul>$concluidas</ul>";
        }

        $body .= "<p>Então, foco nos prazos e bora terminar o que falta! 💪</p>";

        $mail->Body = $body;

        // Envio do email e verificação
        if (!$mail->Send()) {
            echo 'Erro ao enviar mensagem para "' . $aluno['email'] . '"! ' . $mail->ErrorInfo . "<br>";
            $todosEnviados = false;
        }

        // Limpar os destinatários para o próximo envio
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
    }

    // Exibir o alerta de sucesso ou falha após todos os envios
    if ($todosEnviados) {
        echo '<script>
            alert("E-mails enviados com sucesso!");
            window.location.href = "index.php";
        </script>';
    } else {
        echo '<script>
            alert("Houve um erro ao enviar alguns e-mails.");
            window.location.href = "index.php";
        </script>';
    }
}
?>
