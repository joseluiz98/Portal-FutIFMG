<?php
    require_once("C:\wamp64\www\wp-includes\mysql\credentials.php");
 ?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://futifmg.serveblog.net:8080/wp-includes/css/pageJogos.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="http://futifmg.serveblog.net:8080/wp-includes/js/pageJogos.js"></script>
</head>
<body>
	<div class="carousel">
		<nav class="carousel-buttons">
			<div class="col-sm-4"><h2><a class="glyphicon glyphicon-chevron-left" id="prev"></a></h2></div>
			<div class="col-sm-4"><span id="chave-titulo"><h3>Título da Chave</h3></span></div>
			<div class="col-sm-4"><h2><a class="glyphicon glyphicon-chevron-right" id="prox"></a></h2></div>
		</nav>

		<div class="content">
			<div id="item active" style="border: 1px solid #c0c0c0;">
				<span id="currentContentTitle"><h2>Quartas de Final</h2></span>
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
			<div id="item" style="border: 1px solid #c0c0c0;">
				<span id="currentContentTitle"><h2>Semifinais</h2></span>

				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam volutpat congue ultricies. In vitae ullamcorper massa. Quisque mauris lectus, varius sit amet egestas ac, semper a justo. Maecenas sed tellus eu ante porttitor pellentesque in eget dolor. Nullam faucibus sollicitudin venenatis. Donec fringilla augue id felis porttitor congue. Mauris vitae lectus scelerisque, mattis tortor egestas, cursus felis. Phasellus ullamcorper mi in arcu condimentum sollicitudin. Cras est velit, luctus ut diam ut, rutrum pharetra risus. Morbi porttitor lectus metus, ac molestie turpis mattis sit amet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque eu nibh sed ligula fermentum condimentum.
			</div>

			<div id="item" style="border: 1px solid #c0c0c0;">
				<span id="currentContentTitle"><h2>Finais</h2></span>

				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam volutpat congue ultricies. In vitae ullamcorper massa. Quisque mauris lectus, varius sit amet egestas ac, semper a justo. Maecenas sed tellus eu ante porttitor pellentesque in eget dolor. Nullam faucibus sollicitudin venenatis. Donec fringilla augue id felis porttitor congue. Mauris vitae lectus scelerisque, mattis tortor egestas, cursus felis. Phasellus ullamcorper mi in arcu condimentum sollicitudin. Cras est velit, luctus ut diam ut, rutrum pharetra risus. Morbi porttitor lectus metus, ac molestie turpis mattis sit amet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque eu nibh sed ligula fermentum condimentum.
			</div>
		</div>
	</div>
</body>
</html>