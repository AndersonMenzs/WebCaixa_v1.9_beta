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
	$_SESSION['post_once_message'] = 'invalid';
	session_write_close();
	header('Location: post_once_message.php', true, 303);
	exit;
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
	session_write_close();
	header('Location: post_once_message.php?token=' . rawurlencode($submissionToken), true, 303);
	exit;
}

$usedTokens[$submissionToken] = $now;
$_SESSION['processed_gera_submissions'] = $usedTokens;

$outputBufferLevel = ob_get_level();
ob_start();
register_shutdown_function(function () use ($submissionToken, $outputBufferLevel, $tokenLifetime) {
	if (ob_get_level() > $outputBufferLevel) {
		$response = ob_get_contents();
		if (
			is_string($response) &&
			preg_match(
				'~<form\b(?=[^>]*\baction="via[[:alnum:]_-]+\.php")[^>]*>.*?</form\s*>~is',
				$response,
				$matches
			)
		) {
			$continuations = $_SESSION['processed_gera_continuations'] ?? [];
			if (!is_array($continuations)) {
				$continuations = [];
			}

			foreach ($continuations as $token => $continuation) {
				$createdAt = is_array($continuation) ? ($continuation['created_at'] ?? 0) : 0;
				if (!is_int($createdAt) || $createdAt < time() - $tokenLifetime) {
					unset($continuations[$token]);
				}
			}

			$continuations[$submissionToken] = [
				'created_at' => time(),
				'form' => $matches[0],
			];

			if (count($continuations) > 100) {
				uasort($continuations, function ($left, $right) {
					return ($left['created_at'] ?? 0) <=> ($right['created_at'] ?? 0);
				});
				$continuations = array_slice($continuations, -100, null, true);
			}

			$_SESSION['processed_gera_continuations'] = $continuations;
		}

		ob_end_flush();
	}

	if (session_status() === PHP_SESSION_ACTIVE) {
		session_write_close();
	}
});
