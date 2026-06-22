<?php
header('Content-Type: application/json; charset=UTF-8');

include "conexao.php";
include "dbselect.php";

function responder($dados)
{
	echo json_encode($dados, JSON_UNESCAPED_UNICODE);
	exit;
}

if (!$conec) {
	responder(array(
		'sucesso' => false,
		'mensagem' => 'Não foi possível conectar ao banco de dados.'
	));
}

$registro = isset($_GET['registro']) ? trim($_GET['registro']) : '';
$dataConsulta = isset($_GET['data']) ? trim($_GET['data']) : '';

if ($registro === '' || !ctype_digit($registro)) {
	responder(array(
		'sucesso' => false,
		'mensagem' => 'Informe um número de registro válido.'
	));
}

$dataValida = DateTime::createFromFormat('!Y-m-d', $dataConsulta);
if (!$dataValida || $dataValida->format('Y-m-d') !== $dataConsulta) {
	responder(array(
		'sucesso' => false,
		'mensagem' => 'Informe uma data válida para consultar o registro.'
	));
}

$sql = "SELECT
			reg,
			numdoc,
			subtipo,
			GROUP_CONCAT(DISTINCT modpgto ORDER BY modpgto) AS formas_pagamento,
			SUM(vlrec) AS valor_total,
			MAX(cliente) AS cliente
		FROM registro
		WHERE reg = ?
			AND datarec = ?
			AND tiporec <> '8'
			AND tiporec <> 'E'
			AND (estorno IS NULL OR estorno = '')
		GROUP BY reg, numdoc, subtipo
		LIMIT 1";

$stmt = mysqli_prepare($conec, $sql);
if (!$stmt) {
	responder(array(
		'sucesso' => false,
		'mensagem' => 'Não foi possível preparar a consulta.'
	));
}

$registroNumero = intval($registro);
mysqli_stmt_bind_param($stmt, 'is', $registroNumero, $dataConsulta);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$dados = $resultado ? mysqli_fetch_assoc($resultado) : null;
mysqli_stmt_close($stmt);

if (!$dados) {
	$dataMensagem = $dataValida->format('d/m/Y');
	responder(array(
		'sucesso' => false,
		'mensagem' => 'Registro não encontrado em ' . $dataMensagem . ', estornado ou impróprio para reembolso.'
	));
}

$cliente = trim($dados['cliente']);
if ($cliente === '') {
	responder(array(
		'sucesso' => false,
		'mensagem' => 'O registro não possui o nome do cliente.'
	));
}

$subtipo = strtoupper(trim($dados['subtipo']));
$formasPagamento = explode(',', (string) $dados['formas_pagamento']);
$somentePix = count($formasPagamento) > 0;

foreach ($formasPagamento as $formaPagamento) {
	if ($formaPagamento !== '70' && $formaPagamento !== '71') {
		$somentePix = false;
		break;
	}
}

if ($somentePix) {
	$siglaReferente = 'DVP';
	$referente = 'Devolução PIX';
} elseif ($subtipo === 'TXP' || $subtipo === 'TXPG') {
	$siglaReferente = 'TXP';
	$referente = 'Taxa Produção';
} elseif ($subtipo === 'CNTE') {
	$siglaReferente = 'CNTE';
	$referente = 'Contrato Entrada';
} elseif ($subtipo === 'CNTP') {
	$siglaReferente = 'CAR';
	$referente = 'Carnê';
} else {
	$siglaReferente = 'CVD';
	$referente = 'Cancelamento de Venda';
}

$valor = number_format((float) $dados['valor_total'], 2, '.', '');

responder(array(
	'sucesso' => true,
	'registro' => (string) $dados['reg'],
	'documento' => trim($dados['numdoc']),
	'valor' => $valor,
	'valor_formatado' => number_format((float) $dados['valor_total'], 2, ',', '.'),
	'cliente' => $cliente,
	'referente' => $referente,
	'sigla_referente' => $siglaReferente
));
