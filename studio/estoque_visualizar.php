<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('visualizar');
$item = estoqueDemoItem((int) ($_GET['id'] ?? 1));
estoqueDemoCabecalho('Visualizar item', 'itens');
?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
        <div>
            <h2 class="h5 text-info-emphasis mb-1"><?php echo htmlspecialchars($item['nome']); ?></h2>
            <span class="text-muted"><?php echo htmlspecialchars($item['codigo']); ?></span>
        </div>
        <span class="status-badge status-<?php echo htmlspecialchars($item['situacao']); ?>">
            <span></span><?php echo htmlspecialchars(estoqueDemoStatus($item['situacao'])); ?>
        </span>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-8">
                <h3 class="h6 text-info-emphasis">Dados gerais</h3>
                <div class="row g-3">
                    <div class="col-sm-6"><div class="demo-detail"><span>Categoria</span><strong><?php echo htmlspecialchars($item['categoria']); ?></strong></div></div>
                    <div class="col-sm-6"><div class="demo-detail"><span>Finalidade</span><strong><?php echo htmlspecialchars($item['finalidade']); ?></strong></div></div>
                    <div class="col-sm-6"><div class="demo-detail"><span>Localização</span><strong><?php echo htmlspecialchars($item['localizacao']); ?></strong></div></div>
                    <div class="col-sm-6"><div class="demo-detail"><span>Validade</span><strong><?php echo htmlspecialchars($item['validade']); ?></strong></div></div>
                    <div class="col-12"><div class="demo-detail"><span>Descrição</span><strong><?php echo htmlspecialchars($item['descricao']); ?></strong></div></div>
                </div>
            </div>
            <div class="col-lg-4">
                <h3 class="h6 text-info-emphasis">Posição do estoque</h3>
                <div class="border rounded p-3 bg-light">
                    <div class="display-6 fw-semibold"><?php echo number_format($item['quantidade'], 0, ',', '.'); ?> <small class="fs-6 text-muted"><?php echo htmlspecialchars($item['unidade']); ?></small></div>
                    <div class="text-muted">Mínimo: <?php echo number_format($item['minimo'], 0, ',', '.'); ?> <?php echo htmlspecialchars($item['unidade']); ?></div>
                    <hr>
                    <div class="d-flex justify-content-between"><span>Custo</span><strong>R$ <?php echo number_format($item['custo'], 2, ',', '.'); ?></strong></div>
                    <div class="d-flex justify-content-between"><span>Venda</span><strong><?php echo $item['preco'] === null ? '—' : 'R$ ' . number_format($item['preco'], 2, ',', '.'); ?></strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3"><h2 class="h5 text-info-emphasis mb-0">Últimas movimentações</h2></div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead><tr><th>Data</th><th>Operação</th><th>Origem</th><th>Quantidade</th><th>Saldo</th><th>Usuário</th></tr></thead>
            <tbody>
                <tr><td>21/06/2026 15:10</td><td>Saída</td><td>Consumo interno</td><td class="text-danger">−1</td><td>18</td><td>Administrador</td></tr>
                <tr><td>20/06/2026 11:42</td><td>Saída</td><td>Solicitação SOL-0098</td><td class="text-danger">−2</td><td>19</td><td>Administrador</td></tr>
                <tr><td>18/06/2026 09:15</td><td>Entrada</td><td>Compra NF 4587</td><td class="text-success">+10</td><td>21</td><td>Administrador</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex flex-wrap gap-2 mt-4">
    <?php if (estoqueDemoPode('editar')) { ?>
        <a class="btn btn-outline-warning btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_editar.php', ['id' => $item['id']])); ?>"><i class="bi bi-pencil me-1"></i>Editar</a>
    <?php } ?>
    <?php if (estoqueDemoPode('solicitar')) { ?>
        <a class="btn btn-outline-success btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitar.php', ['item' => $item['id']])); ?>"><i class="bi bi-clipboard-plus me-1"></i>Solicitar</a>
    <?php } ?>
    <?php if (estoqueDemoPode('inativar')) { ?>
        <a class="btn btn-outline-danger btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_excluir.php', ['id' => $item['id']])); ?>"><i class="bi bi-trash me-1"></i>Inativar</a>
    <?php } ?>
    <a class="btn btn-outline-primary btn-sm ms-auto" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque.php')); ?>">Voltar à listagem</a>
</div>

<?php estoqueDemoRodape(); ?>
