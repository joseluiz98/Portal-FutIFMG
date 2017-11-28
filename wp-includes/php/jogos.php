<?php
    require_once("C:\wamp64\www\wp-includes\mysql\credentials.php");
 ?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/wp-includes/js/pageJogos.js"></script>
</head>
<body>
	<div class="carousel" style="border: 1px solid #c0c0c0;">
		<nav class="carousel-buttons">
			<div class="col-sm-4"><h2><a class="glyphicon glyphicon-chevron-left" id="prev" style="color: black"></a></h2></div>
			<div class="col-sm-4"><span id="chave-titulo"><h3></h3></span></div>
			<div class="col-sm-4"><h2><a class="glyphicon glyphicon-chevron-right" id="prox" style="color: black"></a></h2></div>
		</nav>

		<div class="content">
			<div id="item active" style="display: none;">
				<span id="currentContentTitle"><h2>Quartas de Final</h2></span>
            	<div class="fourthFinals">
	              <?php
	                $sqlCasa = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (13,14,15,16) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sqlVisitante = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (13,14,15,16) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
	                
	                $resultCasa = $conn->prepare($sqlCasa);
	                $resultCasa->execute();

	                $resultVisitante = $conn->prepare($sqlVisitante);
	                $resultVisitante->execute();

	                while($rowCasa = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
	                  echo '<div class="game">';
	                  echo $rowCasa["nomeTime"];
	                  echo " " . $rowCasa["placarCasa"];
	                  echo ' x ';
	                  echo $rowVisitante["placarVisitante"]. " ";
	                  echo $rowVisitante["nomeTime"];
	                  echo '</div>';
	                }
	              ?>
				</div>
			</div>

			<div id="item" style="display: none;">
				<span id="currentContentTitle"><h2>Semifinais</h2></span>
            	<div class="semiFinals">
	              <?php
	                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (17,18) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sql2 = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (17,18) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
	                
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
	                }
	              ?>
				</div>
			</div>

			<div id="item" style="display: none;">
				<span id="currentContentTitle"><h2>Finais</h2></span>
            	<div class="finals">
	              <?php
	                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (20) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sql2 = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (20) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";

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
	                }
	              ?>
				</div>

				<div class="thirdPlace" style="margin-top: 20px; margin-bottom: 10px;">
				<span id="thirdPlaceTitle" style="font-size: 24px;">Terceiro lugar</span>
	              <?php
	                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (19) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sql2 = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (19) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
	                $resultCasa = $conn->prepare($sql);
	                $resultCasa->execute();

	                $resultVisitante = $conn->prepare($sql2);
	                $resultVisitante->execute();

	                while($rowCasa = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
	                  echo '<div class="game" style="margin:15px">';
	                  echo $rowCasa["nomeTime"];
	                  echo " " . $rowCasa["placarCasa"];
	                  echo ' x ';
	                  echo $rowVisitante["placarVisitante"]. " ";
	                  echo $rowVisitante["nomeTime"];
	                  echo '</div>';
	                }
	              ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>