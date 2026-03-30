<?php

/*$dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);
echo "<pre>";
	print_r($dados);
	echo "</pre>";
	exit();*/

// Importando os Dados do Formulário
$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Comprovante de Estorno";

$protocolo      = trim($_GET['UlDoc_est']);
$dataDocumento  = trim($_GET['Data']);

$origem         = "PC-" . trim($_GET['PC']);
$destino_1        = trim($_GET['Tes']);
$destino_2        = trim($_GET['std']);

$assunto        = "Comprovante de Estorno de " . trim($_GET['Aut']); // tipo de pagamento estornado

//$nomeFuncionario = trim($_GET['colab']);

// fotmatar a matrícula com hífen (1.234.567-8)
$matricula       = trim($_GET['mat_vend']);
$matricula       = substr($matricula, 0, 1) . "." . substr($matricula, 1, 3) . "." . substr($matricula, 4, 3) . "-" . substr($matricula, 7, 1);
$tipoEstorno    = trim($_GET['TipoRef']);

$valor           = trim($_GET['Valor']);
$valorExtenso    = trim($_GET['Valor_ext']);

$autenticacao    = trim($_GET['Aut']);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>EST - <?php echo $nomeFuncionario; ?></title>
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
            margin: 10px 0;
        }

        .linha strong {
            display: inline-block;
            width: 150px;
        }

        .texto {
            margin-top: 30px;
            line-height: 1.6;
            text-align: justify;
        }

        .assinatura {
            margin-top: 30px;
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
                margin: 1mm;
            }

            body {
                margin: 1mm;
                padding: 1mm;
            }
        }
    </style>
</head>

<!--<body onload="window.print()">-->
    <body>
    <!-- VIA 1: Tesouraria -->
    <div class="container vias-separadas">
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
            <strong>Origem:</strong> <?= $origem ?><br>
            <strong>Destino:</strong> <?= $destino_1 ?>
        </div>
        <div class="linha">
            <strong>Tipo de Estorno:</strong> <?= $tipoEstorno ?>
        </div>
        <div class="linha">
            <strong>Valor:</strong> R$ <?= number_format($valor, 2, ',', '.') ?> (<?= $valorExtenso ?>)
        </div>
        <div class="linha">
            <strong>Funcionaria:</strong> <?= $matricula . " - " . $nomeFuncionario ?><br>
        </div>
        <div class="texto">
            Declaro para os devidos fins que o valor acima foi estornado conforme as políticas internas da empresa.
        </div>
        <div class="assinatura">
            <div class="linha-ass"></div>
            Assinatura do Funcionária
        </div>
        <div class="rodape">
            <strong>Autenticação:</strong><br>
            <?= $autenticacao ?>
        </div>
    </div>
    <hr>

    <!-- VIA 2: Estúdio -->
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
            <strong>Origem:</strong> <?= $origem ?><br>
            <strong>Destino:</strong> <?= $destino_1 ?>
        </div>
        <div class="linha">
            <strong>Tipo de Estorno:</strong> <?= $tipoEstorno ?>
        </div>
        <div class="linha">
            <strong>Valor:</strong> R$ <?= number_format($valor, 2, ',', '.') ?> (<?= $valorExtenso ?>)
        </div>
        <div class="linha">
            <strong>Funcionaria:</strong> <?= $matricula . " - " . $nomeFuncionario ?><br>
        </div>
        <div class="texto">
            Declaro para os devidos fins que o valor acima foi estornado conforme as políticas internas da empresa.
        </div>
        <div class="assinatura">
            <div class="linha-ass"></div>
            Assinatura do Funcionária
        </div>
        <div class="rodape">
            <strong>Autenticação:</strong><br>
            <?= $autenticacao ?>
        </div>
    </div>

</body>

</html>