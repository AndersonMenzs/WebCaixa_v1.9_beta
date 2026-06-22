document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('estoqueSidebar');
    const backdrop = document.getElementById('estoqueSidebarBackdrop');
    const toggle = document.getElementById('estoqueSidebarToggle');
    const toastElement = document.getElementById('estoqueToast');
    const toastTexto = document.getElementById('estoqueToastTexto');
    const toast = toastElement ? bootstrap.Toast.getOrCreateInstance(toastElement, { delay: 3500 }) : null;

    function fecharSidebar() {
        if (!sidebar || !backdrop) return;
        sidebar.classList.remove('show');
        backdrop.classList.remove('show');
    }

    if (toggle && sidebar && backdrop) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        });
        backdrop.addEventListener('click', fecharSidebar);
    }

    document.querySelectorAll('form[data-demo-form]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const mensagem = form.dataset.demoMessage || 'Operação fictícia concluída. Nenhum dado foi gravado.';
            if (toastTexto) toastTexto.textContent = mensagem;
            if (toast) toast.show();
        });
    });

    document.querySelectorAll('[data-demo-action]').forEach(function (controle) {
        controle.addEventListener('click', function () {
            if (toastTexto) {
                toastTexto.textContent = controle.dataset.demoAction + ': simulação concluída sem alteração no banco.';
            }
            if (toast) toast.show();
        });
    });

    document.querySelectorAll('[data-confirm-demo]').forEach(function (controle) {
        controle.addEventListener('click', function (event) {
            if (!window.confirm(controle.dataset.confirmDemo)) {
                event.preventDefault();
            }
        });
    });
});
