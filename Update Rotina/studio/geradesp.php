'<html>

<head>
	<title>WebCaixa v1.20.14_beta</title>
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
	include "./valor_ext.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R3.1.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Cod       = trim($_POST['txtcod']);
	$Cod2      = trim($_POST['txtcod2']);
	$TipoDesp  = trim($_POST['txttipodesp']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF = number_format($Valor, 2, ",", ".");
	$Valor_ext    = valorPorExtenso($ValorF);
	$FPag      = trim($_POST['txtmodpag']);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$colab		= trim($_POST['colab']);
	$mat_vend	= trim($_POST['mat_vend']);
	$cliente	= trim($_POST['cliente']);
	$Senha     = sha1($Pass);
	$TipoRec   = '8';
	$TipoDoc = trim($_POST['tipodoc']);
	$TipoRef = trim($_POST['tiporef']);
	$cod_TipoRef = trim($_POST['cod_TipoRef'] ?? '');
	$NomeDesc = trim($_POST['nomedesc']);

	// Inicializações para evitar avisos/erros caso não existam valores
	$hora = date('H:i');
	$PC = trim($_POST['pc']);

	$UltDoc_ci = '';
	$UltDoc_dp = '';
	$UltDoc_rc = '';
	$UltDoc_mc = '';
	$UltDoc_md = '';
	$UltDoc_mp = '';
	$UltDoc_vt = '';
	$UltDoc_sp = '';
	$UltDoc_out = '';

	include "conexao.php";
	include "dbselect.php";

	// Obtendo a Sigla de Pagamento
	$sql = "select * from pgtos where codpag = '$TipoDesp' ";
	$rs  = mysqli_query($conec, $sql);
	$ln  = mysqli_fetch_array($rs);
	$SubTipo = $ln['siglapag'];
	mysqli_free_result($rs);

	// Obtendo Dados
	$sqlo = "select * from operador where pass = '$Senha' ";
	$rso  = mysqli_query($conec, $sqlo);
	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Registro</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm') {
		if ($regso > 0) {
			$lno  = mysqli_fetch_array($rso);
			$Mat = $lno['mat'];

			// Gravando o Registro
			$sqlr = "select * from registro order by datarec desc, reg desc";
			$rsr  = mysqli_query($conec, $sqlr) or die("Não foi possível acessar os Dados");
			$regsr = mysqli_num_rows($rsr);
			$lnr = mysqli_fetch_array($rsr);
			$Reg     = $lnr['reg'];
			$dtReceb = $lnr['datarec'];

			if ($regsr == 0 or $dtComp <> $dtReceb) {
				$Reg = 0;
			}
			$Reg  = $Reg + 1;

			// Despesa DP
			if ($TipoDoc == 'DDP') {
				$TipoDoc = 'CI';

				// Recebendo o próximo número de registro DP
				$sqlr_ci = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr_ci  = mysqli_query($conec, $sqlr_ci) or die(" Não foi possível acessar os Dados");
				$regsr_ci = mysqli_num_rows($rsr_ci);
				$lnr_ci = mysqli_fetch_array($rsr_ci);
				$UltDoc_dp = $lnr_ci['numdoc'];

				if ($regsr_ci > 0) {
					$codigo_atual = $UltDoc_dp;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_dp = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}
			
			// Reembolso de Cliente
			if ($TipoDoc == 'RCL') {
				$TipoDoc = 'RC';

				// Recebendo o próximo número de registro Reembolso Cliente
				$sql_rc = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr  = mysqli_query($conec, $sql_rc) or die(" Não foi possível acessar os Dados");
				$regsr_rc = mysqli_num_rows($rsr);
				$lnr_rc = mysqli_fetch_array($rsr);
				$UltDoc_rc = $lnr_rc['numdoc'];

				if ($regsr_rc > 0) {
					$codigo_atual = $UltDoc_rc;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_rc = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}

			// Material de Consumo
			if ($TipoDoc == 'MCS') {
				$TipoDoc = 'MC';

				$sql_mc = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr  = mysqli_query($conec, $sql_mc) or die(" Não foi possível acessar os Dados");
				$regsr_mc = mysqli_num_rows($rsr);
				$lnr_mc = mysqli_fetch_array($rsr);
				$UltDoc_mc = $lnr_mc['numdoc'];

				if ($regsr_mc > 0) {
					$codigo_atual = $UltDoc_mc;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_mc = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}

			// Material de Divulgação
			if ($TipoDoc == 'MDV') {
				$TipoDoc = 'MD';

				$sql_md = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr  = mysqli_query($conec, $sql_md) or die(" Não foi possível acessar os Dados");
				$regsr_md = mysqli_num_rows($rsr);
				$lnr_md = mysqli_fetch_array($rsr);
				$UltDoc_md = $lnr_md['numdoc'];

				if ($regsr_md > 0) {
					$codigo_atual = $UltDoc_md;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_md = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}

			// Material de Produção
			if ($TipoDoc == 'MPD') {
				$TipoDoc = 'MP';

				// Recebendo o próximo número de registro Material de Produção
				$sqlr_mp = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr_mp  = mysqli_query($conec, $sqlr_mp) or die(" Não foi possível acessar os Dados");
				$regsr_mp = mysqli_num_rows($rsr_mp);
				$lnr_mp = mysqli_fetch_array($rsr_mp);
				$UltDoc_mp = $lnr_mp['numdoc'];

				if ($regsr_mp > 0) {
					$codigo_atual = $UltDoc_mp;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_mp = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}

			// Vale Transporte
			if ($TipoDoc == 'VTR') {
				$TipoDoc = 'VT';

				// Recebendo o próximo número de registro Vale Transporte
				$sqlr_vt = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr_vt  = mysqli_query($conec, $sqlr_vt) or die(" Não foi possível acessar os Dados");
				$regsr_vt = mysqli_num_rows($rsr_vt);
				$lnr_vt = mysqli_fetch_array($rsr_vt);
				$UltDoc_vt = $lnr_vt['numdoc'];

				if ($regsr_vt > 0) {
					$codigo_atual = $UltDoc_vt;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_vt = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}

			// Serviços Prestados
			if ($TipoDoc == 'SRV') {
				$TipoDoc = 'SP';

				// Recebendo o próximo número de registro Serviços Prestados
				$sqlr_sp = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr_sp  = mysqli_query($conec, $sqlr_sp) or die(" Não foi possível acessar os Dados");
				$regsr_sp = mysqli_num_rows($rsr_sp);
				$lnr_sp = mysqli_fetch_array($rsr_sp);
				$UltDoc_sp = $lnr_sp['numdoc'];

				if ($regsr_sp > 0) {
					$codigo_atual = $UltDoc_sp;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_sp = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}

			// Outros
			if ($TipoDoc == 'OUT') {
				$TipoDoc = 'OT';

				// Recebendo o próximo número de registro Outros
				$sqlr_out = "select numdoc from registro where numdoc like '$TipoDoc%' order by numdoc desc";
				$rsr_out  = mysqli_query($conec, $sqlr_out) or die(" Não foi possível acessar os Dados");
				$regsr_out = mysqli_num_rows($rsr_out);
				$lnr_out = mysqli_fetch_array($rsr_out);
				$UltDoc_out = $lnr_out['numdoc'];

				if ($regsr_out > 0) {
					$codigo_atual = $UltDoc_out;
					$prefixo = substr($codigo_atual, 0, 2);
					$numero = substr($codigo_atual, 2);
					$novo_numero = intval($numero) + 1;
					$UltDoc_out = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				}
			}

			// Condições para atribuir o número do documento correto
			if ($TipoDesp == '1') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_dp', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '', '', '')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '2') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_mc', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '3') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_md', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '4') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_mp', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '5') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_rc', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '7') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_vt', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '6') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_sp', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '8') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_out', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			// Preparando a Via Cliente 
	?>
			<form name="geraprod" method="post" action="via1newpag.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="txtsen" value="<?php echo $PC; ?>">
				<input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
				<input type="hidden" name="txtcod" value="<?php echo $Cod; ?>">
				<input type="hidden" name="txtcod2" value="<?php echo $Cod2; ?>">
				<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
				<input type="hidden" name="formapag" value="<?php echo $FPag; ?>">
				<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
				<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
				<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
				<input type="hidden" name="txtvalor_ext" value="<?php echo $Valor_ext; ?>">
				<input type="hidden" name="tipodoc" value="<?php echo $TipoDoc; ?>">
				<input type="hidden" name="txttipodesp" value="<?php echo $TipoDesp; ?>">
				<input type="hidden" name="tiporef" value="<?php echo $TipoRef; ?>">
				<input type="hidden" name="cod_TipoRef" value="<?php echo $cod_TipoRef; ?>">
				<input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
				<input type="hidden" name="mat_vend" value="<?php echo $mat_vend; ?>">
				<input type="hidden" name="ultdoc_dp" value="<?php echo $UltDoc_dp; ?>">
				<input type="hidden" name="ultdoc_ci" value="<?php echo $UltDoc_ci; ?>">
				<input type="hidden" name="ultdoc_rc" value="<?php echo $UltDoc_rc; ?>">
				<input type="hidden" name="ultdoc_md" value="<?php echo $UltDoc_md; ?>">
				<input type="hidden" name="ultdoc_mc" value="<?php echo $UltDoc_mc; ?>">
				<input type="hidden" name="ultdoc_mp" value="<?php echo $UltDoc_mp; ?>">
				<input type="hidden" name="ultdoc_vt" value="<?php echo $UltDoc_vt; ?>">
				<input type="hidden" name="ultdoc_sp" value="<?php echo $UltDoc_sp; ?>">
				<input type="hidden" name="ultdoc_out" value="<?php echo $UltDoc_out; ?>">
				<input type="hidden" name="txtcolab" value="<?php echo $colab; ?>">
				<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
				<input type="hidden" name="nomedesc" value="<?php echo $NomeDesc; ?>">
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
					<input id="ghost_click" type="submit" name="btimprime" value="Registrar" autofocus>
				</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form>
		<?php

		} else {
		?>
			<font size='6'><b>
					<center>Senha <font color='gold'>
							<blink>Incorreta</blink><br>
							<font color='#FFFFFF'>ou<br>
								Usuário <font color='gold'>
									<blink>Não Autorizado</blink>
									<font color="#FFFFFF">!!!</center>
				</b></font><br>
			<center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br>
	<?php
		}
	}

	// Encerrando a Conexão
	$SisRot = "S-7.3.1.1.1";
	include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
