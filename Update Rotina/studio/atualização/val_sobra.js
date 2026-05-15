function checkdata()
  {
   with(document.audsobra)
     {
	 if (txtsobra.value == "" || txtsobra.value == 0 || txtsobra.value.length < 4)
	   {
	    alert("Valor da Sobra Incorreto!");
	    txtsobra.select();
	    txtsobra.focus();
	    return false;
	    }

	var sobra = txtsobra.value;
	var chave = confirm("Deseja Realmente Adicionar " + sobra + " ao Saldo de Caixa?");
	if (chave != true)
          {
	   alert("Inclusão Cancelada pela Auditora");
	   return false;
          }
      submit();
     }
  }
