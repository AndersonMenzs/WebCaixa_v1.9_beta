<html>

<head>
    <title>WebCaixa v1.20.3_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
    body {
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        border: 3px solid gray;
        padding: 10px 10px 10px 10px;
        font-family: sans-serif;
    }

    .campos {
        background-color: #C0C0C0;
        font: 12px sans-serif;
        color: #000000;
    }
    </style>

    <script>
    function F5(event) {
        var tecla = document.all ? window.event.keyCode : event.which;
        if (document.all) {
            window.event.keyCode = 0;
            window.event.returnValue = false;
        }
        if (tecla == 116) return false;
    }

    document.onkeydown = F5;
    </script>

    <?php
      include "../cabecprs.php";
    ?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
    <?php
      for ($I=0; $I<=15; $I++)
	 {
	  echo "<br>";
	 }
   
   //mysqli_close($conec);
   //mysqli_close($conec_digital);
   
    ?>

    <meta http-equiv="refresh" content="0;URL=../index.php">
    <?php
      $SisRot = "S-7";
      include "../rodapext.php";
    ?>

</body>

</html>