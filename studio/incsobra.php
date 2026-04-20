<?php

$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Comunicação Interna";

$destino = "Tesouraria";

$assunto        = "Comprovante Incorporação de Sobra de Numerário do WebCaixa";

// Obtendo o Login e Dados
$Sis        = "S7";
$Rot       = "S7R0.5.1";
$lg_user   = $_POST['txtuser'];
$user    = substr($lg_user, 0, 8);
$mat1 = substr($user, 0, 1);
$mat2 = substr($user, 1, 3);
$mat3 = substr($user, 4, 3);
$dv   = substr($user, 7, 1);
$userF     = "$mat1.$mat2.$mat3-$dv";
$pss     = substr($lg_user, 8, 40);
$dtOpen    = trim($_POST['txtopen']);
$Numer     = trim($_POST['txtnumer']);
$IncSobra  = trim($_POST['txtincsobra']);
$Sobra     = trim($_POST['txtsobra']);
$IncSobra = $IncSobra + $Sobra;

// Preparando Áreas
$dtI    = date('d/m/Y');
$hI     = date('H:i');
$SobraF = number_format($Sobra, 2, ",", ".");

include "us_sist.php";
if ($ch == 'no') {
    include "us_cad.php";
}

if ($ch == 'ok') {
    // Atualizando o Caixa
    include "dbselect.php";
    $sqlG = "update caixa set incsobra = $IncSobra where dtopen = '$dtOpen' ";
    $rsG  = mysqli_query($conec, $sqlG) or die("Não foi possível salvar os dados da Auditoria.");

	$sqlI = "select * from inicial order by dtaltera desc";
	$rsI  = mysqli_query ($conec, $sqlI) or die ("Não foi possível acessar os dados da Auditoria.");
	$lnI= mysqli_fetch_array($rsI);
    $PCA     = $lnI['pc'];
    $ApeA    = $lnI['ape'];

    // Obtendo o Nome da Auditora
    include "dblog.php";
    $sqlU = "select * from pessoal where mat = '$user' ";
    $rsU  = mysqli_query($conec, $sqlU) or die("Não foi possível obter dados da Auditoria.");
    $lnU  = mysqli_fetch_array($rsU);
    $NomeU = $lnU['nome'];

    // Formatando a Matrícula
    $m1 = substr($user, 0, 1);
    $m2 = substr($user, 1, 3);
    $m3 = substr($user, 4, 3);
    $dv = substr($user, 7, 1);
    $userF = "$m1.$m2.$m3-$dv";

?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Incorporar Sobra</title>
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

        <script>
            function F5(event) {
                var tecla = document.all ? window.event.keyCode : event.which;
                if (document.all) {
                    window.event.keyCode = 0;
                    window.event.returnValue = false;
                }
                if (tecla == 116) return false;
            }

            document.onkeydown = F5;
        </script>
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
                <strong>Data:</strong> <?= $dtI ?><br>
                <strong>Hora:</strong> <?= $hI ?><br>
                <strong>De:</strong> PC-<?= $PCA . "(" . $ApeA . ")" ?><br>
                <strong>Para:</strong> <?= $destino ?>
            </div>

            <div class="linha">
                <strong>Assunto:</strong> <?= $assunto ?>
            </div>

            <div class="texto">
                Eu, <strong><i><?= $NomeU ?></i></strong>, funcionário(a) registrado(a)
                sob matrícula <strong><i><?= $userF ?></i></strong> da unidade
                <strong><i>PC-<?= $PCA . "(" . $ApeA . ")" ?></i></strong>, confirmo ter feito a operação de
                <strong><i>INCORPORAR SOBRA DE NUMERÁRIO DO WEBCAIXA</i></strong> afirmando o valor atual registrado com a 
                <strong><i>Sobra: R$<?= $SobraF ?></i></strong>, conforme acordo e políticas internas da empresa.
            </div>

            <div class="assinatura">
                <div class="linha-ass"></div>
                Assinatura do Funcionário(a)
            </div>

        </div>
        <script>
            setTimeout(function() {
                window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
            }, 1000);
        </script>

    </body>

    </html>

<?php
}
?>