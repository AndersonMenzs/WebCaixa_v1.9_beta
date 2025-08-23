function checkdata()
  {
   with(document.pgtos)
     {
	 if (txtcod.value.length != 6)
	   {
	    alert("Código Incorreto!!!");
	    txtcod.select();
	    txtcod.focus();
	    return false;
	    }

	 if (txtvalor.value.length < 3)
	   {
	    alert("Valor Incorreto!!!");
	    txtvalor.select();
	    txtvalor.focus();
	    return false;
	    }

	 var recolhe = txtvalor.value * 100;
	 var caixa   = txtcaixa.value * 100;
	 if (recolhe > caixa)
	   {
	    alert("Saldo do Caixa Inferior ao Valor Informado!!!\n\nSaldo do Caixa: R$ " + txtcaixa.value + "\nDespesa:  R$ " + txtvalor.value);
	    txtcaixa.select();
	    txtcaixa.focus();
	    return false;
	    }

	 if (lsPr.value == "0")
	   {
	    alert("Selecione uma Opção de Despesa!!!");
	    return false;
	    }
      submit();
     }
  }
