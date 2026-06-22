<?php
require_once __DIR__ . '/estoque_demo_base.php';

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'status' => true,
    'demo' => true,
    'mensagem' => 'Serviço fictício do estoque disponível somente para prototipação.',
    'itens' => array_values($estoqueItensDemo),
], JSON_UNESCAPED_UNICODE);

