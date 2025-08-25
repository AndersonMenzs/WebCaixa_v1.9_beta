document.getElementById("ghost_click").addEventListener("click", function(event) {
    const botao = event.currentTarget;

    // Desativa o botão temporariamente para evitar cliques múltiplos
    botao.disabled = true;

    const form = botao.form;

    // Define o tempo de espera em segundos
    let countdown = 2; 

    // Exibe a contagem regressiva
    const msgElement = document.getElementById("msg");
    //msgElement.innerText = `Aguarde... ${countdown}s`;
    msgElement.innerText = `Aguarde...`;

    // Cria um intervalo para atualizar a mensagem a cada segundo
    const interval = setInterval(() => {
        countdown--;
        if (countdown > 0) {
            //msgElement.innerText = `Aguarde... ${countdown}s`;
            msgElement.innerText = `Aguarde...`;
        } else {
            // Quando o tempo acabar, limpa o intervalo, reativa o botão e submete o formulário
            clearInterval(interval);
            botao.disabled = false;
            msgElement.innerText = "";
            form.submit();
        }
    }, 1000); // Atualiza a cada 1 segundo
});

