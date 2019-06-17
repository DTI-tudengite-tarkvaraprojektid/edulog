<?php
    include('../../config.php');

?>

  <head>
    <link
      rel="stylesheet"
      type="text/css"
      href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <title>EduLog</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="../navbar.js"></script>

    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>



    <link rel="stylesheet" href="../css/style.css" type="text/css" />

  </head>

  <body>
    <?php include "../navbar/navbar.php" ?>
    <div class="container-fluid">
      <ul class="settings-layout">
        <li><a href="room-settings.php">Klassid</a></li>
        <li><a href="#">Tegevused</a></li>
        <li><a href="#">Suvaline #1</a></li>
        <li><a href="#">Suvaline #2</a></li>
        <li><a href="#">Suvaline #3</a></li>
        <li><a href="#">Suvaline #4</a></li>
      </ul>
    </div>
  </body>
</html>
