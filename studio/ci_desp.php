<?php

	/*$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);
	echo "<pre>";
	print_r($dados);
	echo "</pre>";
	exit();*/
// ==========================
// Dados do Documento
// ==========================
$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Comunicação Interna";

$protocolo      = "CI-2026-0012";
$dataDocumento  = "30/01/2026";

$origem         = "PC-206 (Campo Grande 1)";
$destino        = "Tesouraria";

$assunto        = "Comprovante de Recebimento de Adiantamento Salarial";

$nomeFuncionario = "ALESSANDRA MARTINS CARVALHO DA SILVA";
$matricula       = "0.0000.035-9";
$unidade         = "PC-206";
$tipoDespesa    = "Adiantamento Salarial";

$valor           = 200.00;
$valorExtenso    = "duzentos reais";

$autenticacao    = "00022221036CI20260012300126DDP9800000035-9";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>CI - <?php echo $nomeFuncionario; ?></title>
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

<body>

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
            <strong>Protocolo:</strong> <?= $protocolo ?><br>
            <strong>Data:</strong> <?= $dataDocumento ?><br>
            <strong>De:</strong> <?= $origem ?><br>
            <strong>Para:</strong> <?= $destino ?>
        </div>

        <div class="linha">
            <strong>Assunto:</strong> <?= $assunto ?>
        </div>

        <div class="texto">
            Eu, <strong><i><?= $nomeFuncionario ?></i></strong>, funcionário(a) registrado(a)
            sob matrícula <strong><i><?= $matricula ?></i></strong> da unidade
            <strong><i><?= $origem ?></i></strong>, confirmo ter recebido o valor de
            <strong><i>R$ <?= number_format($valor, 2, ',', '.') . " (" . $valorExtenso . ")" ?></i></strong>
            referente a(o) <strong><i><?= $tipoDespesa ?></i></strong>, 
            conforme acordo e políticas internas da empresa.
        </div>

        <div class="assinatura">
            <div class="linha-ass"></div>
            Assinatura do Funcionário(a)
        </div>

        <div class="rodape">
            <strong>Autenticação:</strong><br>
            <?= $autenticacao ?>
        </div>

    </div>

</body>

</html>