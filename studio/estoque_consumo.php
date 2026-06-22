<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('movimentar');
estoqueDemoCabecalho('Consumo interno', 'movimentar');
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3"><h2 class="h5 text-info-emphasis mb-0">Registrar retirada para uso interno</h2></div>
    <div class="card-body">
        <form data-demo-form data-demo-message="Consumo fictício registrado. Nenhum saldo foi alterado.">
            <div class="row g-3">
                <div class="col-md-7">
                    <label class="form-label" for="item">Item *</label>
                    <select class="form-select" id="item" required>
                        <option value="">Selecione</option>
                        <?php foreach ($estoqueItensDemo as $item) { ?>
                            <option><?php echo htmlspecialchars($item['codigo'] . ' — ' . $item['nome'] . ' · saldo ' . $item['quantidade'] . ' ' . $item['unidade']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="quantidade">Quantidade *</label>
                    <input type="number" class="form-control" id="quantidade" min=".01" step=".01" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="setor">Setor *</label>
                    <select class="form-select" id="setor" required>
                        <option value="">Selecione</option><option>Administração</option><option>Atendimento</option>
                        <option>Caixa</option><option>Limpeza</option><option>Produção</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="solicitante">Funcionário solicitante *</label>
                    <input class="form-control" id="solicitante" value="Funcionário de demonstração" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="autorizador">Autorizado por *</label>
                    <input class="form-control" id="autorizador" value="Administrador" required>
                </div>
                <div class="col-12">
                    <label class="form-label" for="motivo">Motivo da retirada *</label>
                    <textarea class="form-control" id="motivo" rows="3" required></textarea>
                </div>
            </div>
            <div class="alert alert-warning mt-4 mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Na versão integrada, esta confirmação criará uma saída e atualizará o saldo na mesma transação.
            </div>
            <button class="btn btn-outline-success btn-sm mt-4" type="submit"><i class="bi bi-check-lg me-1"></i>Confirmar retirada</button>
        </form>
    </div>
</div>

<?php estoqueDemoRodape(); ?>

