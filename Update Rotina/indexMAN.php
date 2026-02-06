<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização WebCaixa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-1 fw-bold text-danger">Sistema WebCaixa</h1>
        <h2 class="display-6">Oops! No momento estamos em manutenção.</h2>
        <p class="lead">Aguarde alguns instantes que estamos atualizando o sistema, logo que possível retornarei.</p>

        <!-- Contador regressivo -->
        <div class="mt-4">
            <h3 class="text-primary">Tempo estimado para retorno:</h3>
            <div id="countdown" class="display-4 fw-bold text-success">20:00</div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // Configuração do contador regressivo (20 minutos)
        const totalTime = 60 * 60; // 30 minutos em segundos
        const countdownKey = 'manutencao_countdown';
        const startTimeKey = 'manutencao_start_time';

        function getRemainingTime() {
            const now = Math.floor(Date.now() / 1000);
            const startTime = localStorage.getItem(startTimeKey);

            if (startTime) {
                const elapsed = now - parseInt(startTime);
                const remaining = totalTime - elapsed;
                return Math.max(0, remaining); // Não retorna negativo
            } else {
                // Primeira vez - inicia o contador
                localStorage.setItem(startTimeKey, now.toString());
                return totalTime;
            }
        }

        function updateCountdown() {
            let countdownTime = getRemainingTime();

            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;

            // Formata para sempre mostrar 2 dígitos
            const formattedTime = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            document.getElementById('countdown').textContent = formattedTime;

            // Atualiza a cor baseada no tempo restante
            const countdownElement = document.getElementById('countdown');
            if (countdownTime <= 60) { // Menos de 1 minuto
                countdownElement.className = "display-4 fw-bold text-danger";
            } else if (countdownTime <= 300) { // Menos de 5 minutos
                countdownElement.className = "display-4 fw-bold text-warning";
            } else {
                countdownElement.className = "display-4 fw-bold text-success";
            }

            if (countdownTime > 0) {
                countdownTime--;
                // Salva o tempo atualizado
                const now = Math.floor(Date.now() / 1000);
                const newStartTime = now - (totalTime - countdownTime);
                localStorage.setItem(startTimeKey, newStartTime.toString());

                setTimeout(updateCountdown, 1000);
            } else {
                document.getElementById('countdown').textContent = "00:00";
                document.getElementById('countdown').className = "display-4 fw-bold text-danger";

                // Limpa o localStorage quando o tempo acaba
                localStorage.removeItem(startTimeKey);

                // Opcional: recarregar a página ou mostrar mensagem quando o tempo acabar
                setTimeout(() => {
                    alert("A manutenção deve ter sido concluída. Tente acessar novamente.");
                }, 1000);
            }
        }

        // Limpa o contador se for uma nova sessão de manutenção
        function checkNewMaintenance() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('reset')) {
                localStorage.removeItem(startTimeKey);
            }
        }

        // Inicia o contador quando a página carregar
        window.onload = function() {
            checkNewMaintenance();
            updateCountdown();
        };
    </script>
</body>
</html>