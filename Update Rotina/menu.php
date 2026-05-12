<html>
  <head>
    <title>WebCaixa v1.20.7_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

   <?php
    // Autorizando o Login
       $lg_user = $_REQUEST['c_s'];

       if ($lg_user == "")
	 {
	  $user    = $_POST['idinc'];
	    $user_full = 100000000 + $user;
	    $log_aut = substr($user_full,1,8);
	  $senha   = strtolower($_POST['idpass']);
	     $s0   = substr($senha,0,1);
	     $s1   = substr($senha,1,1);
	     $s2   = substr($senha,2,1);
	     $s3   = substr($senha,3,1);
	     $s4   = substr($senha,4,1);
	     $s5   = substr($senha,5,1);
	  $pss_aut = SHA1($senha);

	  if ($s0 >= '0' and $s0 <= '9')
	    {
	     $s0 = 1;
	    } else {
		    $s0 = 0;
		   }

	  if ($s1 >= '0' and $s1 <= '9')
	    {
	     $s1 = 1;
	    } else {
		    $s1 = 0;
		   }

	  if ($s2 >= '0' and $s2 <= '9')
	    {
	     $s2 = 1;
	    } else {
		    $s2 = 0;
		   }

	  if ($s3 >= '0' and $s3 <= '9')
	    {
	     $s3 = 1;
	    } else {
		    $s3 = 0;
		   }

	  if ($s4 >= '0' and $s4 <= '9')
	    {
	     $s4 = 1;
	    } else {
		    $s4 = 0;
		   }

	  if ($s5 >= '0' and $s5 <= '9')
	    {
	     $s5 = 1;
	    } else {
		    $s5 = 0;
		   }

	  $soma = $s0 + $s1 + $s2 + $s3 + $s4 + $s5;

	 } else
	       {
	        $log_aut = substr($lg_user,0,8);
		$pss_aut = substr($lg_user,8,40);
	       } ?>
  </head>

  <body background="./images/bg1.jpg">
     <meta http-equiv="refresh" content="0;URL=./studio?c_s=<?php
		echo $log_aut.$pss_aut.$soma; ?>">
  </body>
</html>
