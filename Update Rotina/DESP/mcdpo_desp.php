<?php

// ===============================
// DADOS FIXOS DO DOCUMENTO
// ===============================
$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Comunicação Interna";

// ===============================
// DADOS VINDOS DA URL / FORMULÁRIO
// ===============================
$protocolo      = trim($_GET['UlDoc_mcdpo'] ?? '');
$dataDocumento  = trim($_GET['Data'] ?? '');

$origem         = "PC-" . trim($_GET['PC'] ?? '');
$destino        = trim($_GET['Tes'] ?? '');

$nomeSolicitante = trim($_GET['colab'] ?? '');
$matriculaBruta  = preg_replace('/\D/', '', trim($_GET['mat_vend'] ?? ''));

// Formatar matrícula no padrão 1.234.567-8
$matricula = $matriculaBruta;
if (strlen($matriculaBruta) >= 8) {
    $matricula = substr($matriculaBruta, 0, 1) . "." .
                 substr($matriculaBruta, 1, 3) . "." .
                 substr($matriculaBruta, 4, 3) . "-" .
                 substr($matriculaBruta, 7, 1);
}

// Categoria do material
$categoriaMaterial = trim($_GET['NomeDesc']);

// Valor
$valor        = str_replace(',', '.', trim($_GET['Valor'] ?? '0'));
$valorExtenso = trim($_GET['Valor_ext'] ?? '');

// Autenticação
$autenticacao = trim($_GET['Aut'] ?? '');

// Assunto
$assunto = "Comprovante de Recebimento de " . $categoriaMaterial;

// Texto complementar
$observacao = trim($_GET['observacao'] ?? '');

// Valor formatado
$valorFormatado = number_format((float)$valor, 2, ',', '.');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>MC - <?php echo htmlspecialchars($nomeSolicitante); ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 40px;
            color: #000;
        }

        .container {
            max-width: 800px;
            margin: auto;
            border: 1px solid #000;
            padding: 30px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header .logo {
            flex: 0 0 120px;
        }

        .header .logo img {
            max-height: 80px;
        }

        .header .titulo {
            margin-left: 20px;
        }

        .header .titulo h1 {
            font-size: 22px;
            margin: 0;
            text-transform: uppercase;
        }

        .header .titulo h2 {
            font-size: 16px;
            margin: 5px 0 0;
            font-weight: normal;
        }

        .linha {
            margin: 15px 0;
        }

        .linha strong {
            display: inline-block;
            width: 140px;
        }

        .texto {
            margin-top: 30px;
            line-height: 1.8;
            text-align: justify;
        }

        .assinatura {
            margin-top: 60px;
        }

        .assinatura .linha-ass {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 300px;
        }

        .rodape {
            margin-top: 40px;
            font-size: 12px;
        }

        .logo {
            text-align: left;
            margin-bottom: 15px;
        }

        .logo img {
            max-height: 80px;
        }

        @media print {
            .container {
                border: none;
            }

            @page {
                margin: 2mm;
            }

            body {
                margin: 2mm;
                padding: 2mm;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container">

        <div class="header">
            <div class="logo">
                <img src="./images/logo.png" alt="Estrella Photo Studio">
            </div>

            <div class="titulo">
                <h1><?= htmlspecialchars($empresa) ?></h1>
                <h2><?= htmlspecialchars($tipoDocumento) ?></h2>
            </div>
        </div>

        <div class="linha">
            <strong>Protocolo:</strong> <?= htmlspecialchars($protocolo) ?><br>
            <strong>Data:</strong> <?= htmlspecialchars($dataDocumento) ?><br>
            <strong>De:</strong> <?= htmlspecialchars($origem) ?><br>
            <strong>Para:</strong> <?= htmlspecialchars($destino) ?>
        </div>

        <div class="linha">
            <strong>Assunto:</strong> <?= htmlspecialchars($assunto) ?>
        </div>

        <div class="texto">
            Eu, <strong><i><?= htmlspecialchars($nomeSolicitante) ?></i></strong>,
            funcionário(a) registrado(a) sob matrícula
            <strong><i><?= htmlspecialchars($matricula) ?></i></strong>,
            da unidade <strong><i><?= htmlspecialchars($origem) ?></i></strong>,
            confirmo ter recebido o 
            <strong><i><?= htmlspecialchars($categoriaMaterial) ?></i></strong> no valor de <strong><i>R$ <?= $valorFormatado ?><?= !empty($valorExtenso) ? ' (' . htmlspecialchars($valorExtenso) . ')' : '' ?></i></strong>,
            para uso nas atividades internas da empresa.
            <?php if (!empty($observacao)) : ?>
                <br><br>
                Observação: <strong><i><?= htmlspecialchars($observacao) ?></i></strong>.
            <?php endif; ?>
        </div>

        <div class="assinatura">
            <div class="linha-ass"></div>
            Assinatura do Funcionário(a)
        </div>

        <div class="rodape">
            <strong>Autenticação:</strong><br>
            <?= nl2br(htmlspecialchars($autenticacao)) ?>
        </div>

    </div>

</body>

</html>