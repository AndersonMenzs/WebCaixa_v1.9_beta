// Foca no elemento do formulário
function putFocus(formInst, elementInst) {
    var form = document.forms[formInst];
    if (form && form.elements[elementInst]) {
        form.elements[elementInst].focus();
    }
}

// Validação de Número
function validNumero(field) {
    var valid = /^[0-9]+$/;
    if (!valid.test(field.value)) {
        //showError("Entrada Incorreta! \n Digite Apenas Números!");
        clearAndFocus(field);
    }
}


// Validação de Nome
function validNome(field) {
    var valid = /^[A-Z\s]+$/;
    if (!valid.test(field.value)) {
        //showError("Entrada Incorreta! \n  Digite Apenas Letras!");
        clearAndFocus(field);
    }
}

// Validação de Complemento
function validComplemento(field) {
    var valid = /^[A-Z.\-/0-9\s]+$/;
    if (!valid.test(field.value)) {
        //showError("Entrada Incorreta! \n  Digite Apenas Letras, Pontos, Traços e Barras!");
        clearAndFocus(field);
    }
}

// Validação de Data
function validaData(field) {
    var valid = /^[0-9/]+$/;
    if (!valid.test(field.value)) {
        //showError("Entrada Incorreta! \n  Digite apenas números!");
        clearAndFocus(field);
    }
}

function validateDate() {
    var userInput = document.getElementById('txt_venc').value;
    var inputDate = new Date(userInput);
    var currentDate = new Date();
    var fortyFiveDaysInMillis = 45 * 24 * 60 * 60 * 1000;
    var differenceInMilliseconds = inputDate - currentDate;

    if (differenceInMilliseconds > fortyFiveDaysInMillis) {
        alert('A data está fora do período de 45 dias.');
        document.getElementById('txt_venc').value = '';
    }
}

// Formata Data
function formataData(Formulario, Campo, TeclaPres) {
    var tecla = TeclaPres.keyCode;
    var strCampo;
    var vr;
    var tam;
    var TamanhoMaximo = 10;

    eval("strCampo = document." + Formulario + "." + Campo);

    vr = strCampo.value.replace(/[^\d]/g, '');
    tam = vr.length;

    if (tam < TamanhoMaximo && tecla !== 8) {
        tam = vr.length + 1;
    }

    if (tecla === 8) {
        tam = tam - 1;
    }

    if (tecla === 8 || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)) {
        if (tam <= 4) {
            strCampo.value = vr;
        }
        if ((tam > 4) && (tam <= 7)) {
            strCampo.value = vr.substr(0, tam - 2) + '/' + vr.substr(tam - 2, tam);
        }
        if ((tam > 7) && (tam <= 10)) {
            strCampo.value = vr.substr(0, tam - 7) + '/' + vr.substr(tam - 7, 2) + '/' + vr.substr(tam - 5, tam);
        }
    }
}

// Validação de CPF
function validaCPF(field) {
    var valid = /^[0-9.\-]+$/;
    if (!valid.test(field.value)) {
        //showError("Entrada Incorreta! \n  Digite apenas algarismos!");
        clearAndFocus(field);
    }
}

// Formata CPF
function FormataCPF(Formulario, Campo, TeclaPres) {
    var tecla = TeclaPres.keyCode;
    var strCampo;
    var vr;
    var tam;
    var TamanhoMaximo = 11;

    eval("strCampo = document." + Formulario + "." + Campo);

    vr = strCampo.value;
    vr = vr.replace(/\D/g, '');
    tam = vr.length;

    if (tam < TamanhoMaximo && tecla != 8) {
        tam = vr.length + 1;
    }

    if (tecla == 8) {
        tam = tam - 1;
    }

    if (tecla == 8 || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)) {
        if (tam <= 3) {
            strCampo.value = vr;
        }
        if ((tam > 3) && (tam <= 6)) {
            strCampo.value = vr.substr(0, 3) + '.' + vr.substr(3, tam);
        }
        if ((tam > 6) && (tam <= 9)) {
            strCampo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(6, tam);
        }
        if (tam == 11) {
            if (vr == '11111111111' || vr == '00000000000') {
                alert('CPF inválido');
                strCampo.value = '';
            } else {
                strCampo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(6, 3) + '-' + vr.substr(9, tam);
            }
        }
    }
}

// Habilitar e Desabilitar CPF
function toggleCpfEdit() {
    var txtCpf = document.getElementById('txt_cpf');
    var txtCpfEditCheckbox = document.getElementById('txtcpf_edit');

    // Habilita/desabilita o campo de texto com base no estado do checkbox
    txtCpf.disabled = !txtCpfEditCheckbox.checked;
}

// Formata Valor
function FormataValor(form, campo, evento) {
    var keyCode = evento.keyCode;
    var campoElement = document.getElementById(campo);

    if (keyCode != 8 && keyCode != 46) { // permite backspace e delete
        if (keyCode < 48 || keyCode > 57) { // verifica se não é número
            evento.preventDefault();
        }
    }

    var valor = campoElement.value.replace(/[^\d]+/g, ''); // remove caracteres não numéricos

    // Remove zeros à esquerda
    valor = valor.replace(/^0+/, '');

    // Adiciona zeros à esquerda, se necessário
    while (valor.length < 3) {
        valor = '0' + valor;
    }

    // Adiciona ponto como separador de milhares
    var parteInteira = valor.substring(0, valor.length - 2).replace(/(\d)(?=(\d{3})+$)/g, '$1.');
    var parteDecimal = valor.substring(valor.length - 2);
    campoElement.value = parteInteira + "," + parteDecimal;
}

  // Formatar CEP
  function formatarCEP(input) {
    // Remove caracteres não numéricos
    var cep = input.value.replace(/\D/g, '');

    // Verifica se o CEP tem o tamanho correto
    if (cep.length === 8) {
        // Formata o CEP (XXXXX-XXX)
        cep = cep.substring(0, 5) + '-' + cep.substring(5);
    }

    // Atualiza o valor do input
    input.value = cep;
}

//Formata Telefone
function formatarTelefone(inputId) {
    // Obter o valor do input
    var input = document.getElementById(inputId);
    var numeroTelefone = input.value.replace(/\D/g, ''); // Remover caracteres não numéricos

    // Verificar se o número tem 10 dígitos (considerando o DDD)
    if (numeroTelefone.length === 10) {
        numeroTelefone = numeroTelefone.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
        input.value = numeroTelefone;
    } else if (numeroTelefone.length > 10) {
        alert('Número de telefone inválido. Por favor, insira um número válido.');
        input.value = ''; // Limpar o campo se o número for inválido
    }
}

// Habilitar e Desabilicar Nome Cliente
function toggleNomeClienteEdit() {
    var txtNomeCli = document.getElementById('txtnome_cli');
    var txtNomeCliEditCheckbox = document.getElementById('txtnome_cli_edit');

    // Habilita/desabilita o campo de texto com base no estado do checkbox
    txtNomeCli.disabled = !txtNomeCliEditCheckbox.checked;
}

// Habilitar e Desabilicar Nome Modelo
function toggleNomeModeloEdit() {
    var txtNomeMod = document.getElementById('txtnome_mod');
    var txtNomeModEditCheckbox = document.getElementById('txtnome_mod_edit');

    // Habilita/desabilita o campo de texto com base no estado do checkbox
    txtNomeMod.disabled = !txtNomeModEditCheckbox.checked;
}

// Habilitar e Desabilicar Telefones
function toggleTelFixoEdit() {
    var txtTelFixo = document.getElementById('txt_tel_fixo');
    var txtTelFixoEditCheckbox = document.getElementById('txt_tel_fixo_edit');

    // Habilita/desabilita os campos de telefone com base no estado do checkbox
    txtTelFixo.disabled = !txtTelFixoEditCheckbox.checked;
}

// Habilitar e Desabilicar Telefones
function toggleTelCelEdit() {
    var txtCel = document.getElementById('txt_cel');
    var txtTelCelEditCheckbox = document.getElementById('txt_tel_cel_edit');

    // Habilita/desabilita os campos de telefone com base no estado do checkbox
    txtCel.disabled = !txtTelCelEditCheckbox.checked;
}

// Habilitar e Desabilicar Telefones
function toggleTelCelRecEdit() {
    var txtRec = document.getElementById('txt_cel_rec');
    var txtTelRecEditCheckbox = document.getElementById('txt_tel_rec_edit');

    // Habilita/desabilita os campos de telefone com base no estado do checkbox
    txtRec.disabled = !txtTelRecEditCheckbox.checked;
}

// Validação e comparação do código do carnê
var codCarneConfirmada = false; // Variável para rastrear se o código foi confirmado

function isNumeric(value) {
    // Verifica se o valor é numérico
    if (/^\d+$/.test(value)) {
        return true;
    } else {
        alertAndClearField('Por favor, o código do carnê deve conter somente números.');
        return false;
    }
}

function alertAndClearField(message) {
    alert(message);
    // Limpa o campo para começar novamente
    document.getElementById('txt_num_carne').value = '';
}

function showConfirmationInput(input) {
    var confirmInput = document.getElementById('confirm_num_carne');

    // Se o código não foi confirmado, não permitir avançar para os campos seguintes
    if (!codCarneConfirmada) {
        // Se o comprimento do valor inserido for 6 e for numérico, mostra o campo de confirmação
        if (input.value.length === 6 && isNumeric(input.value)) {
            if (!confirmInput) {
                // Restante do código permanece inalterado...
                input.style.marginRight = '20px';

                confirmInput = document.createElement('input');
                confirmInput.type = 'password';
                confirmInput.name = 'txt_confirm_num_carne';
                confirmInput.size = '25';
                confirmInput.maxLength = '6';
                confirmInput.className = 'campos';
                confirmInput.placeholder = 'Confirmar número de carnê';
                confirmInput.required = true;
                confirmInput.id = 'confirm_num_carne';

                confirmInput.oninput = function() {
                    if (confirmInput.value.length === 6 && isNumeric(confirmInput.value)) {
                        compareCodCarnes(input, confirmInput);
                    }
                };

                input.parentNode.appendChild(confirmInput);

                confirmInput.focus();
            }
        }
    }
}

function compareCodCarnes(input, confirmInput) {
    // Obtém os valores inseridos
    var codcarne1 = input.value;
    var codcarne2 = confirmInput.value;

    // Verifica se ambos os códigos são numéricos
    if (isNumeric(codcarne1) && isNumeric(codcarne2)) {
        if (codcarne1 === codcarne2) {
            codCarneConfirmada = true;
            alert('Os códigos do carnê conferem. Aperte OK para continuar.');
        } else {
            alertAndClearField('Os códigos não coincidem. Por favor, insira códigos iguais.');
            confirmInput.parentNode.removeChild(confirmInput);
            input.focus();
            codCarneConfirmada = false;
        }
    } else {
        // Exibe um alerta se um dos códigos não for numérico
        alertAndClearField('Por favor, insira códigos numéricos.');
    }
}


    // Validação do tipo de pagamento Radio
    function validarRadio() {
        var radios = document.getElementsByName('tipo_pag');
        var checked = false;

        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                checked = true;
                break;
            }
        }

        if (!checked) {
            alert('Selecione uma forma de pagamento');
            marcarRadioErro();
        } else {
            limparRadioErro();
        }
    }

    function marcarRadioErro() {
        var radios = document.getElementsByName('tipo_pag');

        for (var i = 0; i < radios.length; i++) {
            radios[i].style.outline = '2px solid red';
        }
    }

    function limparRadioErro() {
        var radios = document.getElementsByName('tipo_pag');

        for (var i = 0; i < radios.length; i++) {
            radios[i].style.outline = '';  // Remover a borda vermelha
        }
    }

    function validarFormulario() {
        var nomeCli = document.getElementById('txtnome_cli').value;
        var nomeMod = document.getElementById('txtnome_mod').value;
        var cpf = document.getElementById('txt_cpf').value;
        var telCel = document.getElementById('txt_cel').value;
        var numCarne = document.getElementById('txt_num_carne').value;
        var vlrTotal = document.getElementById('txt_vlr_total').value;
        var vlrEntrada = document.getElementById('txt_vlr_entr').value;
        var tipoPagamento = document.querySelector('input[name="tipo_pag"]:checked');
        var vlrPrestIni1 = document.getElementById('txt_vlr_prest_ini_1').value;
        var vlrPrestIni2 = document.getElementById('txt_vlr_prest_ini_2').value;
        var qtdParc = document.getElementById('txt_qtd_parc').value;
        var diaVenc = document.getElementById('txt_venc').value;

        var camposVazios = [];

        if (nomeCli === '') {
            camposVazios.push('txtnome_cli');
        }

        if (nomeMod === '') {
            camposVazios.push('txtnome_mod');
        }

        if (cpf === '') {
            camposVazios.push('txt_cpf');
        }

        if (telCel === '') {
            camposVazios.push('txt_cel');
        }

        if (numCarne === '') {
            camposVazios.push('txt_num_carne');
        }

        if (vlrTotal === '') {
            camposVazios.push('txt_vlr_total');
        }

        if (vlrEntrada === '') {
            camposVazios.push('txt_vlr_entr');
        }

        if (!tipoPagamento) {
            camposVazios.push('tipo_pag');
        }   

        if (vlrPrestIni1 === '') {
            camposVazios.push('txt_vlr_prest_ini_1');
        }

        if (vlrPrestIni2 === '') {
            camposVazios.push('txt_vlr_prest_ini_2');
        }

        if (qtdParc === '') {
            camposVazios.push('txt_qtd_parc');
        }

        if (diaVenc === '') {
            camposVazios.push('txt_venc');
        }

        if (camposVazios.length > 0) {
            alert('Por favor, preencha todos os campos obrigatórios.');

            // Adiciona borda vermelha aos campos vazios
            camposVazios.forEach(function(campoId) {
                var campo = document.getElementById(campoId);
                campo.style.border = '3px solid red';

                // Adiciona um listener para remover a borda vermelha quando o campo for preenchido
                campo.addEventListener('input', function() {
                    campo.style.border = ''; // Remove a borda vermelha
                });
            });

            return false;
        }

        return true;
    }

    // Validar quantidade de parcelas
    function validarParcelas(input) {
        var numParcelas = input.value;

        if (numParcelas > 12) {
            showError("A quantidade de parcelas não pode ser maior que 12x. Por favor, insira um valor válido.");
            input.value = "";
            //input.style.border = "3px solid red"; // Adiciona uma borda vermelha para indicar erro
        } else {
            input.style.border = ""; // Remove a borda se o valor for válido
        }
    }

// Calcular os valores. Total, entrada e 1ª e 2ª prestação.

// Adiciona a classe 'blink' e inicia a função de remover a classe após 1 segundo
function startBlinking(element) {
    var count = 0;
    var blinkInterval = setInterval(function () {
        count++;
        element.style.border = (element.style.border === '3px solid red' ? 'none' : '3px solid red');
        if (count >= 10) {
            clearInterval(blinkInterval);
            element.style.border = 'none';
        }
    }, 200);
}

function validarEntrada() {

    var txtVlrEntr = document.getElementById('txt_vlr_entr');

    var vlr_total = document.getElementById('txt_vlr_total').value.replace(/\./g, '').replace(',', '.');
    var vlr_entr = document.getElementById('txt_vlr_entr').value.replace(/\./g, '').replace(',', '.');

    var porcentLimiteInferior_vlr_entr = 0.01;
    var porcentLimiteSuperior_vlr_entr = 0.8;

   if (vlr_entr < vlr_total * porcentLimiteInferior_vlr_entr || vlr_entr > vlr_total * porcentLimiteSuperior_vlr_entr || vlr_entr < 0) {
            
            // Calcular valores
            var max_vlr_entr = vlr_total * porcentLimiteInferior_vlr_entr;
            var min_vlr_entr = vlr_total * porcentLimiteSuperior_vlr_entr;
            
            var max_vlr_entr = max_vlr_entr.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });            
            var min_vlr_entr = min_vlr_entr.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            showError('O valor da entrada deve ser maior que ' + max_vlr_entr + ' e menor que ' + min_vlr_entr + ' do valor total do produto.');
        
            txtVlrEntr.value = "0,00";

            // Adicionar a classe de erro e estilos diretamente no JavaScript
            startBlinking(txtVlrEntr);

            document.getElementById("txt_vlr_entr").value = "0,00";
    
            // Adicionar um pequeno atraso antes de ajustar o foco
            setTimeout(function () {
                document.getElementById('txt_vlr_entr').focus();
            }, 0);
       
            return false;
    }

    return true;
}

function calcule_parcelas() {

    var txt_vlr_prest_ini_1 = document.getElementById('txt_vlr_prest_ini_1');
    var txt_vlr_prest_ini_2 = document.getElementById('txt_vlr_prest_ini_2');

    var vlr_total = document.getElementById('txt_vlr_total').value.replace(/\./g, '').replace(',', '.');
    var vlr_entr = document.getElementById('txt_vlr_entr').value.replace(/\./g, '').replace(',', '.');
    var vlr_prest_ini_1 = document.getElementById('txt_vlr_prest_ini_1').value.replace(/\./g, '').replace(',', '.');
    var vlr_prest_ini_2 = document.getElementById('txt_vlr_prest_ini_2').value.replace(/\./g, '').replace(',', '.');

    var porcentLimiteInferior_vlr_prest_ini = 0.01;
    var porcentLimiteSuperior_vlr_prest_ini = 0.8;

    // Valor restante a pagar após a entrada
    var vlr_restante = vlr_total - vlr_entr;

    // Verificar se todos os campos foram preenchidos antes de validar
    if (vlr_total && vlr_entr) {
        
        // Verificar primeira parcela
        if (vlr_prest_ini_1 < vlr_restante * porcentLimiteInferior_vlr_prest_ini ||
            vlr_prest_ini_1 > vlr_restante * porcentLimiteSuperior_vlr_prest_ini) {

                // Calcular valores
                var max_vlr_prest_ini_1 = vlr_restante * porcentLimiteInferior_vlr_prest_ini;
                var min_vlr_prest_ini_1 = vlr_restante * porcentLimiteSuperior_vlr_prest_ini;
            
                var max_vlr_prest_ini_1 = max_vlr_prest_ini_1.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });            
                var min_vlr_prest_ini_1 = min_vlr_prest_ini_1.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            
                showError('Valor da primeira parcela deve ser maior que ' + max_vlr_prest_ini_1 + ' e menor que ' + min_vlr_prest_ini_1 + ' do valor restante.');
        
                txt_vlr_prest_ini_1.value = "0,00";
    
                // Adicionar a classe de erro e estilos diretamente no JavaScript
                startBlinking(txt_vlr_prest_ini_1);

                document.getElementById('txt_vlr_prest_ini_1').value = "0,00";

                // Adicionar um pequeno atraso antes de ajustar o foco
                setTimeout(function () {
                    document.getElementById('txt_vlr_prest_ini_1').focus();
                }, 0);
       
                return false;
                
            }
        }

    // Valor restante a pagar após a entrada, a primeira parcela e a segunda parcela
    var vlr_restante2 = vlr_total - vlr_entr - vlr_prest_ini_1;

    // Verificar se todos os campos foram preenchidos antes de validar
    if (vlr_total && vlr_entr && vlr_prest_ini_1 && vlr_prest_ini_2) {
        
        // Verificar segunda parcela
        if (vlr_prest_ini_2 < vlr_restante2 * porcentLimiteInferior_vlr_prest_ini ||
            vlr_prest_ini_2 > vlr_restante2 * porcentLimiteSuperior_vlr_prest_ini) {

                // Calcular valores
                var max_vlr_prest_ini_2 = vlr_restante2 * porcentLimiteInferior_vlr_prest_ini;
                var min_vlr_prest_ini_2 = vlr_restante2 * porcentLimiteSuperior_vlr_prest_ini;
            
                var max_vlr_prest_ini_2 = max_vlr_prest_ini_2.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });            
                var min_vlr_prest_ini_2 = min_vlr_prest_ini_2.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                showError('Valor da segunda parcela deve ser maior que ' + max_vlr_prest_ini_2 + ' e menor que ' + min_vlr_prest_ini_2 + ' que o valor restante.');
        
                txt_vlr_prest_ini_2.value = "0,00";
    
                // Adicionar a classe de erro e estilos diretamente no JavaScript
                startBlinking(txt_vlr_prest_ini_2);
            
                document.getElementById("txt_vlr_prest_ini_2").value = "0,00";

                // Adicionar um pequeno atraso antes de ajustar o foco
                setTimeout(function () {
                    document.getElementById('txt_vlr_prest_ini_2').focus();
                }, 0);
            
                return false;
        }
    }

    return true;    
}

    function showError(message) {
        alert(message);
    }
    
    function clearAndFocus(field) {
        field.value = "";
        field.focus();
        field.select();
    }
    
    /*document.addEventListener("DOMContentLoaded", function() {
        var impressEspelhoButton = document.getElementById("impressEspelho");
        var btnImprimirCarne = document.getElementById("btnImprimirCarne");
    
        impressEspelhoButton.addEventListener("click", function(event) {
            event.preventDefault();
    
            // Use confirm em vez de alert para obter um valor booleano
            var confirmacao = confirm("As informações estão corretas?");
            
            if (confirmacao) {
                // Fazer uma requisição AJAX
                $.ajax({
                    url: 'carneimpressespelho.php',
                    type: 'GET',
                    dataType: 'html',
                    success: function(data) {
                        // Atualizar o conteúdo da página atual com o conteúdo da próxima página
                        $('#conteudo-da-pagina').html(data);
    
                        // Imprimir espelho gerado
                        window.print();

                        // Exibir o botão apenas se as informações estiverem corretas
                        var confirmacao2 = confirm("As informações estão corretas. Deseja imprimir o carnê?");
                        if (confirmacao2) {
                            /*btnImprimirCarne.style.display = 'inline-block';*/
                       /* } else {
                            // Aqui você pode adicionar a lógica para lidar com a rejeição da impressão do carnê
                            // window.location.href = "carneform.php?c_s=<?php echo $lg_user; ?>";
                        }
                    },
                    error: function() {
                        alert('Erro ao carregar a próxima página.');
                    }
                });
            } else {
                // Remover arquivo criado ou lidar com a rejeição
                // alert("As informações do documento não estão corretas.");
                // window.location.href = "carneform.php?c_s=<?php echo $lg_user; ?>";
            }
        });
    }); */
    
    