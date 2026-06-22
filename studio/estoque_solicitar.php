<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('solicitar');
$itemSelecionado = (int) ($_GET['item'] ?? 0);
estoqueDemoCabecalho('Solicitar itens', 'solicitar');
?>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3"><h2 class="h5 text-info-emphasis mb-0">Nova solicitação</h2></div>
            <div class="card-body">
                <form data-demo-form data-demo-message="Solicitação fictícia SOL-2026-0104 enviada. Nenhum saldo foi alterado.">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label" for="setor">Setor solicitante *</label>
                            <select class="form-select" id="setor" required>
                                <option value="">Selecione</option><option>Administração</option><option>Atendimento</option>
                                <option>Caixa</option><option>Limpeza</option><option>Produção</option>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label" for="justificativa">Justificativa *</label>
                            <input class="form-control" id="justificativa" placeholder="Informe a finalidade dos materiais" required>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h6 text-info-emphasis mb-0">Itens solicitados</h3>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="adicionarItem"><i class="bi bi-plus-lg me-1"></i>Adicionar item</button>
                    </div>

                    <div id="itensSolicitacao">
                        <div class="row g-2 align-items-end solicitacao-item mb-2">
                            <div class="col-md-8">
                                <label class="form-label">Item *</label>
                                <select class="form-select" required>
                                    <option value="">Selecione</option>
                                    <?php foreach ($estoqueItensDemo as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php echo $itemSelecionado === $item['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($item['codigo'] . ' — ' . $item['nome'] . ' · disponível ' . $item['quantidade'] . ' ' . $item['unidade']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Quantidade *</label>
                                <input type="number" class="form-control" min=".01" step=".01" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-danger w-100 remover-item"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="bi bi-info-circle me-1"></i>
                        A solicitação ficará pendente. O estoque será reduzido somente quando a entrega for confirmada.
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-send me-1"></i>Enviar solicitação</button>
                        <button class="btn btn-outline-secondary btn-sm" type="reset">Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h6 text-info-emphasis">Como funciona</h2>
                <ol class="small text-muted mb-0 ps-3">
                    <li class="mb-2">Você informa os itens e a justificativa.</li>
                    <li class="mb-2">O administrador analisa o pedido.</li>
                    <li class="mb-2">As quantidades podem ser aprovadas total ou parcialmente.</li>
                    <li>A baixa acontece apenas na entrega.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('itensSolicitacao');
    const adicionar = document.getElementById('adicionarItem');

    adicionar.addEventListener('click', function () {
        const novo = container.firstElementChild.cloneNode(true);
        novo.querySelector('select').value = '';
        novo.querySelector('input').value = '';
        container.appendChild(novo);
    });

    container.addEventListener('click', function (event) {
        const botao = event.target.closest('.remover-item');
        if (!botao) return;
        if (container.children.length === 1) {
            botao.closest('.solicitacao-item').querySelector('select').value = '';
            botao.closest('.solicitacao-item').querySelector('input').value = '';
            return;
        }
        botao.closest('.solicitacao-item').remove();
    });
});
</script>

<?php estoqueDemoRodape(); ?>

