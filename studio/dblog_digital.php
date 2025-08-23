    <?php

     // Selecionando o Banco de Dados
	$db_digital = mysqli_select_db ($conec_digital, "cadfunc");
	   IF (! $conec_digital)
	     { ?>
	      <br><br><br><font size='5' color='red'><center>Você não tem permissão para acessar este Banco de Dados<br><br>
	      Por favor. Contate o seu Administrador Web</center></font><?php
	     }
    ?>
