<html>
  <body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
	 <td width='13%'>
	    <img align="center"
	       width="80"
	       height="80"
	       alt="Estrella Trade Mark"
	       hspace="10"
	       vspace="0"
	       src=images/estrella.gif>
	 </td>
	 <td width='74%' align="center">
	   <?php
	     echo "<font face='Arial', 'Courier', 'Verdana' size='6' color='blue'>";
	     echo "<b><i><center>ESTRELLA PHOTO STUDIO&nbsp;</center></i></b></font>";
	   ?>
	 </td>

	 <td width="13%" align="center">
	   <?php
	     $data = date("d/m/Y");
	     $hora = date("H:i");
	     $dia  = date("w");

	     Switch($dia)
	       {
		case 0: $diaSem='Domingo';
		break;

		case 1: $diaSem='Segunda-Feira';
		break;

		case 2: $diaSem='Terça-Feira';
		break;

		case 3: $diaSem='Quarta-Feira';
		break;

		case 4: $diaSem='Quinta-Feira';
		break;

		case 5: $diaSem='Sexta-Feira';
		break;

		case 6: $diaSem='Sábado';
		break;
	       }
	     echo "<font face='Arial', 'Courier', 'Verdana' size='4' color='#FFFFFF'>";
	     echo "<i><b>$diaSem<font color='brown'> $data <font color='darkgreen'> $hora</b></i></font>";
	   ?>
	 </td>
      </tr>
    </table><hr size='2' color='gray'>
  </body>
</html>
