function checkdata()
  {
   with(document.confentr)
     {
      if (txtconfirm.value != 'S' && txtconfirm.value != 'N')
	{
	 alert("Pagamento em Dinheiro?\nResponda\"S\" ou \"N\".");
	 txtconfirm.value = '';
	 txtconfirm.select();
	 txtconfirm.focus();
	 return false;
	}

      if ((txtmodpag.value == "10" && txtconfirm.value == 'N') || (txtmodpag.value != "10" && txtconfirm.value == 'S'))
	{
	 alert("Forma de Pagamento Incorreta!!!\n\nClique no Botão \"OK\", depois em \"Retornar\"\ne retifique a Forma de Pagamento.");
	 txtconfirm.value = '';
	 txtconfirm.select();
	 txtconfirm.focus();
	 return false;
	}

      if (txtsen.value.length != 6 || txtsen.value == '')
	{
	 alert("Senha Incompleta ou Inexistente!!!");
	 txtsen.select();
	 txtsen.focus();
	 return false;
	}
      submit();
     }
  }
