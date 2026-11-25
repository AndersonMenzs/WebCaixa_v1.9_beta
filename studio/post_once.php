<?php

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
	return;
}

if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
	http_response_code(500);
	exit('Não foi possível iniciar a sessão para validar este envio.');
}

$submissionToken = $_POST['submission_token'] ?? '';
if (!is_string($submissionToken) || !preg_match('/\A[a-f0-9]{64}\z/', $submissionToken)) {
	http_response_code(400);
	exit('Envio inválido. Volte ao formulário e tente novamente.');
}

$now = time();
$tokenLifetime = 86400;
$usedTokens = $_SESSION['processed_gera_submissions'] ?? [];
if (!is_array($usedTokens)) {
	$usedTokens = [];
}

foreach ($usedTokens as $token => $processedAt) {
	if (!is_int($processedAt) || $processedAt < $now - $tokenLifetime) {
		unset($usedTokens[$token]);
	}
}

if (isset($usedTokens[$submissionToken])) {
	http_response_code(409);
	header('Content-Type: text/html; charset=UTF-8');
	exit(
		'<!DOCTYPE html><html lang="pt-br"><meta charset="UTF-8"><title>Envio já processado</title>' .
		'<body><p>Este envio já foi processado. A repetição foi bloqueada para evitar duplicidade.</p>' .
		'<p>Para iniciar um novo lançamento, volte ao formulário e atualize-o antes de enviar.</p></body></html>'
	);
}

$usedTokens[$submissionToken] = $now;
$_SESSION['processed_gera_submissions'] = $usedTokens;
