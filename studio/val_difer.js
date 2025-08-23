function checkdata()
  {
   with(document.auddifer)
     {
      var codex    = txtcodex.value * 1;
      var fator    = codex * 1.822;
      var fator2   = fator.toString();
      var operando = fator2.substring(0,6);

      if (txtwa.value != operando)
	{
	 alert("Contra-Senha Incorreta!");
	 txtwa.select();
	 txtwa.focus();
	 return false;
	}

      if (txtdifer.value == "" || txtdifer.value == 0 || txtdifer.value.length < 4)
	{
	 alert("Valor Incorreto!");
	 txtdifer.select();
	 txtdifer.focus();
	 return false;
	}

      if (lsOp.value == "S")
	{
	 alert("Você Precisa Selecionar uma Operação!");
	 return false;
	}

      var difer = txtdifer.value;

      if (lsOp.value == "D")
	   {
	    var chave = confirm("Deseja Realmente Debitar " + difer + " do Saldo Inicial do Caixa?");
	   } else {
		   var chave = confirm("Deseja Realmente Creditar " + difer + " ao Saldo Inicial do Caixa?");
		  }

      if (chave != true)
        {
	 alert("Operação Cancelada pela Auditora");
	 return false;
        }
      submit();
     }
  }
