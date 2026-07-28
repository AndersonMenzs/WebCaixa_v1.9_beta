function dataValida(valor, nomeCampo) {
  var data = new Date();
  var dia = data.getDate();
  var mes = data.getMonth() + 1;
  var ano = data.getFullYear();

  if (valor == "" || valor == " " || valor.length != 10) {
    alert("Data de " + nomeCampo + " Incorreta!");
    return false;
  }

  if (valor.substr(2, 1) != "/" || valor.substr(5, 1) != "/") {
    alert("Data de " + nomeCampo + " Incorreta!");
    return false;
  }

  var diaCampo = parseInt(valor.substr(0, 2), 10);
  var mesCampo = parseInt(valor.substr(3, 2), 10);
  var anoCampo = parseInt(valor.substr(6, 4), 10);

  if (isNaN(diaCampo) || isNaN(mesCampo) || isNaN(anoCampo)) {
    alert("Data de " + nomeCampo + " Incorreta!");
    return false;
  }

  if (anoCampo > ano || (anoCampo == ano && mesCampo > mes) || (anoCampo == ano && mesCampo == mes && diaCampo > dia)) {
    alert("Data de " + nomeCampo + " Incorreta!");
    return false;
  }

  if (mesCampo < 1 || mesCampo > 12) {
    alert("Data de " + nomeCampo + " Incorreta!");
    return false;
  }

  var diasMes = [31, (anoCampo % 4 == 0 ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  if (diaCampo < 1 || diaCampo > diasMes[mesCampo - 1]) {
    alert("Data de " + nomeCampo + " Incorreta!");
    return false;
  }

  return true;
}

function campoPreenchido(valor) {
  return valor != "" && valor != " ";
}

function confirmaAlteracao(nomeCampo, valorAtual, valorNovo, prefixo) {
  var textoAtual = prefixo + valorAtual;
  var textoNovo = prefixo + valorNovo;
  var chave = confirm("Alterar " + nomeCampo + "\nDE: " + textoAtual + "   PARA: " + textoNovo + "?");

  if (chave != true) {
    alert("Alteração Cancelada pelo Usuário");
    return false;
  }

  return true;
}

function checkdata() {
  with (document.frmatual) {
    if (!dataValida(txtdtsenior.value, "Gratuidade Senior")) {
      txtdtsenior.select();
      txtdtsenior.focus();
      return false;
    }

    if (!dataValida(txtdtaghata.value, "Gratuidade Aghata")) {
      txtdtaghata.select();
      txtdtaghata.focus();
      return false;
    }

    if (!dataValida(txtdtrecolh.value, "Faixa Recolhimento")) {
      txtdtrecolh.select();
      txtdtrecolh.focus();
      return false;
    }

    if (!campoPreenchido(txtvrseniorn.value) && !campoPreenchido(txtvraghatan.value) && !campoPreenchido(txtvrrecolhn.value)) {
      alert("Nenhuma Alteração Registrada!");
      return false;
    }

    if (campoPreenchido(txtvrseniorn.value) && txtvrseniorn.value == txtvrsenior.value) {
      alert("Idade da Gratuidade Senior igual ao valor atual!");
      txtvrseniorn.select();
      txtvrseniorn.focus();
      return false;
    }

    if (campoPreenchido(txtvraghatan.value) && txtvraghatan.value == txtvraghata.value) {
      alert("Idade da Gratuidade Aghata igual ao valor atual!");
      txtvraghatan.select();
      txtvraghatan.focus();
      return false;
    }

    if (campoPreenchido(txtvrrecolhn.value) && txtvrrecolhn.value == txtvrrecolh.value) {
      alert("Faixa Recolhimento igual ao valor atual!");
      txtvrrecolhn.select();
      txtvrrecolhn.focus();
      return false;
    }

    if (campoPreenchido(txtvrseniorn.value) && !confirmaAlteracao("Gratuidade Senior", txtvrsenior.value, txtvrseniorn.value, "")) {
      return false;
    }

    if (campoPreenchido(txtvraghatan.value) && !confirmaAlteracao("Gratuidade Aghata", txtvraghata.value, txtvraghatan.value, "")) {
      return false;
    }

    if (campoPreenchido(txtvrrecolhn.value) && !confirmaAlteracao("Faixa Recolhimento", txtvrrecolh.value, txtvrrecolhn.value, "R$ ")) {
      return false;
    }
  }

  return true;
}
