<?php

if (session_status() !== PHP_SESSION_ACTIVE && !session_start()) {
	http_response_code(500);
	exit('Não foi possível carregar a mensagem do sistema.');
}

$token = $_GET['token'] ?? '';
$continuationForm = '';
if (is_string($token) && preg_match('/\A[a-f0-9]{64}\z/', $token)) {
	$notice = 'duplicate';
	$continuations = $_SESSION['processed_gera_continuations'] ?? [];
	if (is_array($continuations) && isset($continuations[$token]['form']) && is_string($continuations[$token]['form'])) {
		$continuationForm = $continuations[$token]['form'];
	}
} else {
	$notice = $_SESSION['post_once_message'] ?? 'invalid';
	unset($_SESSION['post_once_message']);
}
session_write_close();

$messages = [
	'duplicate' => [
		'title' => $continuationForm !== '' ? 'Lançamento já gravado' : 'Envio já processado',
		'text' => $continuationForm !== ''
			? 'O lançamento já foi gravado. Continue pela etapa abaixo para concluir a autenticação e a impressão.'
			: 'Esta operação já foi registrada. O reenvio foi bloqueado para evitar duplicidade.',
		'instruction' => $continuationForm !== ''
			? 'Não reenvie o formulário de lançamento.'
			: 'A etapa de autenticação e impressão não está disponível nesta página. Não envie o lançamento novamente; solicite apoio ao administrador.',
	],
	'invalid' => [
		'title' => 'Formulário expirado',
		'text' => 'Não foi possível validar este envio.',
		'instruction' => 'Volte ao formulário, atualize a página e tente novamente.',
	],
];

$message = $messages[$notice] ?? $messages['invalid'];
?>
<!DOCTYPE html>
<html>

<head>
	<title>WebCaixa - <?php echo htmlspecialchars($message['title'], ENT_QUOTES, 'UTF-8'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin: 3%;
			border: 3px solid gray;
			padding: 10px;
			font-family: sans-serif;
		}

		.aviso {
			font-size: 1.2em;
			margin: 30px auto;
			max-width: 760px;
			padding: 24px;
			text-align: center;
		}
	</style>
	<?php include __DIR__ . '/../cabecprs.php'; ?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php if ($notice === 'duplicate') { ?>
		<script>
			alert(<?php echo json_encode(
				$message['text'] . ' ' . $message['instruction'],
				JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
			); ?>);
		</script>
	<?php } ?>
	<main class="aviso">
		<h1><font color="gold"><?php echo htmlspecialchars($message['title'], ENT_QUOTES, 'UTF-8'); ?></font></h1>
		<p><?php echo htmlspecialchars($message['text'], ENT_QUOTES, 'UTF-8'); ?></p>
		<p><?php echo htmlspecialchars($message['instruction'], ENT_QUOTES, 'UTF-8'); ?></p><br>
		<hr>
		<?php if ($continuationForm !== '') { ?>
			<?php echo $continuationForm; ?>
		<?php } elseif ($notice === 'invalid') { ?>
			<a href="javascript:history.back()">
				<img src="./images/voltar.gif" alt="Voltar">
			</a>
		<?php } ?>
	</main>
</body>

</html>
