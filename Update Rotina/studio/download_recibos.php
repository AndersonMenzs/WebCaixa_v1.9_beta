<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>WebCaixa v1.20.19_beta</title>
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

    // Conexão
    include_once './conexao.php';
    include_once './conexao_web.php';

    // Inserindo o Cabeçalho
    include "../cabecprs.php";

    // Obtendo so Dados do Usuário
    $Sis     = "Off-2.3";
    $lg_user = $_REQUEST['c_s'];
    $user  = substr($lg_user, 0, 8);
    $pss   = substr($lg_user, 8, 40);

    ?>

<body background="../images/bg1.jpg" text="#FFFFFF">

    <?php

    // Consulta os recibos disponíveis
    //$sql_A = "SELECT numEnv FROM tb_lotes_recibos WHERE codEnvStd = '220' AND dtcriado >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)";
    $sql_A = "SELECT numRec FROM tb_lotes_recibos WHERE codRecStd = '220' ";
    $res_A = mysqli_query($conec_web, $sql_A);

    if (mysqli_num_rows($res_A) > 0) {
        $recibos = array();
        while ($row = mysqli_fetch_assoc($res_A)) {
            $recibos[] = $row;
        }

        include_once './dbselect.php';

        // Inserir os recibos na tabela recibos
        $sql_B = "INSERT INTO num_recibos (numrec, status, operador, data_registro) VALUES (?, ?, ?, NOW())";
        $res_B = mysqli_prepare($conec, $sql_B);

        $status = '0'; // Status inicial dos recibos

        if ($res_B) {
            foreach ($recibos as $recibo) {
                $numRec = $recibo['numRec'];
                $operador = $user;
                mysqli_stmt_bind_param($res_B, "sss", $numRec, $status, $operador);
                mysqli_stmt_execute($res_B);
            }
            mysqli_stmt_close($res_B);
        }
    ?>

        <br><br><br><br><br><br><br><br>
        <font size='7' color='gold'>
            <center><b>DOWNLOAD DE LOTE DE RECIBOS</b></center>
        </font>
        <br><br>

        <font size='6'>
            <center><b><i>O lote de recibos foi inserido com sucesso.</i></b></center>
        </font>

        <br><br><br><br><br><br><br><br>
        <meta http-equiv="refresh" content="5;URL=index.php?c_s=<?php echo $lg_user; ?>">
    <?php
    } else {
    ?>
        <br><br><br><br><br><br><br><br>
        <font size='7' color='gold'>
            <center><b>DOWNLOAD DE LOTE DE RECIBOS</b></center>
        </font>
        <br><br>

        <font size='6'>
            <center><b><i>O lote de recibos não está disponível.</i></b></center>
        </font>

        <br><br><br><br><br><br><br><br>
        <meta http-equiv="refresh" content="5;URL=index.php?c_s=<?php echo $lg_user; ?>">
    <?php
    }

    ?>


    <?php
    // Encerrando a conexão
    mysqli_close($conec);
    mysqli_close($conec_web);


    $SisRot = "Off-2.3.1";
    include "../rodapext.php";
    ?>

</body>

</html>