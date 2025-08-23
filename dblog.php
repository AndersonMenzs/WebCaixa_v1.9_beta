    <?php

     // Selecionando o Banco de Dados
	$db = mysqli_select_db ($conec, "cadfunc");
	   IF (! $conec)
	     { ?><br><br><br>
	      <font size='5' color='red'><center>Você não tem permissão para acessar este Banco de Dados<br><br>
	      Por favor. Contate o seu Administrador Web</center></font><?php
	     }
    ?>
