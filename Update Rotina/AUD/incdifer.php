<?php

// Preparando as variáveis
$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Comunicação Interna";

$destino = "Tesouraria";

$assunto        = "Atualização do Saldo Inicial do WebCaixa Por Término Anormal do Sistema";

// Obtendo o Login e Dados
$Sis        = "S7";
$Rot       = "S7R0.7.1";
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
$Difer     = trim($_POST['txtdifer']);
$Oper      = trim($_POST['lsOp']);

// Preparando Áreas
$Data    = date('d/m/Y');
$Hora     = date('H:i');

if ($Oper == 'D') {
    $Numer  = $Numer - $Difer;
} else {
    $Numer  = $Numer + $Difer;
}
$NumerF = number_format($Numer, 2, ",", ".");

include "us_sist.php";
if ($ch == 'no') {
    include "us_cad.php";
}

if ($ch == 'ok') {
    // Obtendo o Nome da Auditora
    include "dblog.php";
    $sqlU = "select nome from pessoal where mat = '$user' ";
    $rsU  = mysqli_query($conec, $sqlU) or die("Não foi possível obter dados da Auditoria.");
    $lnU  = mysqli_fetch_array($rsU);
    $NomeFunc = $lnU['nome'];

    // Formatando a Matrícula
    $m1 = substr($user, 0, 1);
    $m2 = substr($user, 1, 3);
    $m3 = substr($user, 4, 3);
    $dv = substr($user, 7, 1);
    $userF = "$m1.$m2.$m3-$dv";

    // Atualizando o Caixa
    include "dbselect.php";

    // Obtendo o PC
    $sql = "select pc, ape from inicial order by dtaltera desc";
    $rs  =  mysqli_query($conec, $sql) or die("File incdifer Error #0. Contate seu Administrador.");
    $ln  = mysqli_fetch_array($rs);
    $PC   = $ln['pc'];
    $Apl  = $ln['ape'];

    $sqlG = "update caixa set numerario = $Numer where dtopen = '$dtOpen' ";
    $rsG  = mysqli_query($conec, $sqlG) or die("Erro de Banco de Dados #1. Contate seu Administrador.");

    $sqlF = "insert into anormalend values ('$dtOpen', '$hI', $Numer, $Difer, '$Oper', '$user')";
    $rsF  = mysqli_query($conec, $sqlF) or die("Erro de Banco de Dados #2. Contate seu Administrador.");

    // Encerrando a Conexão
    mysqli_free_result($rsG);

    for ($I = 0; $I <= 1; $I++) {
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
                        <strong>Data:</strong> <?= $Data ?><br>
                        <strong>Hora:</strong> <?= $Hora ?><br>
                        <strong>De:</strong> PC-<?= $PC . "(" . $Apl . ")" ?><br>
                        <strong>Para:</strong> <?= $destino ?>
                    </div>

                    <div class="linha">
                        <strong>Assunto:</strong> <?= $assunto ?>
                    </div>

                    <div class="texto">
                        Eu, <strong><i><?= $NomeFunc ?></i></strong>, funcionário(a) registrado(a)
                        sob matrícula <strong><i><?= $userF ?></i></strong> da unidade
                        <strong><i>PC-<?= $PC . "(" . $Apl . ")" ?></i></strong>, confirmo ter feito a operação de
                        <strong><i>RETIFICAÇÃO POR TÉRMINO ANORMAL</i></strong> afirmando o
                        saldo inicial corrigido para <strong><i>R$<?= $NumerF ?></i></strong>, conforme acordo e políticas internas da empresa.
                    </div>

                    <div class="assinatura">
                        <div class="linha-ass"></div>
                        Assinatura do Funcionário(a)
                    </div>

                </div>
                <br><br>
                <script>
                    setTimeout(function() {
                        window.location.href = './aud.php?c_s=<?php echo $lg_user; ?>';
                    }, 1000);
                </script>

            </body>

        </html>

<?php }
}
