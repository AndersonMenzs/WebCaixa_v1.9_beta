<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>WebCaixa v1.20.16_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            margin-top: 5%;
            margin-left: 5%;
            margin-right: 5%;
            border: 3px solid gray;
            padding: 10px 10px 10px 10px;
            font-family: sans-serif;
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

    // Conectando ao banco de dados
    include "./conexao.php";
    include "./dbselect.php";

    include "../cabecprs.php";

    // Obtendo o Login
    $Sis     = "S7";
    $Rot       = "S7R5.0";
    $lg_user   = $_REQUEST['c_s'];
    $user    = substr($lg_user, 0, 8);
    $mat1 = substr($user, 0, 1);
    $mat2 = substr($user, 1, 3);
    $mat3 = substr($user, 4, 3);
    $dv   = substr($user, 7, 1);
    $userF   = "$mat1.$mat2.$mat3-$dv";
    $pss     = substr($lg_user, 8, 40);
    $ch        = '';

    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    }

    if ($ch == 'ok-enc' or $ch == 'ok') {

        // Consulta  quantos recibos estão disponíveis
        $sql_A = "SELECT COUNT(numRec) FROM num_recibos WHERE status = '0' AND data_registro < NOW()";
        $res_A = mysqli_query($conec, $sql_A);
        $row_A = mysqli_fetch_array($res_A);
        $recibos = $row_A['COUNT(numRec)'];

        include "./dblog.php";

        // Consulta o colaborador responsável
        $sql_B = "SELECT nome FROM pessoal WHERE mat = '$user'";
        $res_B = mysqli_query($conec, $sql_B);
        $row_B = mysqli_fetch_array($res_B);
        $colaborador = $row_B['nome'];

        // Contato e texto da solicitação
        $numero = "21992120108";
        $solicitacao = "Olá, gostaria de solicitar a liberação de lote de recibos. Atualmente, há *$recibos recibos* disponíveis. Agradeço pela atenção e aguardo a liberação.\n\nAtenciosamente,\n$colaborador";

        include_once "./conexao_web.php";

        // Consulta se há recibos disponíveis no sistema web
        $sql_C = "SELECT * FROM tb_lotes_recibos_rel WHERE codRecStd = '220' AND status = '1' ORDER BY dtcriado DESC LIMIT 1";
        $res_C = mysqli_query($conec_web, $sql_C);

        if (mysqli_num_rows($res_C) > 0) {
            $row_C = mysqli_fetch_array($res_C);
            $recibos_web = $row_C['idRelRec'];
        } else {
            $recibos_web = 0;
        }
    ?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
    <br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td width=15% align='center'>
                <a href='index.php?c_s=<?php echo $lg_user; ?>'>
                    <img src='../images/voltar.gif' border='0'>
                </a>
            </td>
            <td width=70% align='center'>
                <center>
                    <font face="arial" color="gold" size="6">
                        <b>
                            <i>
                                <u>LOTE DE RECIBOS</u>
                            </i>
                        </b>
                    </font>
                </center><br>
            </td>
            <td width=15% align='center'>
                <a href='index.php?c_s=<?php echo $lg_user; ?>'>
                    <img src='../images/voltar.gif' border='0'>
                </a>
            </td>
        </tr>
    </table>
    <br><br>

    <?php

        if ($ch == 'ok' or $ch == 'ok-enc') {
    ?>
        <table border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td width="30%"></td>
                <td width="40%">
                    <a href="https://web.whatsapp.com/send?phone=55<?= $numero ?>&text=<?= urlencode($solicitacao) ?> " target="_blank" class="link">
                        <img src="./images/star4.gif" width="25" border="0" align="top" alt="Star">
                    </a>
                    <font size="4"><b><i>- Solicitação de Lote de Recibos</i></b></font>
                </td>
                <td width="25%"></td>
            </tr>
            <?php 
            if ($recibos < 20 AND $recibos_web > 0) { ?>
                <tr>
                    <td width="30%"></td>
                    <td width="40%">
                        <a href="download_recibos.php?c_s=<?php echo $lg_user; ?>">
                            <img src="./images/star4.gif" width="25" border="0" align="top" alt="Star">
                        </a>
                        <font size="4"><b><i>- Download de Lote de Recibos</i></b></font>
                    </td>
                    <td width="30%"></td>
                </tr>
        <?php } ?>
        </table>
        <br><br>

        <br><br>
        <center>
            <a href='index.php?c_s=<?php echo $lg_user; ?>'>
                <img src='../images/voltar.gif'>
            </a>
        </center>
        <br><br>
        <meta http-equiv="refresh" content="URL=./index.php?c_s=<?php echo $lg_user; ?>">
    <?php } else { ?>
        <br><br><br><br>
        <font size='5'><b>
                <center>Acesso <font color='gold'>
                        <blink><u>não Autorizado</u></blink>
                        <font color='#FFFFFF'>!!!</center>
            </b></font><br><br><br><br><br>
        <center><a href="./index.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a></center><br>
    <?php
    }
}

    // Encerrando
    $SisRot = "Off-2.5.1";
    include "../rodapext.php";
    ?>
</body>

</html>