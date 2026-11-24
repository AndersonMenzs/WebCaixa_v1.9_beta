<html>

<head>
    <title>WebCaixa v1.20.21_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            margin-top: 3%;
            margin-left: 3%;
            margin-right: 3%;
            border: 3px solid gray;
            padding: 10px;
            font-family: sans-serif;
        }

        .campos {
            background-color: #C0C0C0;
            font: 16px sans-serif;
            color: #000000;
        }
    </style>

    <?php include "../cabecprs.php"; ?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">

<?php
$Sis = "S7";
$Rot = "S7R2.1.1";
$lg_user = isset($_POST['txtuser']) ? trim($_POST['txtuser']) : '';
$user    = substr($lg_user, 0, 8);
$pss     = substr($lg_user, 8, 40);
$lg_userEsc = htmlspecialchars($lg_user, ENT_QUOTES, 'UTF-8');
$lg_userUrl = urlencode($lg_user);
$NumDoc = isset($_POST['txtdoc']) ? trim($_POST['txtdoc']) : '';
$Mat_Vend = isset($_POST['mat_vend']) ? trim($_POST['mat_vend']) : '';
$Vendedora = isset($_POST['vendedora']) ? trim($_POST['vendedora']) : '';
$Cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : '';
$CodBrinde = isset($_POST['cod_brinde']) ? trim($_POST['cod_brinde']) : '';
$NomeBrinde = isset($_POST['nome_brinde']) ? trim($_POST['nome_brinde']) : '';

if ($lg_user === '' || $NumDoc === '' || $Mat_Vend === '' || $Vendedora === '' || $Cliente === '' || $CodBrinde === '' || $NomeBrinde === '') {
    echo "<br><br><center><font size='5' color='gold'>Dados incompletos para confirmar o brinde. Retorne e selecione novamente os dados.</font><br><br>";
    echo "<a href='brindes.php?c_s=$lg_userUrl'><img src='images/voltar.gif'></a></center>";
    exit;
}

$NumDocF = 100000000 + (int)$NumDoc;
$NDoc = substr((string)$NumDocF, 1, 8);

include "conexao.php";
include "dbselect.php";
include "us_sist.php";

if ($ch === 'no') {
    include "us_cad.php";
}

if ($ch === 'ok-enc' || $ch === 'ok-cai' || $ch === 'ok-adm' || $ch === 'ok') {
?>
    <font color="gold" size="6"><br><b><center><u><i>CONFIRMAÇÃO DO BRINDE</i></u></center></b></font><br>

    <form name="confbrinde" method="post" action="gerabrindes.php" autocomplete="off">
        <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
            <tr>
                <td width="30%" align="center"><font color="gold" size="5"><b><i>Nº Documento</i></b></font></td>
                <td width="70%" align="center"><font size="5"><b><i><?php echo htmlspecialchars($NDoc, ENT_QUOTES, 'UTF-8'); ?></i></b></font></td>
            </tr>
            <tr>
                <td align="center"><font color="gold" size="5"><b><i>Colaboradora</i></b></font></td>
                <td align="center"><font size="5"><b><i><?php echo htmlspecialchars($Vendedora, ENT_QUOTES, 'UTF-8'); ?></i></b></font></td>
            </tr>
            <tr>
                <td align="center"><font color="gold" size="5"><b><i>Cliente</i></b></font></td>
                <td align="center"><font size="5"><b><i><?php echo htmlspecialchars($Cliente, ENT_QUOTES, 'UTF-8'); ?></i></b></font></td>
            </tr>
            <tr>
                <td align="center"><font color="gold" size="5"><b><i>Brinde</i></b></font></td>
                <td align="center"><font color="lime" size="5"><b><i><?php echo htmlspecialchars($NomeBrinde, ENT_QUOTES, 'UTF-8'); ?></i></b></font></td>
            </tr>
            <tr>
                <td align="center"><font color="gold" size="5"><b><i>Valor</i></b></font></td>
                <td align="center"><font color="lime" size="5"><b><i>BRINDE - R$ 0,00</i></b></font></td>
            </tr>
            <tr>
                <td align="center"><font color="gold" size="5"><b><i>Senha</i></b></font></td>
                <td align="center"><input type="password" name="txtsen" size="6" maxlength="6" class="campos" required></td>
            </tr>
        </table>
        <input type="hidden" name="txtuser" value="<?php echo $lg_userEsc; ?>">
        <input type="hidden" name="txtdoc" value="<?php echo htmlspecialchars($NDoc, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="mat_vend" value="<?php echo htmlspecialchars($Mat_Vend, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="vendedora" value="<?php echo htmlspecialchars($Vendedora, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="cliente" value="<?php echo htmlspecialchars($Cliente, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="cod_brinde" value="<?php echo htmlspecialchars($CodBrinde, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="nome_brinde" value="<?php echo htmlspecialchars($NomeBrinde, ENT_QUOTES, 'UTF-8'); ?>">

        <p>
            <center>
                <input type="submit" name="btenviar" value="Confirmar">
                &nbsp;&nbsp;
                <input type="button" value="Retornar" onclick="window.history.back()">
            </center>
        </p>
    </form>
<?php } else { ?>
    <br><br>
    <center>
        <font size="6"><b>Acesso <font color="gold"><u>não autorizado</u></font>!</b></font>
    </center>
    <br>
    <center><a href="servrec.php?c_s=<?php echo $lg_userUrl; ?>"><img src="images/voltar.gif"></a></center>
<?php }

$SisRot = "S-7.2.1.1";
include "rodape.php";
mysqli_close($conec);
?>

</body>

</html>
