<html>

<head>
	<title>WebCaixa v1.20.21_beta</title>
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

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}
	</style>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.1.1.1";
	$dtRec     = date('Y-m-d');
	$hora      = date('H:i');
	$lg_user   = isset($_POST['txtuser']) ? trim($_POST['txtuser']) : '';
	$lg_userEsc = htmlspecialchars($lg_user, ENT_QUOTES, 'UTF-8');
	$lg_userUrl = urlencode($lg_user);
	$user      = substr($lg_user, 0, 8);
	$pss       = substr($lg_user, 8, 40);
	$NDoc      = isset($_POST['txtdoc']) ? trim($_POST['txtdoc']) : '';
	$Mat_Vend  = isset($_POST['mat_vend']) ? trim($_POST['mat_vend']) : '';
	$Vendedora = isset($_POST['vendedora']) ? trim($_POST['vendedora']) : '';
	$Cliente   = isset($_POST['cliente']) ? trim($_POST['cliente']) : '';
	$CodBrinde = isset($_POST['cod_brinde']) ? trim($_POST['cod_brinde']) : '';
	$NomeBrinde = isset($_POST['nome_brinde']) ? trim($_POST['nome_brinde']) : '';
	$Senha     = sha1(strtolower(trim($_POST['txtsen'] ?? '')));

	if ($lg_user === '' || $NDoc === '' || $Mat_Vend === '' || $Vendedora === '' || $Cliente === '' || $CodBrinde === '' || $NomeBrinde === '') {
		header("Location: brindes.php?c_s=" . urlencode($lg_user));
		exit;
	}

	// Conexão
	include "conexao.php";
	include "dbselect.php";
	include "valida_caixa.php";

	bloquear_se_caixa_anterior_aberto($conec, $lg_user);

	// Obtendo Dados
	$userEsc = mysqli_real_escape_string($conec, $user);
	$senhaEsc = mysqli_real_escape_string($conec, $Senha);
	$sqlOperador = "SELECT mat FROM operador WHERE mat = '$userEsc' AND pass = '$senhaEsc' LIMIT 1";
	$rsOperador = mysqli_query($conec, $sqlOperador);
	$operador = $rsOperador ? mysqli_fetch_assoc($rsOperador) : null;

	if ($rsOperador) {
		mysqli_free_result($rsOperador);
	}

	?>
	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if (($ch === 'ok' || $ch === 'ok-enc' || $ch === 'ok-cai' || $ch === 'ok-adm') && $operador) {
		$Mat = $operador['mat'];

        $sqlUltimo = "SELECT reg, datarec FROM registro ORDER BY datarec DESC, reg DESC LIMIT 1";
        $rsUltimo = mysqli_query($conec, $sqlUltimo);
        $ultimo = $rsUltimo ? mysqli_fetch_assoc($rsUltimo) : null;
        if ($rsUltimo) {
            mysqli_free_result($rsUltimo);
        }
        $Reg = $ultimo && $ultimo['datarec'] === $dtRec ? (int)$ultimo['reg'] + 1 : 1;

        $TipoRec = '10';
        $SubTipo = 'BRIN';
        $MatVendEsc = mysqli_real_escape_string($conec, $Mat_Vend);
        $VendedoraEsc = mysqli_real_escape_string($conec, $Vendedora);
        $ClienteEsc = mysqli_real_escape_string($conec, $Cliente);
        $NDocEsc = mysqli_real_escape_string($conec, $NDoc);
        $MatEsc = mysqli_real_escape_string($conec, $Mat);
        $CodBrindeEsc = mysqli_real_escape_string($conec, $CodBrinde);
        $sqlBrinde = "SELECT cod_prod, nome_prod FROM produtos WHERE cod_prod = '$CodBrindeEsc' AND desc_prod = 'B' LIMIT 1";
        $resBrinde = mysqli_query($conec, $sqlBrinde) or die("Não foi possível localizar o brinde.");
        $brinde = mysqli_fetch_assoc($resBrinde);
        mysqli_free_result($resBrinde);

        if (!$brinde) {
            die("O brinde selecionado não está mais disponível.");
        }

        if (trim($brinde['nome_prod']) !== $NomeBrinde) {
            die("Os dados do brinde não correspondem ao produto selecionado.");
        }

        $sqlInsert = "INSERT INTO registro
        (reg, numdoc, tiporec, subtipo, modpgto, parcela, datarec, horarec, vlrec, operador, estorno, mat_vend, vendedora, cliente)
        VALUES
        ($Reg, '$NDocEsc', '$TipoRec', '$SubTipo', '99', '0', '$dtRec', '$hora', 0, '$MatEsc', '', '$MatVendEsc', '$VendedoraEsc', '$ClienteEsc')";

        if (!mysqli_query($conec, $sqlInsert)) {
            die("Erro ao registrar a gratuidade do brinde.");
        }

        ?>
        <form name="gerabrinde" method="post" action="via1newbrinde.php">
            <input type="hidden" name="txtuser" value="<?php echo $lg_userEsc; ?>">
            <input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
            <input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
            <input type="hidden" name="txtdoc" value="<?php echo htmlspecialchars($NDoc, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
            <input type="hidden" name="txthora" value="<?php echo $hora; ?>">
            <input type="hidden" name="txtmat" value="<?php echo htmlspecialchars($Mat, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="mat_vend" value="<?php echo htmlspecialchars($Mat_Vend, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="vendedora" value="<?php echo htmlspecialchars($Vendedora, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="cliente" value="<?php echo htmlspecialchars($Cliente, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="cod_brinde" value="<?php echo htmlspecialchars($CodBrinde, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="nome_brinde" value="<?php echo htmlspecialchars($NomeBrinde, ENT_QUOTES, 'UTF-8'); ?>">
            <p>
                <font size='6'><b>
                    <center>Verifique se a impressora do <font color='gold'>
                        <blink>Caixa</blink>
                        <font color='#FFFFFF'> está ligada e com papel.
                        <p>Logo após clique no <font color='gold'>
                            <blink>botão abaixo</blink>
                            <font color='#FFFFFF'>.</center>
                </b></font>
            </p><br>
            <center>
                <input id="ghost_click" type="submit" name="btimprime" value="Autenticar" autofocus>
            </center><br>
            <center>
                <font color='#FFFFFF' size='3'><span id="msg"></span></font>
            </center>
        </form>
        <?php
    } else {
        ?>
        <font size="6">
            <b><i>
                <center>Senha <font color="gold">
                    <blink>Incorreta</blink>
                    <font color="#FFFFFF">!!!</center>
            </i></b>
        </font><br>
        <center>
            <a href="JavaScript:window.history.back()"><img src="./images/voltar.gif" alt="Voltar"></a>
        </center><br>
        <?php
    }

    $SisRot = "S-7.2.1.1.1";
    include "rodape.php";
    mysqli_close($conec);
    ?>

    <script src="./js/ghost_click.js"></script>

</body>

</html>