function checkdata()
  {
   with(document.dev)
     {
	 if (lsPrd.value == "00")
	   {
	    alert("Escolha um Produto!!!");
	    return false;
	    }

	 if (txtqtd.value == '')
	   {
	    alert("Campo Quantidade em Branco!!!");
	    txtqtd.select();
	    txtqtd.focus();
	    return false;
	    }

	 if (txtrec.value.length < 3)
	   {
	    alert("Campo Nome do Recebedor Não Preenchido\n ou com menos de 3 Caracteres!!!");
	    txtrec.select();
	    txtrec.focus();
	    return false;
	    }
      submit();
     }
  }
