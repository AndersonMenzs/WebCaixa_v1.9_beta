document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('estoqueSidebar');
    const sidebarBackdrop = document.getElementById('estoqueSidebarBackdrop');
    const sidebarToggle = document.getElementById('estoqueSidebarToggle');
    const busca = document.getElementById('filtroBusca');
    const categoria = document.getElementById('filtroCategoria');
    const finalidade = document.getElementById('filtroFinalidade');
    const situacao = document.getElementById('filtroSituacao');
    const limpar = document.getElementById('limparFiltros');
    const linhas = Array.from(document.querySelectorAll('#estoqueTabela tr[data-codigo]'));
    const semResultados = document.getElementById('semResultados');
    const resultadoContagem = document.getElementById('resultadoContagem');
    const toastElement = document.getElementById('estoqueToast');
    const toastTexto = document.getElementById('estoqueToastTexto');
    const toast = toastElement ? bootstrap.Toast.getOrCreateInstance(toastElement, { delay: 3200 }) : null;
    let itemDetalhado = null;

    function fecharSidebar() {
        if (!sidebar || !sidebarBackdrop) return;
        sidebar.classList.remove('show');
        sidebarBackdrop.classList.remove('show');
    }

    if (sidebarToggle && sidebar && sidebarBackdrop) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            sidebarBackdrop.classList.toggle('show');
        });

        sidebarBackdrop.addEventListener('click', fecharSidebar);
        sidebar.querySelectorAll('a, button').forEach(function (controle) {
            controle.addEventListener('click', function () {
                if (window.innerWidth < 992) fecharSidebar();
            });
        });
    }

    function normalizar(texto) {
        return String(texto || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();
    }

    function filtrarTabela() {
        const termo = normalizar(busca.value);
        let visiveis = 0;

        linhas.forEach(function (linha) {
            const correspondeBusca =
                normalizar(linha.dataset.codigo).includes(termo) ||
                normalizar(linha.dataset.nome).includes(termo);
            const correspondeCategoria = !categoria.value || linha.dataset.categoria === categoria.value;
            const correspondeFinalidade = !finalidade.value || linha.dataset.finalidade === finalidade.value;
            const correspondeSituacao = !situacao.value || linha.dataset.situacao === situacao.value;
            const mostrar = correspondeBusca && correspondeCategoria &&
                correspondeFinalidade && correspondeSituacao;

            linha.classList.toggle('d-none', !mostrar);
            if (mostrar) visiveis += 1;
        });

        semResultados.classList.toggle('d-none', visiveis !== 0);
        resultadoContagem.textContent = visiveis + (visiveis === 1 ? ' item encontrado' : ' itens encontrados');
    }

    [busca, categoria, finalidade, situacao].forEach(function (campo) {
        campo.addEventListener(campo === busca ? 'input' : 'change', filtrarTabela);
    });

    limpar.addEventListener('click', function () {
        busca.value = '';
        categoria.value = '';
        finalidade.value = '';
        situacao.value = '';
        filtrarTabela();
        busca.focus();
    });

    document.querySelectorAll('.ver-item').forEach(function (botao) {
        botao.addEventListener('click', function () {
            const item = JSON.parse(botao.dataset.item);
            const situacoes = {
                normal: 'Normal',
                baixo: 'Estoque baixo',
                zerado: 'Sem estoque',
                vencendo: 'Vencendo'
            };

            itemDetalhado = item;
            document.getElementById('modalDetalhesTitulo').textContent = item.nome;
            document.getElementById('detalheCodigo').textContent = item.codigo;
            document.getElementById('detalheCategoria').textContent = item.categoria;
            document.getElementById('detalheFinalidade').textContent = item.finalidade;
            document.getElementById('detalheSaldo').textContent = item.quantidade + ' ' + item.unidade;
            document.getElementById('detalheMinimo').textContent = item.minimo + ' ' + item.unidade;
            document.getElementById('detalheLocalizacao').textContent = item.localizacao;
            document.getElementById('detalheValidade').textContent = item.validade;
            document.getElementById('detalheCusto').textContent =
                Number(item.custo).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            document.getElementById('detalheSituacao').textContent = situacoes[item.situacao];
        });
    });

    const modalSolicitacao = document.getElementById('modalSolicitacao');

    function preencherSolicitacao(nome, saldo, unidade) {
        document.getElementById('solicitacaoItem').textContent = nome || 'Selecione um item';
        document.getElementById('solicitacaoSaldo').textContent = nome
            ? 'Saldo exibido: ' + saldo + ' ' + unidade + '. A disponibilidade será confirmada na análise.'
            : 'Solicitação geral: o item será selecionado na versão integrada.';
    }

    if (modalSolicitacao) {
        modalSolicitacao.addEventListener('show.bs.modal', function (evento) {
            const botao = evento.relatedTarget;
            if (botao && botao.classList.contains('solicitar-do-detalhe') && itemDetalhado) {
                preencherSolicitacao(itemDetalhado.nome, itemDetalhado.quantidade, itemDetalhado.unidade);
                return;
            }

            preencherSolicitacao(
                botao ? botao.dataset.item : '',
                botao ? botao.dataset.saldo : '',
                botao ? botao.dataset.unidade : ''
            );
        });
    }

    document.getElementById('formSolicitacao').addEventListener('submit', function (evento) {
        evento.preventDefault();
        if (!evento.currentTarget.checkValidity()) {
            evento.currentTarget.reportValidity();
            return;
        }

        bootstrap.Modal.getInstance(modalSolicitacao).hide();
        evento.currentTarget.reset();
        toastTexto.textContent = 'Solicitação fictícia enviada. Nenhum dado foi gravado.';
        toast.show();
    });

    document.querySelectorAll('.acao-demo').forEach(function (botao) {
        botao.addEventListener('click', function () {
            toastTexto.textContent = botao.dataset.acao + ': ação disponível apenas para demonstração.';
            toast.show();
        });
    });
});
