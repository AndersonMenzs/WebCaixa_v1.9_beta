$(function() {
    $("#pesquisa").keyup(function() {
        // RECUPERAO VALOR DO CAMPO
        var pesquisa = $(this).val();
        // VERIFICAR SE HÁ ALGO DIGITADO
        if(pesquisa != '') {
            var dados = {
                palavra : pesquisa
            }
            $.post('proc_pesq_user.php', dados, function(retorna) {
                // MOSTRAR DENTRODE UMA ul O RESULTADO OBTIDO
                $(".resultado").html(retorna);
            });
        }
    });
});