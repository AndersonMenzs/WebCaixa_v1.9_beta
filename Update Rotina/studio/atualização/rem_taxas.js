function checkdata()
  {
   with(document.frmundo)
     {
   var chave = confirm("Deseja Realmente Excluir\nas Alterações Realizadas em:  " + dtaltf.value  +"?") 
   if (chave != true)
          {
	   alert("Exclusão Cancelada pelo Usuário");
	   return false;
          }

      submit();
     }
  }
