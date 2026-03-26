<?php
// 1. Garantir que nenhum output é enviado antes dos headers
if (ob_get_contents()) ob_end_clean();

// 2. Definir headers JSON primeiro
header('Content-Type: application/json; charset=utf-8');

// 3. Configuração de erros (apenas para desenvolvimento)
error_reporting(E_ALL);
ini_set('display_errors', 1); // Não mostrar erros na tela
ini_set('log_errors', 1);

// 4. Incluir arquivos necessários com verificação
$required_files = [
    './conexao.php',
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

// 7. Validar comprimento mínimo
if (strlen($term) < 2) {
    die(json_encode([]));
}

try {
    // 8. Preparar consulta SQL segura
    if ($tipo === 'matricula') {
        // Busca por matrícula
        $sql = "SELECT mat, nome FROM pessoal WHERE mat LIKE CONCAT(?, '%') ORDER BY mat LIMIT 10";
    } else {
        // Busca por nome (padrão/vendedora)
        $sql = "SELECT mat, nome FROM pessoal WHERE nome LIKE CONCAT('%', ?, '%') ORDER BY nome LIMIT 10";
    }
    
    $stmt = $conec->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro na preparação: " . $conec->error);
    }
    
    // 9. Bind parameters e executar
    $stmt->bind_param("s", $term);
    if (!$stmt->execute()) {
        throw new Exception("Erro na execução: " . $stmt->error);
    }
    
    // 10. Obter resultados
    $result = $stmt->get_result();
    $nomes = [];
    $mat_vend = [];
    
    while ($row = $result->fetch_assoc()) {
        $nomes[] = $row['nome'];
        $mat_vend[] = $row['mat'];
    }
    
    // 11. Fechar statement
    $stmt->close();
    
    // 12. Retornar resultados
    die(json_encode(['nomes' => $nomes, 'mat_vend' => $mat_vend]));
    
} catch (Exception $e) {
    // 13. Log do erro
    error_log("Erro em buscar_funcionarias.php: " . $e->getMessage());
    
    // 14. Retornar erro em JSON
    die(json_encode(['error' => 'Erro ao processar requisição']));
}



?>