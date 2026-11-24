<html>

<head>
    <title>WebCaixa v1.20.21_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            margin-top: 5%;
            margin-left: 3%;
            margin-right: 3%;
            border: 3px solid gray;
            padding: 10px 10px 10px 10px;
            font-family: sans-serif;
        }

        .campos {
            background-color: #C0C0C0;
            font: 16px sans-serif;
            color: #000000;
        }
    </style>

    <link rel="stylesheet" href="./css/themes.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/ui.js"></script>

    <?php include "../cabecprs.php"; ?>

    <script>
        function putFocus(formInst, elementInst) {
            if (document.forms.length > 0) {
                document.forms[formInst].elements[elementInst].focus();
            }
        }
    </script>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
    $Sis = "S7";
    $Rot = "S7R2.1";
    $lg_user = isset($_REQUEST['c_s']) ? trim($_REQUEST['c_s']) : '';
    $lg_userEsc = htmlspecialchars($lg_user, ENT_QUOTES, 'UTF-8');
    $lg_userUrl = urlencode($lg_user);
    $user = substr($lg_user, 0, 8);
    $pss = substr($lg_user, 8, 40);
    $DataHj = date('Y-m-d');

    $Mat_Vend = isset($_POST['mat_vend']) ? trim($_POST['mat_vend']) : '';
    $Vendedora = isset($_POST['vendedora']) ? trim($_POST['vendedora']) : '';
    if ($Vendedora === '' && isset($_POST['mat_vend_input'])) {
        $Vendedora = trim($_POST['mat_vend_input']);
    }
    $Cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : '';
    $CodBrinde = isset($_POST['ref_taxbrinde'])
        ? trim($_POST['ref_taxbrinde'])
        : (isset($_POST['ref_taxprod']) ? trim($_POST['ref_taxprod']) : '');

    include "conexao.php";
    include "dbselect.php";

    if ($Mat_Vend === '' || $Vendedora === '' || strlen($Cliente) < 3 || $CodBrinde === '') {
        header('Location: brindes.php?c_s=' . $lg_userUrl);
        exit;
    }

    $CodBrindeEsc = mysqli_real_escape_string($conec, $CodBrinde);
    $sqlBrinde = "SELECT cod_prod, nome_prod FROM produtos WHERE cod_prod = '$CodBrindeEsc' AND desc_prod = 'B' LIMIT 1";
    $resBrinde = mysqli_query($conec, $sqlBrinde) or die("Não foi possível localizar o brinde.");
    $BrindeRow = mysqli_fetch_assoc($resBrinde);
    mysqli_free_result($resBrinde);

    if (!$BrindeRow) {
        echo "<center><font size='5' color='gold'>Brinde inválido ou não cadastrado.</font></center>";
        echo "<center><a href='brindes.php?c_s=$lg_userUrl'><img src='./images/voltar.gif'></a></center>";
        mysqli_close($conec);
        exit;
    }

    $Brinde = $BrindeRow['nome_prod'];
    $NumDocInicial = intval($std . "00000");

    $sql = "SELECT numdoc, datarec FROM registro
            WHERE numdoc >= $NumDocInicial
              AND subtipo IN ('TXP', 'TXPG', 'TXC', 'PROD', 'BOOK', 'CHV', 'PRODK', 'BRIN')
            ORDER BY numdoc DESC LIMIT 1";
    $rs = mysqli_query($conec, $sql) or die("Erro ao consultar o próximo documento.");
    $ln = mysqli_fetch_assoc($rs);
    mysqli_free_result($rs);

    $NumDoc = $ln ? (int)$ln['numdoc'] : $NumDocInicial;
    $DataRec = $ln ? $ln['datarec'] : '';

    if ($DataRec === '' || $DataHj >= $DataRec) {
        $NumDoc++;
    } else {
        echo "<center><font size='5' color='gold'>Entre em contato com o administrador do sistema.</font></center>";
    }

    include "us_sist.php";
    if ($ch === 'no') {
        include "us_cad.php";
    }
    ?>

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="9%">
                <a href="brindes.php?c_s=<?php echo $lg_userUrl; ?>"><img src="./images/voltar.gif"></a>
            </td>
            <td width="82%" align="center">
                <font color="gold" size="6"><b><u><i>BRINDES</i></u></b></font>
            </td>
            <td width="9%">
                <a href="brindes.php?c_s=<?php echo $lg_userUrl; ?>"><img src="./images/voltar.gif"></a>
            </td>
        </tr>
    </table>
    <br>

    <?php if ($ch === 'ok-enc' || $ch === 'ok-cai' || $ch === 'ok-adm' || $ch === 'ok') { ?>
        <form name="brindeTipo" method="post" action="confbrindes.php" autocomplete="off">
            <table width="80%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td align="center"><font color="gold" size="5"><b><i>Colaboradora</i></b></font></td>
                    <td align="center"><font color="gold" size="5"><b><i>Cliente</i></b></font></td>
                    <td align="center"><font color="gold" size="5"><b><i>Brinde</i></b></font></td>
                </tr>
                <tr>
                    <td align="center">
                        <font color="#FFFFFF" size="4"><b><i><?php echo htmlspecialchars($Vendedora, ENT_QUOTES, 'UTF-8'); ?></i></b></font>
                    </td>
                    <td align="center">
                        <font color="lime" size="4"><b><i><?php echo htmlspecialchars($Cliente, ENT_QUOTES, 'UTF-8'); ?></i></b></font>
                    </td>
                    <td align="center">
                        <font color="lime" size="4"><b><i><?php echo htmlspecialchars($Brinde, ENT_QUOTES, 'UTF-8'); ?></i></b></font>
                    </td>
                </tr>
            </table>
            <br>

            <table width="80%" border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td align="center"><font size="5"><b><i>Nº Recibo</i></b></font></td>
                    <td align="center"><font size="5"><b><i>Forma de Pagamento</i></b></font></td>
                    <td align="center"><font size="5"><b><i>Valor</i></b></font></td>
                </tr>
                <tr>
                    <td align="center"><font size="5"><b><i><?php echo $NumDoc; ?></i></b></font></td>
                    <td align="center"><font color="lime" size="5"><b><i>BRINDE</i></b></font></td>
                    <td align="center"><font size="5"><b><i>R$ 0,00</i></b></font></td>
                </tr>
            </table>
            <br>

            <input type="hidden" name="txtuser" value="<?php echo $lg_userEsc; ?>">
            <input type="hidden" name="txtdoc" value="<?php echo $NumDoc; ?>">
            <input type="hidden" name="mat_vend" value="<?php echo htmlspecialchars($Mat_Vend, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="vendedora" value="<?php echo htmlspecialchars($Vendedora, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="cliente" value="<?php echo htmlspecialchars($Cliente, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="cod_brinde" value="<?php echo htmlspecialchars($BrindeRow['cod_prod'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="nome_brinde" value="<?php echo htmlspecialchars($Brinde, ENT_QUOTES, 'UTF-8'); ?>">

            <center>
                <input type="submit" name="btenviar" value="Continuar">
                &nbsp;&nbsp;
                <input type="button" value="Retornar" onclick="window.history.back()">
            </center>
        </form>
    <?php } else { ?>
        <br><br>
        <center>
            <font size="6"><b>Acesso <font color="gold"><u>não autorizado</u></font>!</b></font>
        </center>
        <br>
        <center><a href="servrec.php?c_s=<?php echo $lg_userUrl; ?>"><img src="images/voltar.gif"></a></center>
    <?php } ?>

    <?php
    $SisRot = "S-7.2.1";
    include "rodape.php";
    mysqli_close($conec);
    ?>

</body>

</html>
