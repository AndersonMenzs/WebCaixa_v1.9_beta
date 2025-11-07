<?php
header('Content-Type: application/json');

// Validação e sanitização da entrada
$txtdoc = isset($_GET['txtdoc']) ? trim($_GET['txtdoc']) : '';

if (empty($txtdoc) || strlen($txtdoc) !== 7) {
    echo json_encode(['erro' => 'Documento inválido']);
    exit;
}

// Conexão com o banco
include "conexao.php";
include "dbselect.php";

try {
    // Consulta preparada para evitar SQL Injection
    $sql = "SELECT COUNT(*) as total FROM registro WHERE numdoc = ?";
    $stmt = mysqli_prepare($conec, $sql);
    mysqli_stmt_bind_param($stmt, "s", $txtdoc);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultado);
    
    echo json_encode(['existe' => ($row['total'] > 0)]);
    
} catch (Exception $e) {
    echo json_encode(['erro' => 'Erro ao verificar documento']);
} finally {
    mysqli_close($conec);
}
?>