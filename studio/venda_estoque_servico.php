<?php
require_once __DIR__ . '/estoque_demo_base.php';

header('Content-Type: application/json; charset=utf-8');
http_response_code(501);
echo json_encode([
    'status' => false,
    'demo' => true,
    'mensagem' => 'Integração de vendas com estoque ainda não implementada.',
], JSON_UNESCAPED_UNICODE);

