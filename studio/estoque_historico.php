<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('historico');
estoqueDemoCabecalho('Histórico do estoque', 'historico');
?>

<div class="card border-0 shadow-sm">
    <div class="card-body border-bottom">
        <div class="row g-2 align-items-end">
            <div class="col-md-4"><label class="form-label">Item</label><input class="form-control form-control-sm" placeholder="Código ou nome"></div>
            <div class="col-md-2"><label class="form-label">Tipo</label><select class="form-select form-select-sm"><option>Todos</option><option>Entrada</option><option>Saída</option><option>Ajuste</option></select></div>
            <div class="col-md-2"><label class="form-label">Origem</label><select class="form-select form-select-sm"><option>Todas</option><option>Compra</option><option>Venda</option><option>Consumo interno</option></select></div>
            <div class="col-md-2"><label class="form-label">Data inicial</label><input type="date" class="form-control form-control-sm" value="2026-06-01"></div>
            <div class="col-md-2"><button class="btn btn-outline-primary btn-sm w-100" data-demo-action="Filtrar histórico"><i class="bi bi-search me-1"></i>Filtrar</button></div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead><tr><th>Data/Hora</th><th>Item</th><th>Tipo</th><th>Origem</th><th>Qtd.</th><th>Anterior</th><th>Posterior</th><th>Usuário</th><th></th></tr></thead>
            <tbody>
                <tr><td>21/06/2026 15:10</td><td>Detergente neutro</td><td><span class="badge text-bg-danger">Saída</span></td><td>Consumo interno</td><td>1 FR</td><td>19</td><td>18</td><td>Administrador</td><td><button class="btn btn-outline-primary btn-sm" data-demo-action="Visualizar movimentação"><i class="bi bi-eye"></i></button></td></tr>
                <tr><td>21/06/2026 10:22</td><td>Sacola personalizada</td><td><span class="badge text-bg-danger">Saída</span></td><td>Solicitação SOL-0098</td><td>25 UN</td><td>275</td><td>250</td><td>Administrador</td><td><button class="btn btn-outline-primary btn-sm" data-demo-action="Visualizar movimentação"><i class="bi bi-eye"></i></button></td></tr>
                <tr><td>20/06/2026 17:40</td><td>Shampoo profissional</td><td><span class="badge text-bg-success">Entrada</span></td><td>Compra NF 4587</td><td>5 UN</td><td>0</td><td>5</td><td>Administrador</td><td><button class="btn btn-outline-primary btn-sm" data-demo-action="Visualizar movimentação"><i class="bi bi-eye"></i></button></td></tr>
                <tr><td>20/06/2026 16:05</td><td>Shampoo profissional</td><td><span class="badge text-bg-warning">Ajuste</span></td><td>Inventário</td><td>−2 UN</td><td>5</td><td>3</td><td>Auditoria</td><td><button class="btn btn-outline-primary btn-sm" data-demo-action="Visualizar movimentação"><i class="bi bi-eye"></i></button></td></tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <span class="small text-muted">4 movimentações fictícias</span>
        <button class="btn btn-outline-secondary btn-sm" data-demo-action="Exportar histórico"><i class="bi bi-filetype-csv me-1"></i>Exportar CSV</button>
    </div>
</div>

<?php estoqueDemoRodape(); ?>
