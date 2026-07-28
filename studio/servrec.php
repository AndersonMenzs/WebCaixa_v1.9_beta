<html>

<head>
    <title>WebCaixa v1.20.21_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            margin-left: 1%;
            margin-right: 1%;
            border: 3px solid gray;
            padding: 10px 10px 10px 10px;
            font-family: sans-serif;
        }

        #img_carne {
            padding: 5px;
            border: 2px solid white;
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

    <?php
    include "../cabecprs.php";

    // Autorizando o Login
    $Sis     = "S7";
    $Rot     = "S7R2";
    $lg_user = $_REQUEST['c_s'];
    $user  = substr($lg_user, 0, 8);
    $pss   = substr($lg_user, 8, 40);
    $ch      = '';

    $dataH = date('Y-m-d');
    ?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
    <?php include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    }

    include "sitcaixa.php";
    include "valida_caixa.php";

    $Recolh = 300.00;
    $sqlRecolh = "select vlr_config from config_sys where cod_config = 'RECOLH' order by id desc limit 1";
    $rsRecolh  = mysqli_query($conec, $sqlRecolh) or die("Erro de Banco de Dados #0. Contate seu Administrador.");
    if ($lnRecolh = mysqli_fetch_array($rsRecolh)) {
        $Recolh = (float) $lnRecolh['vlr_config'];
    }

    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
        bloquear_se_caixa_anterior_aberto($conec, $lg_user);
    }

    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
        $ValRec = 0.00;
        $ValDesp = 0.00;
        $Deposito = 0.00;

        // Avaliando o Numerário em Caixa
        $sql = "select numerario, cashtot from caixa where dtopen = '$dataH' ";
        $rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1. Contate seu Administrador.");
        $ln  = mysqli_fetch_array($rs);
        $Gaveta = (float) $ln['numerario'];
        $Cash   = (float) $ln['cashtot'];

        // Avaliando o Total Arrecadado
        $sql = "select vlrec from registro where modpgto = '10' and tiporec <> 'E' and tiporec <> '8' and estorno = '' and  datarec = '$dataH' ";
        $rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #2. Contate seu Administrador.");
        while ($ln  = mysqli_fetch_array($rs)) {
            $RecCash = (float) $ln['vlrec'];
            $ValRec  = $ValRec + $RecCash;
        }

        // Avaliando Despesas
        $sql = "select vlrec from registro where tiporec = '8' and estorno = '' and datarec = '$dataH' ";
        $rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #3. Contate seu Administrador.");
        while ($ln  = mysqli_fetch_array($rs)) {
            $RecDesp = (float) $ln['vlrec'];
            $ValDesp  = $ValDesp + $RecDesp;
        }

        // Avaliando Depósitos
        $sql = "select valor from depositos where dtdep = '$dataH' ";
        $rs  = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #4. Contate seu Administrador.");
        while ($ln  = mysqli_fetch_array($rs)) {
            $Deposito = $Deposito + (float) $ln['valor'];
        }

        $ValorAc = $Gaveta + $Cash + $ValRec - $Deposito - $ValDesp;
        $precisaRecolher = ($ValorAc >= $Recolh);
        ?>

        <table width='100%' border='0' cellpadding='0' cellspacing='0'<?php if ($precisaRecolher) { ?> style="height: 70vh;"<?php } ?>>
            <tr>
                <?php if ($precisaRecolher) { ?>
                <td align="center" style="vertical-align: middle;">
                    <div style="text-align: center;">
                        <font color="gold" size='6'><b><i>
                                    <blink>&quot; <u>FAÇA O RECOLHIMENTO DO CAIXA!!!</u> &quot;</blink>
                                </i></b></font>
                        <br><br>
                        <a href="deposito.php?c_s=<?php echo $lg_user; ?>">
                            <button type="button">Recolhimento</button>
                        </a>
                        <a href="index.php?c_s=<?php echo $lg_user; ?>">
                            <button type="button">Retornar</button>
                        </a>
                    </div>
                </td>
                <?php } else { ?>
                <td>
                    <a href="http://localhost/caixa/menu.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"
                            width="120" border="0" align="top"></a>
                </td>
                <td align="center">
                    <font color="gold" size="6"><b><i><u>RECEBIMENTOS</u></i></b></font>
                </td>
                <td align="right">
                    <a href="http://localhost/caixa/menu.php?c_s=<?php echo $lg_user; ?>">
                        <img src="./images/voltar.gif" width="120" border="0" align="top">
                    </a>
                </td>
                <?php } ?>
            </tr>
        </table>

        <?php if (!$precisaRecolher) { ?>
        <br><br>
        <table border='0' cellpadding='10' cellspacing='0' align="center">
            <tr>
                <td>
                    <table border='10' cellpadding='10' cellspacing='0'>
                        <tr>
                            <td align='center'>
                                <a href="contrentr.php?c_s=<?php echo $lg_user ?>"><img src="./images/contrentr.gif"
                                        width="150" border="0" align="top"></a>
                            </td>
                            <td align='center'>
                                <a href="contrparc.php?c_s=<?php echo $lg_user ?>"><img src="./images/contrparc.gif"
                                        width="150" border="0" align="top"></a>
                            </td>
                        
                            <td align='center'>
                                <a href="propentr.php?c_s=<?php echo $lg_user; ?>"><img src="./images/propentr.gif"
                                        width="150" border="0" align="top"></a>
                            </td>
                        </tr>

                        <tr>
                            <td align='center'>
                                <a href="taxaprod.php?c_s=<?php echo $lg_user; ?>"><img src="./images/txprod.gif"
                                        width="150" border="0" align="top"></a>
                            </td>
                            <td align='center'>
                                <a href="inscconcur.php?c_s=<?php echo $lg_user; ?>"><img src="./images/inscconc.gif"
                                        width="150" border="0" align="top"></a>
                            </td>
                            <td align='center'>
                                <a href="prods.php?c_s=<?php echo $lg_user; ?>"><img src="./images/pgtos.gif" width="150"
                                        border="0" align="top"></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><br>
        <?php } ?>
    <?php

        // Fechando a Conexão
        mysqli_free_result($rs);
        include '../rodapext.php';
    } else { ?>
        <br><br><br>
        <font size="6"><b>
                <i>
                    <center>Acesso <font color="gold">
                            <blink>Não Autorizado</blink>
                            <font color="#FFFFFF">!!!
                    </center>
                </i></b></font>
        <br><br>
        <center>
            <a href="http://localhost/caixa/menu.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
        </center><br>
    <?php }

    $SisRot = "S-7.2";
    mysqli_close($conec);
    mysqli_close($conec_digital); ?>

</body>

</html>
