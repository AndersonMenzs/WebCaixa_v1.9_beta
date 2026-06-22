<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('movimentar');
$itemSelecionado = (int) ($_GET['item'] ?? 1);
estoqueDemoCabecalho('Movimentar estoque', 'movimentar');
?>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3"><h2 class="h5 text-info-emphasis mb-0">Nova movimentação</h2></div>
            <div class="card-body">
                <form data-demo-form data-demo-message="Movimentação fictícia registrada. O saldo real não foi alterado.">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label" for="item">Item *</label>
                            <select class="form-select" id="item" required>
                                <?php foreach ($estoqueItensDemo as $item) { ?>
                                    <option value="<?php echo $item['id']; ?>" <?php echo $itemSelecionado === $item['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($item['codigo'] . ' — ' . $item['nome'] . ' (' . $item['quantidade'] . ' ' . $item['unidade'] . ')'); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="tipo">Tipo *</label>
                            <select class="form-select" id="tipo" required>
                                <option>Entrada</option>
                                <option>Saída</option>
                                <option>Ajuste</option>
                                <option>Devolução</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="origem">Origem *</label>
                            <select class="form-select" id="origem" required>
                                <option>Compra</option><option>Consumo interno</option><option>Perda</option>
                                <option>Descarte</option><option>Inventário</option><option>Devolução</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="quantidade">Quantidade *</label>
                            <input type="number" class="form-control" id="quantidade" min=".01" step=".01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="documento">Documento/Referência</label>
                            <input class="form-control" id="documento" placeholder="Ex.: NF 4587">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="setor">Setor de destino</label>
                            <select class="form-select" id="setor">
                                <option value="">Não se aplica</option><option>Administração</option>
                                <option>Atendimento</option><option>Caixa</option><option>Limpeza</option><option>Produção</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="responsavel">Responsável pela retirada</label>
                            <input class="form-control" id="responsavel">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="observacao">Motivo/Observação *</label>
                            <textarea class="form-control" id="observacao" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-check-lg me-1"></i>Registrar</button>
                        <button class="btn btn-outline-secondary btn-sm" type="reset">Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6 text-info-emphasis">Regras da movimentação</h2>
                <ul class="small text-muted mb-0">
                    <li class="mb-2">O saldo nunca será alterado diretamente no cadastro.</li>
                    <li class="mb-2">Saídas não poderão deixar o estoque negativo.</li>
                    <li class="mb-2">Correções serão feitas por nova movimentação.</li>
                    <li>Usuário, data, saldo anterior e posterior serão registrados.</li>
                </ul>
            </div>
        </div>
        <a class="btn btn-outline-primary btn-sm w-100 mt-3" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_consumo.php')); ?>">Abrir consumo interno</a>
    </div>
</div>

<?php estoqueDemoRodape(); ?>

