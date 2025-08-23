<?php
$conec_digital = mysqli_connect('localhost', 'root', 'cpd@cloud');

// Verificar a conexão
if (!$conec_digital) {
    // Logar detalhes do erro (isso pode ser ajustado para um local específico no seu ambiente)
    error_log("Falha na conexão: " . mysqli_connect_error());

    // Mensagem amigável para o usuário
    ?>
    <br><br><br>
    <font size='5' color='red'>
        <center>
            Não foi possível conectar-se ao Servidor de Banco de Dados.<br>
            Por favor, contate seu Administrador Web.
        </center>
    </font>
    <?php
    // Encerrar o script ou realizar outras ações necessárias em caso de falha de conexão
    exit();
}
?>
