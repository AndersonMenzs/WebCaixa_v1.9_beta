function checkdata()
  {
   with(document.recolhe)
     {
	 if (txtcash.value.length < 4 || txtcash.value < 0)
	   {
	    alert("Valor Incorreto!");
	    txtcash.select();
	    txtcash.focus();
	    return false;
	    }

	var cash = txtcash.value;
	var chave = confirm("Confirma o Valor da Gaveta R$ " + cash + "?") 

	if (chave != true)
          {
	   alert("Inclusão Não Realizada pela Caixa!");
	   return false;
          }

	var autaud = audit.value;
	if (autaud != 'ok')
	  {
	   var Fx = txtfch.value;
	   var chave2 = confirm("\t\t\tA - T - E - N - Ç - Ã - O !!!\n\nVocê tem Somente " + Fx + " Fechamento(s) Parcial(is) para Hoje!\n\nTem Certeza que Deseja Fazer o Fechamento do Caixa?") 

	   if (chave2 != true)
	     {
	      alert("Fechamento do Caixa Cancelado!");
	      return false;
	     }
	  }      submit();
     }
  }
