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
      submit();
     }
  }
