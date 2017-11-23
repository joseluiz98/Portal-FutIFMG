    <?php
    require_once("C:\wamp64\www\wp-includes\mysql\credentials.php");
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
      <title>Bootstrap Example</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

    <div class="container">  
      <div id="myCarousel" class="carousel slide" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" style="color: lightgray""></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" style="color: lightgray""></span>
          <span class="sr-only">Próximo</span>
        </a>

          <div class="item" style="border: 1px solid #c0c0c0;">
            <h1>Quartas de Final</h1>
            <div class="fourthGame1">
              <?php
                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (13,14,15,16) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
                $sql2 = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (13,14,15,16) and idTime = idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
                $conn = new PDO('mysql:host=localhost;dbname='.$dbname, $dbuser, $dbpass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $resultCasa = $conn->prepare($sql);
                $resultCasa->execute();

                $resultVisitante = $conn->prepare($sql2);
                $resultVisitante->execute();

                while($rowCasa = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
                  echo '<div class="game">';
                  echo $rowCasa["nomeTime"];
                  echo " " . $rowCasa["placarCasa"];
                  echo ' x ';
                  echo $rowVisitante["placarVisitante"]. " ";
                  echo $rowVisitante["nomeTime"];
                  echo '</div>';
                  /*echo $resultCasa[i].["escudo"];
                  echo $resultCasa[i].["placarCasa"];
                  echo ' x ';
                  echo $resultVisitante[i].["nomeTime"];
                  echo $resultVisitante[i].["escudo"];
                  echo $resultVisitante[i].["placarCasa"];*/
                }
              ?> 
            </div>
          </div>
        
          <div class="item" style="border: 1px solid #c0c0c0;">
            <h3>Slider content</h3>
          </div>

          <div class="item active" style="border: 1px solid #c0c0c0;">
            <h3>Slider content</h3>
          </div>
        </div>
      </div>
    </div>

    </body>
    </html>
