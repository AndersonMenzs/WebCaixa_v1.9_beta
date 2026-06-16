<?php

if (!function_exists('caixa_normalizar_data')) {
	function caixa_normalizar_data($data)
	{
		$data = trim((string) $data);

		if ($data == '' or $data == '0000-00-00' or $data == '00000000') {
			return '';
		}

		if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $data)) {
			return $data;
		}

		if (preg_match('/^[0-9]{8}$/', $data)) {
			return substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2);
		}

		if (preg_match('/^[0-9]{6}$/', $data)) {
			return '20' . substr($data, 0, 2) . '-' . substr($data, 2, 2) . '-' . substr($data, 4, 2);
		}

		$timestamp = strtotime($data);

		if ($timestamp === false) {
			return '';
		}

		return date('Y-m-d', $timestamp);
	}
}

if (!function_exists('caixa_formatar_data_br')) {
	function caixa_formatar_data_br($data)
	{
		$data = caixa_normalizar_data($data);

		if ($data == '') {
			return '';
		}

		return substr($data, 8, 2) . '/' . substr($data, 5, 2) . '/' . substr($data, 0, 4);
	}
}

if (!function_exists('caixa_anterior_aberto')) {
	function caixa_anterior_aberto($conec)
	{
		$hoje = date('Y-m-d');
		$sql = "select dtopen, dtclose from caixa where dtclose IS NULL order by dtopen asc";
		$rs = mysqli_query($conec, $sql) or die("Não foi possível verificar a situação do Caixa");

		while ($ln = mysqli_fetch_array($rs)) {
			$dtopen = caixa_normalizar_data($ln['dtopen']);

			if ($dtopen != '' and $dtopen < $hoje) {
				return array(
					'aberto' => true,
					'dtopen' => $dtopen,
					'dtopen_br' => caixa_formatar_data_br($dtopen),
					'dtclose' => $ln['dtclose']
				);
			}
		}

		return array(
			'aberto' => false,
			'dtopen' => '',
			'dtopen_br' => '',
			'dtclose' => ''
		);
	}
}

if (!function_exists('caixa_aberto_hoje')) {
	function caixa_aberto_hoje($conec)
	{
		$hoje = date('Y-m-d');
		$sql = "select dtopen, dtclose from caixa where dtclose IS NULL order by dtopen desc";
		$rs = mysqli_query($conec, $sql) or die("Não foi possível verificar a situação do Caixa");

		while ($ln = mysqli_fetch_array($rs)) {
			$dtopen = caixa_normalizar_data($ln['dtopen']);

			if ($dtopen == $hoje) {
				return true;
			}
		}

		return false;
	}
}

if (!function_exists('usuario_pode_registrar_movimento')) {
	function usuario_pode_registrar_movimento($conec)
	{
		$caixaAnterior = caixa_anterior_aberto($conec);

		if ($caixaAnterior['aberto']) {
			return false;
		}

		return caixa_aberto_hoje($conec);
	}
}

if (!function_exists('usuario_deve_ir_para_fechamento')) {
	function usuario_deve_ir_para_fechamento($conec)
	{
		$caixaAnterior = caixa_anterior_aberto($conec);

		return $caixaAnterior['aberto'];
	}
}

if (!function_exists('mostrar_bloqueio_caixa')) {
	function mostrar_bloqueio_caixa($lg_user, $dataCaixa)
	{
		$lg_user_html = htmlspecialchars($lg_user, ENT_QUOTES, 'UTF-8');
		$lg_user_url = urlencode($lg_user);
		$dataCaixa = htmlspecialchars($dataCaixa, ENT_QUOTES, 'UTF-8');

		if (!headers_sent()) {
			http_response_code(403);
		}
		?>
		<br><br><br>
		<br><br><br>
		<center>
			<font face="arial" color="gold" size="6"><b><i>Movimento Bloqueado</i></b></font><br><br>
			<font size="5">
				<b><i>
					Você não fechou o caixa do dia <?php echo $dataCaixa; ?>.<br>
					Feche o caixa anterior antes de registrar novos movimentos.
				</i></b>
			</font><br><br>

			<form method="post" action="fechacaixa.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user_html; ?>">
				<input type="submit" name="btenv" value="Fechar o Caixa">&nbsp;&nbsp;
				<input type="button" value="Sair" onclick="window.location.href='../index.php'">
			</form>
		</center>
		<br><br><br>
		<br><br><br>
		<?php
	}
}

if (!function_exists('bloquear_se_caixa_anterior_aberto')) {
	function bloquear_se_caixa_anterior_aberto($conec, $lg_user)
	{
		$caixaAnterior = caixa_anterior_aberto($conec);

		if (!$caixaAnterior['aberto']) {
			return;
		}

		mostrar_bloqueio_caixa($lg_user, $caixaAnterior['dtopen_br']);
		exit;
	}
}

?>
