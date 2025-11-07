<?php
// 1. Garantir que nenhum output é enviado antes dos headers
if (ob_get_contents()) ob_end_clean();

// 2. Definir headers JSON primeiro
header('Content-Type: application/json; charset=utf-8');

// 3. Configuração de erros (apenas para desenvolvimento)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Não mostrar erros na tela
ini_set('log_errors', 1);

// 4. Incluir arquivos necessários com verificação
$required_files = [
    './conexao.php',
    './dbselect.php',
    './dblog.php'
];

foreach ($required_files as $file) {
    if (!file_exists($file)) {
        die(json_encode(['error' => "Arquivo $file não encontrado"]));
    }
    require_once $file;
}
// 5. Verificar se a conexão foi estabelecida
if (!isset($conec) || !($conec instanceof mysqli)) {
    die(json_encode(['error' => 'Conexão com o banco de dados não está disponível']));
}

// 6. Validar e sanitizar inputs
$term = isset($_GET['term']) ? trim($_GET['term']) : '';
$tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';

if ($tipo === 'txtdoc') {
    // busca por contrato/recibo pelo número (ou parte dele) e retorna vendedora, cliente, mat_vend, numdoc
    if ($term === '' || strlen($term) < 1) {
        echo json_encode([]);
        exit;
    }

    // busca segura com LIKE
    $sql = "SELECT numdoc, mat_vend, vendedora, cliente
            FROM studio.registro
            WHERE numdoc LIKE CONCAT('%', ?, '%')
            AND subtipo IN ('CNTE')
            ORDER BY datarec DESC
            LIMIT 1";
            
    if ($stmt = $conec->prepare($sql)) {
        $stmt->bind_param('s', $term);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = [];
        while ($row = $res->fetch_assoc()) {
            $out[] = [
                'label' => ($row['numdoc']),
                'value' => $row['vendedora'],
                'numdoc' => $row['numdoc'],
                'vendedora' => $row['vendedora'],
                'cliente' => $row['cliente'],
                'mat' => $row['mat_vend']
            ];
        }
        $stmt->close();
        echo json_encode($out);
        exit;
    } else {
        error_log("Erro prepare buscar_numdoc txtdoc: " . $conec->error);
        echo json_encode(['error' => 'Erro ao preparar consulta']);
        $conec->close();
        exit;
    }
} else {
    // busca por nome nas funcionárias (comportamento anterior)
    if (strlen($term) < 2) {
        echo json_encode([]);
        exit;
    }

    $sql = "SELECT mat, nome, numdoc FROM cadfunc.pessoal WHERE nome LIKE CONCAT('%', ?, '%') ORDER BY nome LIMIT 10";
    if ($stmt = $conec->prepare($sql)) {
        $stmt->bind_param('s', $term);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = [];
        while ($row = $res->fetch_assoc()) {
            $out[] = [
                'label' => ($row['numdoc'] ? $row['numdoc'] . ' - ' . $row['nome'] : $row['nome']),
                'value' => $row['nome'],
                'mat' => $row['mat'],
                'numdoc' => $row['numdoc']
            ];
        }
        $stmt->close();
        echo json_encode($out);
    } else {
        error_log("Erro prepare buscar_numdoc nome: " . $conec->error);
        echo json_encode(['error' => 'Erro ao preparar consulta']);
        $conec->close();
        exit;
    }
}
$conec->close();
