<?php
// Preparando as variáveis
$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Ajuste Emergencial";

$lacre      = trim($_GET['Lacre']);
$dataDocumento  = trim($_GET['DataF']);
$horaDocumento  = trim($_GET['HoraF']);

$origem         = trim($_GET['PC']);
$destino        = "Tesouraria";

$assunto        = "Comprovante de Ajuste Emergencial";

$valor           = trim($_GET['ValorF']);
$valorExtenso    = trim($_GET['Valor_ext']);

$Colaboradora      = trim($_GET['NomeColab']);
$MatColaboradora       = trim($_GET['MatReceb']);
$MatColaboradora       = substr($MatColaboradora, 0, 1) . "." . substr($MatColaboradora, 1, 3) . "." . substr($MatColaboradora, 4, 3) . "-" . substr($MatColaboradora, 7, 1);

$autenticacao    = trim($_GET['Aut']);

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>LC - <?php echo $lacre; ?></title>
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

        h1,
        h2 {
            margin: 5px 0;
        }

        h1 {
            font-size: 22px;
            text-transform: uppercase;
        }

        h2 {
            font-size: 16px;
            font-weight: normal;
        }

        .linha {
            margin: 15px 0;
        }

        .linha strong {
            display: inline-block;
            width: 110px;
        }

        .texto {
            margin-top: 30px;
            line-height: 1.6;
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

            /* Remove margens padrão */
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
                <h1><?= $empresa ?></h1>
                <h2><?= $tipoDocumento ?></h2>
            </div>
        </div>

        <div class="linha">
            <strong>Lacre:</strong> <?= $lacre ?><br>
            <strong>Data:</strong> <?= $dataDocumento ?><br>
            <strong>Hora:</strong> <?= $horaDocumento ?><br>
            <strong>De:</strong> <?= $origem ?><br>
            <strong>Para:</strong> <?= $destino ?>
        </div>

        <div class="linha">
            <strong>Assunto:</strong> <?= $assunto ?>
        </div>

        <div class="texto">
            Declaro para os devidos fins que foi realizado o ajuste emergencial de caixa no valor de <strong><i>R$ <?= htmlspecialchars($valor) . " (" . $valorExtenso . ")" ?></i></strong>,
            vinculado ao lacre <strong><i><?= htmlspecialchars($lacre) ?></i></strong>,
            na unidade <strong><i><?= htmlspecialchars($origem) ?></i></strong>.

            <br><br>

            O ajuste emergencial foi efetuado por
            <strong><i><?= htmlspecialchars($Colaboradora) ?></i></strong>,
            matrícula <strong><i><?= htmlspecialchars($MatColaboradora) ?></i></strong>.
        </div>

        <div class="assinatura">
            <div class="linha-ass"></div>
            Assinatura da Encarregada
        </div>

        <div class="rodape">
            <strong>Autenticação:</strong><br>
            <?= $autenticacao ?>
        </div>
    </div>
</body>

</html>